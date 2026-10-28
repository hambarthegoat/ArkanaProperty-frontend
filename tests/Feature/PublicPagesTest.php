<?php

namespace Tests\Feature;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    private static function tipe(array $overrides = []): array
    {
        return array_merge([
            'id' => 1, 'id_perumahan' => 1, 'nama_tipe' => 'Tipe 36/60', 'jenis_rumah' => 'subsidi', 'jenis_rumah_label' => 'Subsidi',
            'harga' => 162000000, 'dp' => 5000000, 'cicilan' => 900000, 'luas_tanah' => 60, 'luas_bangunan' => 36,
            'kamar_tidur' => 2, 'kamar_mandi' => 1, 'spesifikasi' => '2 KT, 1 KM, Dapur, Carport', 'gambar_url' => null, 'unit_tersedia' => 3,
        ], $overrides);
    }

    private static function perumahan(array $tipe = []): array
    {
        return [
            'id' => 1, 'nama_perumahan' => 'Arkana Residence Mayangan', 'lokasi' => 'Kec. Mayangan, Probolinggo',
            'deskripsi' => 'Hunian subsidi ternyaman.', 'gambar_url' => 'https://img.test/a.jpg', 'status' => 'aktif',
            'tipe_rumah' => $tipe ?: [self::tipe()],
        ];
    }

    private function fakeCatalog(): void
    {
        Http::fake([
            'api.test/api/public/perumahan*' => self::api([self::perumahan()]),
            'api.test/api/public/filters' => self::api([
                'lokasi' => ['Kec. Mayangan, Probolinggo'],
                'jenis_rumah' => [['value' => 'subsidi', 'label' => 'Subsidi'], ['value' => 'premium', 'label' => 'Premium']],
                'harga' => ['min' => 162000000, 'max' => 162000000],
            ]),
        ]);
    }

    public function test_landing_renders_catalog_from_api(): void
    {
        $this->fakeCatalog();

        $this->get('/')
            ->assertOk()
            ->assertSee('Arkana Residence Mayangan - Tipe 36/60')
            ->assertSee('Rp 162.000.000')
            ->assertSee('900rb-an')
            ->assertSee('Kec. Mayangan, Probolinggo')
            ->assertSee('1 tipe rumah ditemukan');
    }

    public function test_landing_forwards_filters_to_api(): void
    {
        $this->fakeCatalog();

        $this->get('/?lokasi=Kec.+Mayangan%2C+Probolinggo&jenis_rumah=subsidi&max_cicilan=1000000&min_budget=')->assertOk();

        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'public/perumahan')
            && $r['jenis_rumah'] === 'subsidi'
            && $r['max_cicilan'] === '1000000'
            && ! isset($r['min_budget']));
    }

    public function test_landing_survives_api_outage(): void
    {
        Http::fake(['api.test/*' => fn () => throw new ConnectionException('down')]);

        $this->get('/')->assertOk()->assertSee('Katalog belum bisa dimuat');
    }

    public function test_property_detail_uses_tipe_endpoint(): void
    {
        Http::fake(['api.test/api/public/tipe-rumah/1' => self::api(self::tipe([
            'perumahan' => self::perumahan(),
            'kavling' => [
                ['id' => 1, 'blok' => 'Blok A', 'nomor_kavling' => 'A-01', 'status' => 'terjual', 'status_label' => 'Terjual'],
                ['id' => 2, 'blok' => 'Blok A', 'nomor_kavling' => 'A-02', 'status' => 'tersedia', 'status_label' => 'Tersedia'],
            ],
        ]))]);

        $this->get('/property/1')
            ->assertOk()
            ->assertSee('Tipe 36/60')
            ->assertSee('60 m²')
            ->assertSee('A-02 · Tersedia')
            ->assertSee('Hunian subsidi ternyaman.');
    }

    public function test_unknown_property_is_404(): void
    {
        Http::fake(['api.test/api/public/tipe-rumah/99' => self::api(null, 404, 'Tipe rumah not found')]);

        $this->get('/property/99')->assertNotFound();
    }

    public function test_interest_form_does_not_send_ktp(): void
    {
        Http::fake(['api.test/api/public/leads' => self::api(['id' => 10], 201)]);

        $this->from('/property/1')
            ->post('/leads', [
                'id_tipe' => 1,
                'nama_calon' => 'Budi',
                'no_telp' => '081234567890',
                'file_ktp' => UploadedFile::fake()->image('ktp.jpg'),
            ])
            ->assertRedirect('/property/1')
            ->assertSessionHas('lead_success.id_tipe', 1);

        Http::assertSent(fn (Request $r) => ! $r->isMultipart()
            && $r['nama_calon'] === 'Budi'
            && ! isset($r['file_ktp']));
    }

    public function test_public_forms_have_no_ktp_input(): void
    {
        Http::fake([
            'api.test/api/public/filters' => self::api(['lokasi' => [], 'jenis_rumah' => [], 'cicilan' => []]),
            'api.test/api/public/perumahan*' => self::api([]),
            'api.test/api/public/tipe-rumah/1' => self::api(self::tipe(['perumahan' => self::perumahan(), 'kavling' => []])),
        ]);

        $this->get('/')->assertOk()->assertDontSee('file_ktp', false)->assertDontSee('Foto KTP');
        $this->get('/property/1')->assertOk()->assertDontSee('file_ktp', false)->assertDontSee('Foto KTP');
    }

    public function test_interest_form_shows_api_validation_errors(): void
    {
        Http::fake(['api.test/api/public/leads' => self::api(['no_telp' => ['Format nomor tidak valid.']], 422, 'Validation failed')]);

        $this->from('/')
            ->post('/leads', ['id_tipe' => 1, 'nama_calon' => 'Budi', 'no_telp' => 'abc'])
            ->assertRedirect('/')
            ->assertSessionHasErrors(['no_telp' => 'Format nomor tidak valid.'])
            ->assertSessionHasInput('id_tipe', 1);
    }
}
