<?php

namespace App\Http\Controllers;

use App\Services\ArkanaApi;
use App\Support\PropertyPresenter;

class PropertyController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    public function show(int $id)
    {
        $tipe = $this->api->get("public/tipe-rumah/{$id}");
        $property = PropertyPresenter::card($tipe, $tipe['perumahan']);

        $specs = array_values(array_filter([
            $tipe['luas_tanah'] ? ['label' => 'Luas Tanah', 'value' => $tipe['luas_tanah'].' m²', 'icon' => 'maximize'] : null,
            $tipe['luas_bangunan'] ? ['label' => 'Luas Bangunan', 'value' => $tipe['luas_bangunan'].' m²', 'icon' => 'home'] : null,
            $tipe['kamar_tidur'] ? ['label' => 'Kamar Tidur', 'value' => $tipe['kamar_tidur'].' Ruangan', 'icon' => 'bed-double'] : null,
            $tipe['kamar_mandi'] ? ['label' => 'Kamar Mandi', 'value' => $tipe['kamar_mandi'].' Ruangan', 'icon' => 'droplet'] : null,
            ['label' => 'Jenis Rumah', 'value' => $property['type'], 'icon' => 'tag'],
            ['label' => 'Unit Tersedia', 'value' => ($tipe['unit_tersedia'] ?? 0).' Unit', 'icon' => 'key'],
        ]));

        $kavlingByBlok = collect($tipe['kavling'] ?? [])->groupBy(fn ($k) => $k['blok'] ?? 'Tanpa Blok');

        return view('pages.property-detail', compact('property', 'specs', 'kavlingByBlok'));
    }
}
