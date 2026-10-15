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

    public function test_ktp_upload_and_download_proxy(): void
    {
        Http::fake([
            'api.test/api/admin/leads/3/ktp' => function (Request $r) {
                return $r->method() === 'POST'
                    ? self::api(self::lead(['has_ktp' => true]))
                    : Http::response('JPEGDATA', 200, ['Content-Type' => 'image/jpeg']);
            },
        ]);

        $this->loginAs('admin')->from('/admin/leads')
            ->post('/admin/leads/3/ktp', ['file_ktp' => UploadedFile::fake()->image('ktp.jpg')])
            ->assertRedirect('/admin/leads')
            ->assertSessionHas('success');

        $this->loginAs('admin')->get('/admin/leads/3/ktp')
            ->assertOk()
            ->assertHeader('Content-Type', 'image/jpeg')
            ->assertSee('JPEGDATA');
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
