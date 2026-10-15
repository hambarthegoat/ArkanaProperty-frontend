<?php

namespace Tests\Feature;

use App\Services\ArkanaApi;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2026-10-14 08:00:00');
    }

    private static function lead(array $overrides = []): array
    {
        return array_merge([
            'id' => 1, 'nama_calon' => 'Ahmad Rizky', 'no_telp' => '081234567890', 'pesan' => 'Mau survey',
            'status_keseriusan' => 'validated', 'status_label' => 'Tervalidasi', 'prioritas' => 'tinggi', 'prioritas_label' => 'Tinggi',
            'catatan' => 'Siap survey', 'updated_at' => '2026-10-14T06:00:00+07:00',
            'perumahan' => ['id' => 1, 'nama_perumahan' => 'Arkana Residence'], 'tipe_rumah' => ['id' => 1, 'nama_tipe' => 'Tipe 36/60'],
            'kavling' => ['nomor_kavling' => 'A-01', 'status_label' => 'Booking'],
        ], $overrides);
    }

    private static function agenda(array $overrides = []): array
    {
        return array_merge([
            'id' => 5, 'judul' => 'Survey Lokasi: Bpk Ahmad', 'jenis' => 'survey', 'jenis_label' => 'Survey',
            'tanggal_kegiatan' => '2026-10-14T09:00:00+07:00', 'lokasi' => 'Blok A-01', 'deskripsi_agenda' => 'Bawa KTP',
            'leads' => ['id' => 7, 'nama' => 'Ahmad Rizky'],
        ], $overrides);
    }

    public function test_dashboard_lists_assigned_leads_and_today_schedule(): void
    {
        Http::fake([
            'api.test/api/marketing/leads' => self::api([self::lead()]),
            'api.test/api/marketing/calendar*' => self::api([self::agenda()]),
        ]);

        $this->loginAs('marketing')->get('/marketing')
            ->assertOk()
            ->assertSee('Ahmad Rizky')
            ->assertSee('Prioritas Tinggi')
            ->assertSee('Survey Lokasi: Bpk Ahmad')
            ->assertSee('09:00')
            ->assertSee('https://wa.me/6281234567890');

        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'marketing/calendar') && $r['from'] === '2026-10-14' && $r['to'] === '2026-10-14');
    }

    public function test_update_lead_notes(): void
    {
        Http::fake(['api.test/api/marketing/leads/1' => self::api(self::lead(['prioritas' => 'sedang']))]);

        $this->loginAs('marketing')->from('/marketing')
            ->patch('/marketing/leads/1', ['prioritas' => 'sedang', 'catatan' => 'Follow up Jumat'])
            ->assertRedirect('/marketing')
            ->assertSessionHas('success');

        Http::assertSent(fn (Request $r) => $r->method() === 'PATCH' && $r['prioritas'] === 'sedang' && $r['catatan'] === 'Follow up Jumat');
    }

    public function test_calendar_month_view_and_create_agenda(): void
    {
        Http::fake([
            'api.test/api/marketing/calendar*' => function (Request $r) {
                return $r->method() === 'POST' ? self::api(self::agenda(), 201) : self::api([self::agenda()]);
            },
            'api.test/api/marketing/leads' => self::api([self::lead(), self::lead(['id' => 2, 'nama_calon' => 'Budi', 'status_keseriusan' => 'rejected'])]),
        ]);

        $this->loginAs('marketing')->get('/marketing/calendar?month=2026-10&date=2026-10-14')
            ->assertOk()
            ->assertSee('Oktober 2026')
            ->assertSee('Survey Lokasi: Bpk Ahmad')
            ->assertSee('data-event-dot', false)
            ->assertDontSee('<option value="2"', false);

        Http::assertSent(fn (Request $r) => $r->method() === 'GET' && str_contains($r->url(), 'marketing/calendar') && $r['from'] === '2026-10-01' && $r['to'] === '2026-10-31');

        $this->loginAs('marketing')
            ->post('/marketing/calendar', ['id_lead' => 1, 'judul' => 'Survey', 'jenis' => 'survey', 'tanggal' => '2026-10-20', 'jam' => '10:30', 'lokasi' => 'Blok A'])
            ->assertRedirect(route('marketing.calendar', ['month' => '2026-10', 'date' => '2026-10-20']));

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && $r['id_lead'] === 1 && $r['tanggal_kegiatan'] === '2026-10-20 10:30:00');
    }

    public function test_reports_page_and_submit(): void
    {
        Http::fake([
            'api.test/api/marketing/leads' => self::api([self::lead()]),
            'api.test/api/marketing/reports' => function (Request $r) {
                return $r->method() === 'POST'
                    ? self::api(['id' => 9], 201)
                    : self::api([['tanggal_report' => '2026-10-13', 'jenis_aktivitas_label' => 'Survey Lokasi', 'deskripsi_progres' => 'Klien tertarik hook', 'leads' => ['nama_calon' => 'Ahmad Rizky']]]);
            },
        ]);

        $this->loginAs('marketing')->get('/marketing/reports')
            ->assertOk()
            ->assertSee('Survey Lokasi: Ahmad Rizky')
            ->assertSee('Ahmad Rizky (A-01)');

        $this->loginAs('marketing')->from('/marketing/reports')
            ->post('/marketing/reports', ['id_lead' => 1, 'jenis_aktivitas' => 'survey_lokasi', 'deskripsi_progres' => 'Survey selesai'])
            ->assertRedirect('/marketing/reports')
            ->assertSessionHas('success');

        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && $r['tanggal_report'] === '2026-10-14' && $r['id_lead'] === 1);
    }

    public function test_expired_token_redirects_to_login(): void
    {
        Http::fake(['api.test/api/*' => self::api(null, 401, 'Unauthenticated.')]);

        $this->loginAs('marketing')
            ->get('/marketing')
            ->assertRedirect(route('login'))
            ->assertSessionMissing(ArkanaApi::SESSION_TOKEN);
    }

    public function test_api_outage_renders_friendly_page(): void
    {
        Http::fake(['api.test/api/*' => fn () => throw new ConnectionException('down')]);

        $this->loginAs('marketing')->get('/marketing')->assertStatus(503)->assertSee('Server API tidak dapat dihubungi');
    }
}
