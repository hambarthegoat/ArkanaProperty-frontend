<?php

namespace App\Http\Controllers\Portal;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use App\Support\Format;

class PortalController extends Controller
{
    private const STEP_ICONS = [
        'pengajuan' => 'file-text',
        'validasi' => 'shield-check',
        'marketing' => 'users',
        'booking' => 'key',
        'terjual' => 'home',
    ];

    public function __construct(private ArkanaApi $api) {}

    public function dashboard()
    {
        $profile = $this->api->get('leads/profile');

        $reminders = collect($this->api->get('leads/calendar', ['semua' => 1]))
            ->sortByDesc(fn ($item) => $item['tanggal_kegiatan'])
            ->map(function ($item) {
                $at = Format::carbon($item['tanggal_kegiatan']);

                return [
                    'title' => $item['judul'],
                    'date' => $at->isoFormat('D MMMM YYYY'),
                    'time' => $at->format('H:i').' WIB',
                    'desc' => trim(($item['deskripsi_agenda'] ?? '').($item['lokasi'] ? ' Lokasi: '.$item['lokasi'].'.' : '').' Bersama '.($item['marketing']['nama'] ?? 'marketing').'.'),
                    'status' => $at->isPast() ? 'Completed' : 'Upcoming',
                    'icon' => $at->isPast() ? 'check-circle-2' : ($item['jenis'] === 'closing' ? 'clock' : 'calendar'),
                ];
            })->values();

        return view('pages.portal.dashboard', [
            'profile' => $profile,
            'reminders' => $reminders,
            'contact' => $this->contact(),
            'currentStep' => collect($profile['timeline'])->firstWhere('status', 'current'),
        ]);
    }

    public function timeline()
    {
        $profile = $this->api->get('leads/profile');

        $steps = collect($profile['timeline'])->map(fn ($step) => [
            'title' => $step['judul'],
            'desc' => $step['deskripsi'],
            'status' => ucfirst($step['status']),
            'date' => $step['tanggal'] ? Format::date($step['tanggal']) : null,
            'icon' => self::STEP_ICONS[$step['key']] ?? 'circle',
        ]);

        return view('pages.portal.timeline', ['steps' => $steps, 'lead' => $profile['lead']]);
    }

    public function support()
    {
        return view('pages.portal.support', ['contact' => $this->contact()]);
    }

    /**
     * Marketing contact, or null while no marketing is assigned (API 404).
     */
    private function contact(): ?array
    {
        try {
            return $this->api->get('leads/marketing-contact');
        } catch (ApiException $e) {
            if ($e->status === 404) {
                return null;
            }

            throw $e;
        }
    }
}
