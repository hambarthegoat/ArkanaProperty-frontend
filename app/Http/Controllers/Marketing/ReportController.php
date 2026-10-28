<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public const ACTIVITIES = [
        'survey_lokasi' => 'Survey Lokasi',
        'follow_up' => 'Follow Up WhatsApp/Telepon',
        'penawaran' => 'Telepon Penawaran',
        'booking' => 'Booking Unit',
        'closing' => 'Tanda Tangan PPJB / Closing',
        'lainnya' => 'Lainnya',
    ];

    public function __construct(private ArkanaApi $api) {}

    public function index()
    {
        return view('pages.marketing.reports', [
            'leads' => $this->api->get('marketing/leads'),
            'history' => $this->api->get('marketing/reports'),
            'activities' => self::ACTIVITIES,
        ]);
    }

    public function store(Request $request)
    {
        $this->api->post('marketing/reports', [
            'tanggal_report' => $request->input('tanggal_report') ?: now()->toDateString(),
            'id_lead' => $request->filled('id_lead') ? $request->integer('id_lead') : null,
            'jenis_aktivitas' => $request->input('jenis_aktivitas'),
            'deskripsi_progres' => $request->input('deskripsi_progres'),
        ]);

        return back()->with('success', 'Laporan harian berhasil dikirim.');
    }
}
