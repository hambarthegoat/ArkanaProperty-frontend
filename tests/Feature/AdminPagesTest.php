<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    private static function lead(array $overrides = []): array
    {
        return array_merge([
            'id' => 3, 'nama_calon' => 'Budi Santoso', 'no_telp' => '081122334455', 'pesan' => 'Ingin survey',
            'status_keseriusan' => 'pending', 'status_label' => 'Menunggu Validasi', 'prioritas' => null, 'prioritas_label' => null,
            'catatan' => null, 'has_ktp' => false, 'created_at' => '2026-10-14T09:00:00+07:00',
            'perumahan' => ['id' => 1, 'nama_perumahan' => 'Arkana Residence', 'lokasi' => 'Mayangan'],
            'tipe_rumah' => ['id' => 1, 'nama_tipe' => 'Tipe 36/60'], 'marketing' => null, 'akun_leads' => null,
        ], $overrides);
    }

    private static function perumahan(): array
    {
        return [[
            'id' => 1, 'nama_perumahan' => 'Arkana Residence', 'lokasi' => 'Kec. Mayangan', 'deskripsi' => null,
            'gambar_url' => null, 'status' => 'aktif', 'status_label' => 'Aktif', 'harga_mulai' => 162000000,
            'unit' => ['total' => 2, 'tersedia' => 1, 'booking' => 1, 'terjual' => 0],
            'tipe_rumah' => [['id' => 1, 'nama_tipe' => 'Tipe 36/60', 'jenis_rumah' => 'subsidi', 'jenis_rumah_label' => 'Subsidi', 'harga' => 162000000]],
        ]];
    }

    private static function kavling(): array
    {
        $tipe = ['id' => 1, 'nama_tipe' => 'Tipe 36/60', 'harga' => 162000000, 'perumahan' => ['id' => 1, 'nama_perumahan' => 'Arkana Residence']];

        return [
            ['id' => 10, 'blok' => 'Blok A', 'nomor_kavling' => 'A-01', 'status' => 'booking', 'status_label' => 'Booking', 'leads' => ['id' => 3, 'nama_calon' => 'Budi Santoso'], 'tipe_rumah' => $tipe],
            ['id' => 11, 'blok' => 'Blok A', 'nomor_kavling' => 'A-02', 'status' => 'tersedia', 'status_label' => 'Tersedia', 'leads' => null, 'tipe_rumah' => $tipe],
        ];
    }

    public function test_dashboard_shows_api_summary(): void
    {
        Http::fake(['api.test/api/admin/dashboard' => self::api([
            'leads' => ['total' => 5, 'pending' => 2, 'validated' => 2, 'rejected' => 1],
            'unit' => ['total' => 15, 'tersedia' => 9, 'booking' => 3, 'terjual' => 3],
            'perumahan' => 3, 'marketing' => 2,
            'leads_terbaru' => [self::lead()],
            'report_terbaru' => [['tanggal_report' => '2026-10-13', 'deskripsi_progres' => 'Survey Blok A', 'jenis_aktivitas' => 'survey_lokasi', 'jenis_aktivitas_label' => 'Survey Lokasi', 'marketing' => ['nama' => 'Dimas']]],
        ])]);

        $this->loginAs('admin')->get('/admin')
            ->assertOk()
            ->assertSee('2 lead menunggu validasi')
            ->assertSee('Budi Santoso')
            ->assertSee('Survey Blok A');

        Http::assertSent(fn (Request $r) => $r->hasHeader('Authorization', 'Bearer test-token'));
    }

    public function test_leads_page_forwards_filters_and_lists_marketing(): void
    {
        Http::fake([
            'api.test/api/admin/leads*' => self::api([self::lead()]),
            'api.test/api/admin/dashboard' => self::api(['leads' => ['total' => 1, 'pending' => 1, 'validated' => 0, 'rejected' => 0]]),
            'api.test/api/admin/marketing' => self::api([['id' => 2, 'nama' => 'Dimas Marketing']]),
        ]);

        $this->loginAs('admin')->get('/admin/leads?status=pending&search=budi')
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee('KTP belum ada')
            ->assertSee('Dimas Marketing');

        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'admin/leads?') && $r['status'] === 'pending' && $r['search'] === 'budi');
    }

    public function test_validate_flashes_one_time_credentials(): void
    {
        Http::fake(['api.test/api/admin/leads/3/validate' => self::api([
            'lead' => self::lead(['status_keseriusan' => 'validated', 'marketing' => ['nama' => 'Dimas']]),
            'kredensial' => ['username' => '081122334455', 'password' => 'Ab12Cd34', 'akun_baru' => true],
        ])]);

        $this->loginAs('admin')->from('/admin/leads')
            ->post('/admin/leads/3/validate', ['id_marketing' => 2])
            ->assertRedirect('/admin/leads')
            ->assertSessionHas('success', fn ($msg) => str_contains($msg, 'username 081122334455 / password Ab12Cd34'));

        Http::assertSent(fn (Request $r) => $r['is_valid'] === true && $r['id_marketing'] === 2);
    }

    public function test_validate_without_ktp_shows_api_error(): void
    {
        Http::fake(['api.test/api/admin/leads/3/validate' => self::api(null, 422, 'KTP belum diunggah.')]);

        $this->loginAs('admin')->from('/admin/leads')
            ->post('/admin/leads/3/validate', ['id_marketing' => 2])
            ->assertRedirect('/admin/leads')
            ->assertSessionHasErrors(['api' => 'KTP belum diunggah.']);
    }

    public function test_ktp_download_proxy_and_no_admin_upload(): void
    {
        Http::fake([
            'api.test/api/admin/leads/3/ktp' => Http::response('JPEGDATA', 200, ['Content-Type' => 'image/jpeg']),
        ]);

        $this->loginAs('admin')->get('/admin/leads/3/ktp')
            ->assertOk()
            ->assertHeader('Content-Type', 'image/jpeg')
            ->assertSee('JPEGDATA');

        $this->loginAs('admin')
            ->post('/admin/leads/3/ktp', ['file_ktp' => UploadedFile::fake()->image('ktp.jpg')])
            ->assertStatus(405);
    }

    public function test_leads_page_has_no_ktp_upload_and_preselects_assigned_marketing(): void
    {
        Http::fake([
            'api.test/api/admin/leads*' => self::api([self::lead(['id_marketing' => 2, 'has_ktp' => true, 'marketing' => ['id' => 2, 'nama' => 'Dimas Marketing']])]),
            'api.test/api/admin/dashboard' => self::api(['leads' => ['total' => 1, 'pending' => 1, 'validated' => 0, 'rejected' => 0]]),
            'api.test/api/admin/marketing' => self::api([['id' => 2, 'nama' => 'Dimas Marketing'], ['id' => 3, 'nama' => 'Rina']]),
        ]);

        $this->loginAs('admin')->get('/admin/leads')
            ->assertOk()
            ->assertSee('Lihat KTP')
            ->assertDontSee('type="file"', false)
            ->assertSee('<option value="2" selected>Dimas Marketing</option>', false)
            ->assertSee('Rina')
            ->assertDontSee('value="3" selected', false);
    }

    public function test_assign_marketing_posts_to_api_and_flashes_message(): void
    {
        Http::fake(['api.test/api/admin/leads/3/assign' => self::api(self::lead(['id_marketing' => 2, 'marketing' => ['id' => 2, 'nama' => 'Dimas']]))]);

        $this->loginAs('admin')->from('/admin/leads')
            ->post('/admin/leads/3/assign', ['id_marketing' => 2])
            ->assertRedirect('/admin/leads')
            ->assertSessionHas('success', fn ($msg) => str_contains($msg, 'ditugaskan ke Dimas'));

        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'admin/leads/3/assign') && $r['id_marketing'] === 2);
    }

    public function test_assign_requires_a_marketing_and_shows_api_errors(): void
    {
        Http::fake(['api.test/api/admin/leads/3/assign' => self::api(null, 422, 'Lead yang sudah divalidasi tidak bisa ditugaskan ulang.')]);

        $this->loginAs('admin')->from('/admin/leads')->post('/admin/leads/3/assign', [])->assertSessionHasErrors('id_marketing');

        $this->loginAs('admin')->from('/admin/leads')
            ->post('/admin/leads/3/assign', ['id_marketing' => 2])
            ->assertSessionHasErrors(['api' => 'Lead yang sudah divalidasi tidak bisa ditugaskan ulang.']);
    }

    public function test_leads_page_guides_admin_through_assign_then_validate(): void
    {
        Http::fake([
            'api.test/api/admin/leads*' => self::api([self::lead(['id' => 3]), self::lead(['id' => 4, 'nama_calon' => 'Siti', 'id_marketing' => 2, 'has_ktp' => false, 'marketing' => ['id' => 2, 'nama' => 'Dimas Marketing']])]),
            'api.test/api/admin/dashboard' => self::api(['leads' => ['total' => 2, 'pending' => 2, 'validated' => 0, 'rejected' => 0]]),
            'api.test/api/admin/marketing' => self::api([['id' => 2, 'nama' => 'Dimas Marketing']]),
        ]);

        $this->loginAs('admin')->get('/admin/leads')
            ->assertOk()
            ->assertSee('Tugaskan Marketing')
            ->assertSee(route('admin.leads.assign', 3), false)
            ->assertSee('Tugaskan marketing terlebih dahulu')
            ->assertSee('Menunggu marketing mengunggah KTP');
    }

    public function test_leads_page_tells_admin_ktp_comes_from_marketing(): void
    {
        Http::fake([
            'api.test/api/admin/leads*' => self::api([self::lead()]),
            'api.test/api/admin/dashboard' => self::api(['leads' => ['total' => 1, 'pending' => 1, 'validated' => 0, 'rejected' => 0]]),
            'api.test/api/admin/marketing' => self::api([]),
        ]);

        $this->loginAs('admin')->get('/admin/leads')->assertOk()->assertSee('KTP diunggah oleh marketing');
    }

    public function test_validate_without_marketing_param_lets_api_use_the_ktp_uploader(): void
    {
        Http::fake(['api.test/api/admin/leads/3/validate' => self::api([
            'lead' => self::lead(['status_keseriusan' => 'validated', 'marketing' => ['nama' => 'Dimas']]),
            'kredensial' => ['username' => '081122334455', 'password' => null, 'akun_baru' => false],
        ])]);

        $this->loginAs('admin')->from('/admin/leads')
            ->post('/admin/leads/3/validate', [])
            ->assertRedirect('/admin/leads')
            ->assertSessionHas('success');

        Http::assertSent(fn (Request $r) => $r['is_valid'] === true && ! isset($r['id_marketing']));
    }

    public function test_create_perumahan_without_house_type_sends_no_type(): void
    {
        Http::fake(['api.test/api/admin/perumahan' => self::api(['id' => 2, 'nama_perumahan' => 'Griya Baru'], 201)]);

        // The form always submits the jenis_rumah select, even when no type was typed.
        $this->loginAs('admin')
            ->post('/admin/perumahan', ['nama_perumahan' => 'Griya Baru', 'lokasi' => 'Kademangan', 'status' => 'aktif', 'tipe' => ['nama_tipe' => '', 'jenis_rumah' => 'subsidi', 'harga' => '', 'dp' => '']])
            ->assertRedirect(route('admin.perumahan'))
            ->assertSessionHas('success');

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && $r->isMultipart()
            && collect($r->data())->contains(fn ($p) => $p['name'] === 'nama_perumahan' && $p['contents'] === 'Griya Baru')
            && ! collect($r->data())->contains(fn ($p) => str_starts_with($p['name'], 'tipe_rumah')));
    }

    public function test_perumahan_page_has_edit_and_delete_controls(): void
    {
        Http::fake(['api.test/api/admin/perumahan' => self::api(self::perumahan())]);

        $this->loginAs('admin')->get('/admin/perumahan')
            ->assertOk()
            ->assertSee('data-edit-project', false)
            ->assertSee('data-edit-form', false)
            ->assertSee('name="_method" value="DELETE"', false)
            ->assertSee(route('admin.perumahan.destroy', 1), false);
    }

    public function test_update_perumahan_sends_multipart_put_override(): void
    {
        Http::fake(['api.test/api/admin/perumahan/1' => self::api(['id' => 1, 'nama_perumahan' => 'Arkana Baru'])]);

        $this->loginAs('admin')
            ->put('/admin/perumahan/1', ['nama_perumahan' => 'Arkana Baru', 'lokasi' => 'Kec. Baru', 'status' => 'pre_launch', 'deskripsi' => '', 'gambar' => UploadedFile::fake()->image('foto.jpg')])
            ->assertRedirect(route('admin.perumahan'))
            ->assertSessionHas('success', fn ($msg) => str_contains($msg, 'Arkana Baru'));

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && $r->isMultipart()
            && str_contains($r->url(), 'admin/perumahan/1')
            && collect($r->data())->contains(fn ($p) => $p['name'] === '_method' && $p['contents'] === 'PUT')
            && collect($r->data())->contains(fn ($p) => $p['name'] === 'status' && $p['contents'] === 'pre_launch')
            && collect($r->data())->contains(fn ($p) => $p['name'] === 'gambar'));
    }

    public function test_update_perumahan_shows_api_validation_errors(): void
    {
        Http::fake(['api.test/api/admin/perumahan/1' => self::api(['status' => ['The selected status is invalid.']], 422, 'Validation failed')]);

        $this->loginAs('admin')->from('/admin/perumahan')
            ->put('/admin/perumahan/1', ['nama_perumahan' => 'X', 'lokasi' => 'Y', 'status' => 'salah'])
            ->assertRedirect('/admin/perumahan')
            ->assertSessionHasErrors('status');
    }

    public function test_delete_perumahan_calls_api_delete(): void
    {
        Http::fake(['api.test/api/admin/perumahan/1' => self::api(null)]);

        $this->loginAs('admin')->delete('/admin/perumahan/1')
            ->assertRedirect(route('admin.perumahan'))
            ->assertSessionHas('success');

        Http::assertSent(fn (Request $r) => $r->method() === 'DELETE' && str_contains($r->url(), 'admin/perumahan/1'));
    }

    public function test_delete_perumahan_shows_the_api_refusal(): void
    {
        Http::fake(['api.test/api/admin/perumahan/1' => self::api(null, 422, 'Perumahan ini memiliki 2 lead sehingga tidak bisa dihapus.')]);

        $this->loginAs('admin')->from('/admin/perumahan')->delete('/admin/perumahan/1')
            ->assertRedirect('/admin/perumahan')
            ->assertSessionHasErrors(['api' => 'Perumahan ini memiliki 2 lead sehingga tidak bisa dihapus.'])
            ->assertSessionMissing('success');
    }

    public function test_marketing_accounts_page_lists_accounts_and_has_create_form(): void
    {
        Http::fake(['api.test/api/admin/marketing' => self::api([['id' => 2, 'username' => 'dimas', 'nama' => 'Dimas Marketing', 'no_telp' => '081211112222']])]);

        $this->loginAs('admin')->get('/admin/marketing')
            ->assertOk()
            ->assertSee('Dimas Marketing')
            ->assertSee('081211112222')
            ->assertSee(route('admin.marketing.store'), false)
            ->assertSee('name="password"', false)
            ->assertSee('Kelola Marketing');
    }

    public function test_create_marketing_account_posts_to_api(): void
    {
        Http::fake(['api.test/api/admin/marketing' => self::api(['id' => 7, 'username' => 'rina', 'role' => 'marketing'], 201)]);

        $this->loginAs('admin')->from('/admin/marketing')
            ->post('/admin/marketing', ['username' => 'rina', 'password' => 'rahasia123', 'nama' => 'Rina', 'no_telp' => '081299990001'])
            ->assertRedirect(route('admin.marketing'))
            ->assertSessionHas('success', fn ($msg) => str_contains($msg, 'rina'));

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && str_contains($r->url(), 'admin/marketing')
            && $r['username'] === 'rina' && $r['password'] === 'rahasia123' && $r['nama'] === 'Rina');
    }

    public function test_create_marketing_account_validates_locally_and_shows_api_errors(): void
    {
        Http::fake(['api.test/api/admin/marketing' => self::api(['username' => ['The username has already been taken.']], 422, 'Validation failed')]);

        $this->loginAs('admin')->from('/admin/marketing')
            ->post('/admin/marketing', ['username' => 'rina', 'password' => '123'])
            ->assertRedirect('/admin/marketing')
            ->assertSessionHasErrors('password');
        Http::assertNothingSent();

        $this->loginAs('admin')->from('/admin/marketing')
            ->post('/admin/marketing', ['username' => 'dimas', 'password' => 'rahasia123'])
            ->assertSessionHasErrors(['username' => 'The username has already been taken.'])
            ->assertSessionHasInput('username', 'dimas');
    }

    public function test_marketing_accounts_page_is_admin_only(): void
    {
        Http::fake();

        $this->loginAs('marketing')->get('/admin/marketing')->assertRedirect(route('marketing.dashboard'));
        $this->loginAs('marketing')->post('/admin/marketing', ['username' => 'x', 'password' => 'rahasia123'])->assertRedirect(route('marketing.dashboard'));

        Http::assertNothingSent();
    }

    public function test_kavling_page_and_status_update(): void
    {
        Http::fake([
            'api.test/api/admin/perumahan' => self::api(self::perumahan()),
            'api.test/api/admin/kavling' => self::api(self::kavling()),
            'api.test/api/admin/leads*' => self::api([self::lead(['status_keseriusan' => 'validated'])]),
            'api.test/api/admin/kavling/11' => self::api(self::kavling()[1] + ['status' => 'booking', 'status_label' => 'Booking']),
        ]);

        $this->loginAs('admin')->get('/admin/kavling')
            ->assertOk()
            ->assertSee('Arkana Residence')
            ->assertSee('"code":"A-01"', false)
            ->assertSee('Budi Santoso');

        $this->loginAs('admin')
            ->put('/admin/kavling/11', ['status' => 'booking', 'id_leads' => 3])
            ->assertRedirect(route('admin.kavling', ['perumahan' => 1]));

        Http::assertSent(fn (Request $r) => $r->method() === 'PUT' && $r['status'] === 'booking' && $r['id_leads'] === 3);
    }

    private static function multiHouseKavling(): array
    {
        $tipe = ['id' => 1, 'nama_tipe' => 'Tipe 36/60', 'harga' => 162000000, 'perumahan' => ['id' => 1, 'nama_perumahan' => 'Arkana Residence']];

        return [
            ['id' => 20, 'blok' => 'Blok B', 'nomor_kavling' => 'B-03', 'nomor_rumah' => '1', 'label' => 'B-03 · Rumah 1', 'status' => 'tersedia', 'status_label' => 'Tersedia', 'leads' => null, 'tipe_rumah' => $tipe],
            ['id' => 21, 'blok' => 'Blok B', 'nomor_kavling' => 'B-03', 'nomor_rumah' => '2', 'label' => 'B-03 · Rumah 2', 'status' => 'booking', 'status_label' => 'Booking', 'leads' => ['id' => 3, 'nama_calon' => 'Budi Santoso'], 'tipe_rumah' => $tipe],
        ];
    }

    public function test_kavling_page_passes_each_house_with_number_and_label(): void
    {
        Http::fake([
            'api.test/api/admin/perumahan' => self::api(self::perumahan()),
            'api.test/api/admin/kavling' => self::api(array_merge(self::kavling(), self::multiHouseKavling())),
            'api.test/api/admin/leads*' => self::api([]),
        ]);

        $this->loginAs('admin')->get('/admin/kavling')
            ->assertOk()
            ->assertSee('"house":"2"', false)
            ->assertSee('"label":"B-03 \\u00b7 Rumah 2"', false)
            ->assertSee('"code":"B-03"', false)
            ->assertSee('data-multi-house', false)
            ->assertSee('name="jumlah_rumah"', false)
            ->assertSee('Jumlah Rumah');
    }

    public function test_kavling_page_still_works_for_single_house_data_without_new_fields(): void
    {
        Http::fake([
            'api.test/api/admin/perumahan' => self::api(self::perumahan()),
            'api.test/api/admin/kavling' => self::api(self::kavling()),
            'api.test/api/admin/leads*' => self::api([]),
        ]);

        $this->loginAs('admin')->get('/admin/kavling')
            ->assertOk()
            ->assertSee('"house":null', false)
            ->assertSee('"label":"A-01"', false);
    }

    public function test_create_kavling_with_several_houses_sends_jumlah_rumah(): void
    {
        $created = self::kavling()[0] + ['nomor_rumah' => '1', 'label' => 'A-01 · Rumah 1', 'jumlah_dibuat' => 3];
        Http::fake(['api.test/api/admin/tipe-rumah/1/kavling' => self::api($created, 201)]);

        $this->loginAs('admin')->from('/admin/kavling')
            ->post('/admin/kavling', ['id_tipe' => 1, 'blok' => 'Blok A', 'nomor_kavling' => 'A-01', 'jumlah_rumah' => 3])
            ->assertRedirect(route('admin.kavling', ['perumahan' => 1]))
            ->assertSessionHas('success', fn ($msg) => str_contains($msg, '3 rumah berhasil ditambahkan pada kavling A-01'));

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && str_contains($r->url(), 'tipe-rumah/1/kavling')
            && $r['nomor_kavling'] === 'A-01' && $r['jumlah_rumah'] === 3);
    }

    public function test_create_single_kavling_keeps_the_old_message_and_omits_the_count_when_empty(): void
    {
        Http::fake(['api.test/api/admin/tipe-rumah/1/kavling' => self::api(self::kavling()[0] + ['jumlah_dibuat' => 1], 201)]);

        $this->loginAs('admin')->from('/admin/kavling')
            ->post('/admin/kavling', ['id_tipe' => 1, 'blok' => 'Blok A', 'nomor_kavling' => 'A-01', 'jumlah_rumah' => ''])
            ->assertSessionHas('success', 'Kavling A-01 berhasil ditambahkan.');

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && ! isset($r['jumlah_rumah']));
    }

    public function test_create_kavling_validates_house_count_locally(): void
    {
        Http::fake();

        $this->loginAs('admin')->from('/admin/kavling')
            ->post('/admin/kavling', ['id_tipe' => 1, 'nomor_kavling' => 'A-01', 'jumlah_rumah' => 99])
            ->assertRedirect('/admin/kavling')
            ->assertSessionHasErrors('jumlah_rumah');

        Http::assertNothingSent();
    }

    public function test_updating_one_house_names_it_in_the_message(): void
    {
        Http::fake(['api.test/api/admin/kavling/21' => self::api(self::multiHouseKavling()[1])]);

        $this->loginAs('admin')->from('/admin/kavling')
            ->put('/admin/kavling/21', ['status' => 'booking', 'id_leads' => 3])
            ->assertSessionHas('success', fn ($msg) => str_contains($msg, 'B-03 · Rumah 2'));
    }

    private static function perumahanWithBlocks(): array
    {
        $p = self::perumahan();
        $p[0]['blok'] = [
            ['id' => 5, 'id_perumahan' => 1, 'nama' => 'Blok A', 'jumlah_rumah' => 2],
            ['id' => 6, 'id_perumahan' => 1, 'nama' => 'Blok Kosong', 'jumlah_rumah' => 0],
        ];

        return $p;
    }

    public function test_kavling_page_lists_empty_blocks_and_block_forms(): void
    {
        Http::fake([
            'api.test/api/admin/perumahan' => self::api(self::perumahanWithBlocks()),
            'api.test/api/admin/kavling' => self::api(self::kavling()),
            'api.test/api/admin/leads*' => self::api([]),
        ]);

        $this->loginAs('admin')->get('/admin/kavling')
            ->assertOk()
            ->assertSee('Buat Blok')
            ->assertSee('Tambah Rumah')
            ->assertSee(route('admin.blok.store'), false)
            ->assertSee('data-delete-block-form', false)
            ->assertSee('name="blok"', false)
            ->assertSee('data-project="1"', false)
            // the empty block appears in the block list data with its id and count 0
            ->assertSee('Blok Kosong', false)
            ->assertSee('"id":6,"count":0', false);
    }

    public function test_add_house_form_defaults_to_the_project_being_viewed(): void
    {
        $second = self::perumahan();
        $second[0]['id'] = 2;
        $second[0]['nama_perumahan'] = 'Griya Kedua';
        $second[0]['tipe_rumah'][0]['id'] = 9;
        $second[0]['blok'] = [['id' => 8, 'id_perumahan' => 2, 'nama' => 'Blok Z', 'jumlah_rumah' => 0]];

        Http::fake([
            'api.test/api/admin/perumahan' => self::api(array_merge(self::perumahanWithBlocks(), $second)),
            'api.test/api/admin/kavling' => self::api(self::kavling()),
            'api.test/api/admin/leads*' => self::api([]),
        ]);

        $this->loginAs('admin')->get('/admin/kavling?perumahan=2')
            ->assertOk()
            ->assertSee('<option value="9" data-project="2" selected>', false)
            ->assertDontSee('<option value="1" data-project="1" selected>', false);

        $this->loginAs('admin')->get('/admin/kavling')
            ->assertSee('<option value="1" data-project="1" selected>', false);
    }

    public function test_kavling_page_works_when_the_api_sends_no_blocks(): void
    {
        Http::fake([
            'api.test/api/admin/perumahan' => self::api(self::perumahan()),
            'api.test/api/admin/kavling' => self::api(self::kavling()),
            'api.test/api/admin/leads*' => self::api([]),
        ]);

        $this->loginAs('admin')->get('/admin/kavling')->assertOk()->assertSee('Buat Blok');
    }

    public function test_create_block_posts_to_the_api(): void
    {
        Http::fake(['api.test/api/admin/perumahan/1/blok' => self::api(['id' => 7, 'id_perumahan' => 1, 'nama' => 'Blok C'], 201)]);

        $this->loginAs('admin')->from('/admin/kavling')
            ->post('/admin/blok', ['id_perumahan' => 1, 'nama' => 'Blok C'])
            ->assertRedirect(route('admin.kavling', ['perumahan' => 1]))
            ->assertSessionHas('success', fn ($msg) => str_contains($msg, 'Blok C berhasil dibuat'));

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && str_contains($r->url(), 'admin/perumahan/1/blok') && $r['nama'] === 'Blok C');
    }

    public function test_create_block_validates_locally_and_shows_api_errors(): void
    {
        Http::fake(['api.test/api/admin/perumahan/1/blok' => self::api(['nama' => ['The nama has already been taken.']], 422, 'Validation failed')]);

        $this->loginAs('admin')->from('/admin/kavling')
            ->post('/admin/blok', ['id_perumahan' => 1, 'nama' => ''])
            ->assertSessionHasErrors('nama');
        Http::assertNothingSent();

        $this->loginAs('admin')->from('/admin/kavling')
            ->post('/admin/blok', ['id_perumahan' => 1, 'nama' => 'Blok A'])
            ->assertSessionHasErrors(['nama' => 'The nama has already been taken.']);
    }

    public function test_delete_block_calls_the_api_and_returns_to_the_project(): void
    {
        Http::fake(['api.test/api/admin/blok/6' => self::api(null)]);

        $this->loginAs('admin')->delete('/admin/blok/6', ['perumahan' => 1])
            ->assertRedirect(route('admin.kavling', ['perumahan' => 1]))
            ->assertSessionHas('success');

        Http::assertSent(fn (Request $r) => $r->method() === 'DELETE' && str_contains($r->url(), 'admin/blok/6'));
    }

    public function test_delete_block_shows_the_api_refusal(): void
    {
        Http::fake(['api.test/api/admin/blok/5' => self::api(null, 422, 'Blok A masih berisi 2 rumah sehingga tidak bisa dihapus.')]);

        $this->loginAs('admin')->from('/admin/kavling')->delete('/admin/blok/5')
            ->assertRedirect('/admin/kavling')
            ->assertSessionHasErrors(['api' => 'Blok A masih berisi 2 rumah sehingga tidak bisa dihapus.']);
    }

    public function test_block_routes_are_admin_only(): void
    {
        Http::fake();

        $this->loginAs('marketing')->post('/admin/blok', ['id_perumahan' => 1, 'nama' => 'X'])->assertRedirect(route('marketing.dashboard'));
        $this->loginAs('marketing')->delete('/admin/blok/5')->assertRedirect(route('marketing.dashboard'));

        Http::assertNothingSent();
    }

    public function test_perumahan_page_and_create_with_first_type(): void
    {
        Http::fake([
            'api.test/api/admin/perumahan' => function (Request $r) {
                return $r->method() === 'POST'
                    ? self::api(['id' => 2, 'nama_perumahan' => 'Griya Baru'], 201)
                    : self::api(self::perumahan());
            },
        ]);

        $this->loginAs('admin')->get('/admin/perumahan')->assertOk()->assertSee('Arkana Residence')->assertSee('50% terjual/booking');

        $this->loginAs('admin')
            ->post('/admin/perumahan', ['nama_perumahan' => 'Griya Baru', 'lokasi' => 'Kademangan', 'status' => 'aktif', 'tipe' => ['nama_tipe' => 'Tipe 36', 'jenis_rumah' => 'subsidi', 'harga' => '150000000', 'dp' => '']])
            ->assertRedirect(route('admin.perumahan'))
            ->assertSessionHas('success');

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && $r->isMultipart()
            && collect($r->data())->contains(fn ($p) => $p['name'] === 'tipe_rumah[0][nama_tipe]' && $p['contents'] === 'Tipe 36')
            && ! collect($r->data())->contains(fn ($p) => $p['name'] === 'tipe_rumah[0][dp]'));
    }

    public function test_reports_page_and_csv_export(): void
    {
        $reports = [[
            'tanggal_report' => '2026-10-13', 'created_at' => '2026-10-13T10:30:00+07:00', 'deskripsi_progres' => 'Closing PPJB',
            'jenis_aktivitas' => 'closing', 'jenis_aktivitas_label' => 'Closing / PPJB', 'marketing' => ['nama' => 'Dimas'], 'leads' => ['nama_calon' => 'Ahmad'],
        ]];
        Http::fake([
            'api.test/api/admin/reports*' => self::api($reports),
            'api.test/api/admin/marketing' => self::api([['id' => 2, 'nama' => 'Dimas']]),
        ]);

        $this->loginAs('admin')->get('/admin/reports?id_marketing=2')->assertOk()->assertSee('Closing PPJB')->assertSee('Ahmad');

        $csv = $this->loginAs('admin')->get('/admin/reports/export')->assertOk()->streamedContent();
        $this->assertStringContainsString('Dimas,Ahmad,"Closing / PPJB","Closing PPJB"', $csv);
    }
}
