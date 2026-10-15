<?php

namespace App\Support;

/**
 * Turns API perumahan / tipe_rumah payloads into the card shape the public
 * pages were designed around (one card per house type).
 */
class PropertyPresenter
{
    public const FALLBACK_IMAGE = 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070';

    /**
     * @param  array<int, array>  $perumahanList
     * @return array<int, array>
     */
    public static function cards(array $perumahanList): array
    {
        $cards = [];

        foreach ($perumahanList as $perumahan) {
            foreach ($perumahan['tipe_rumah'] ?? [] as $tipe) {
                $cards[] = self::card($tipe, $perumahan);
            }
        }

        return $cards;
    }

    public static function card(array $tipe, array $perumahan): array
    {
        return [
            'id' => $tipe['id'],
            'name' => $perumahan['nama_perumahan'].' - '.$tipe['nama_tipe'],
            'perumahan' => $perumahan['nama_perumahan'],
            'tipe' => $tipe['nama_tipe'],
            'price' => Format::rupiah($tipe['harga']),
            'dp' => Format::rupiah($tipe['dp'] ?? 0),
            'installment' => filled($tipe['cicilan'] ?? null) ? Format::short($tipe['cicilan']).'-an' : '-',
            'type' => $tipe['jenis_rumah_label'] ?? ucfirst((string) $tipe['jenis_rumah']),
            'jenis' => $tipe['jenis_rumah'],
            'location' => $perumahan['lokasi'],
            'specs' => $tipe['spesifikasi'] ?? '',
            'desc' => $perumahan['deskripsi'] ?? '',
            'image' => $tipe['gambar_url'] ?? $perumahan['gambar_url'] ?? self::FALLBACK_IMAGE,
            'unit_tersedia' => $tipe['unit_tersedia'] ?? null,
            'pre_launch' => ($perumahan['status'] ?? null) === 'pre_launch',
        ];
    }
}
