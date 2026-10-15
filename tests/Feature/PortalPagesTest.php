<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PortalPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2026-10-14 08:00:00');
    }

    private static function profile(): array
    {
        $timeline = [
            ['key' => 'pengajuan', 'judul' => 'Form Minat Dikirim', 'deskripsi' => 'Diterima.', 'status' => 'completed', 'tanggal' => '2026-10-01T10:00:00+07:00'],
            ['key' => 'validasi', 'judul' => 'Verifikasi KTP', 'deskripsi' => 'Diverifikasi.', 'status' => 'completed', 'tanggal' => null],
            ['key' => 'marketing', 'judul' => 'Pendampingan Marketing', 'deskripsi' => 'Didampingi.', 'status' => 'completed', 'tanggal' => null],
            ['key' => 'booking', 'judul' => 'Booking Unit', 'deskripsi' => 'Tanda jadi.', 'status' => 'current', 'tanggal' => null],
            ['key' => 'terjual', 'judul' => 'Akad & Serah Terima', 'deskripsi' => 'Akad.', 'status' => 'upcoming', 'tanggal' => null],
        ];

        return [
            'akun' => ['id' => 7, 'username' => '081234567890', 'role' => 'leads', 'nama' => 'Ahmad Rizky'],
            'lead' => [
                'id' => 1, 'id_tipe' => 1, 'perumahan' => ['nama_perumahan' => 'Arkana Residence', 'lokasi' => 'Kec. Mayangan'],
                'tipe_rumah' => ['nama_tipe' => 'Tipe 36/60'],
                'kavling' => ['blok' => 'Blok A', 'nomor_kavling' => 'A-01', 'status_label' => 'Booking', 'tipe_rumah' => ['nama_tipe' => 'Tipe 36/60']],
            ],
            'timeline' => $timeline,
        ];
    }

    private function fakePortal(bool $withMarketing = true): void
    {
        Http::fake([
            'api.test/api/leads/profile' => self::api(self::profile()),
            'api.test/api/leads/calendar*' => self::api([
                ['judul' => 'Survey Lokasi', 'jenis' => 'survey', 'tanggal_kegiatan' => '2026-10-15T09:00:00+07:00', 'lokasi' => 'Blok A-01', 'deskripsi_agenda' => 'Bawa KTP.', 'marketing' => ['nama' => 'Dimas']],
                ['judul' => 'Konsultasi KPR', 'jenis' => 'follow_up', 'tanggal_kegiatan' => '2026-10-10T09:00:00+07:00', 'lokasi' => null, 'deskripsi_agenda' => null, 'marketing' => ['nama' => 'Dimas']],
            ]),
            'api.test/api/leads/marketing-contact' => $withMarketing
                ? self::api(['nama' => 'Dimas Marketing', 'no_wa' => '081211112222', 'wa_link' => 'https://wa.me/6281211112222'])
                : self::api(null, 404, 'No marketing has been assigned to your account yet'),
        ]);
    }

    public function test_dashboard_shows_profile_agenda_and_contact(): void
    {
        $this->fakePortal();

        $this->loginAs('leads')->get('/portal')
            ->assertOk()
            ->assertSee('Halo, Ahmad Rizky!')
            ->assertSee('Blok A · A-01')
            ->assertSee('Booking Unit')
            ->assertSee('Survey Lokasi')
            ->assertSee('15 Oktober 2026')
            ->assertSee('https://wa.me/6281211112222');
    }

    public function test_dashboard_without_assigned_marketing(): void
    {
        $this->fakePortal(withMarketing: false);

        $this->loginAs('leads')->get('/portal')->assertOk()->assertDontSee('data-contact-marketing', false);
        $this->loginAs('leads')->get('/portal/support')->assertOk()->assertSee('Marketing pendamping belum ditugaskan');
    }

    public function test_timeline_maps_api_steps(): void
    {
        $this->fakePortal();

        $this->loginAs('leads')->get('/portal/reminders')
            ->assertOk()
            ->assertSee('Verifikasi KTP')
            ->assertSee('Sedang Berjalan')
            ->assertSee('1 Oktober 2026')
            ->assertSee(route('property.show', 1));
    }

    public function test_support_shows_marketing_contact(): void
    {
        $this->fakePortal();

        $this->loginAs('leads')->get('/portal/support')->assertOk()->assertSee('Dimas Marketing')->assertSee('081211112222');
    }

    public function test_marketing_cannot_open_portal(): void
    {
        $this->loginAs('marketing')->get('/portal')->assertRedirect(route('marketing.dashboard'));
    }
}
