<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    public function index(Request $request)
    {
        $filters = $request->only(['id_marketing', 'from', 'to']);
        $reports = collect($this->api->get('admin/reports', $filters));

        return view('pages.admin.marketing-reports', [
            'reports' => $reports,
            'marketing' => $this->api->get('admin/marketing'),
            'filters' => $filters,
            'stats' => [
                ['label' => 'Total Aktivitas', 'value' => $reports->count(), 'icon' => 'trending-up', 'color' => 'text-blue-600'],
                ['label' => 'Survey Lokasi', 'value' => $reports->where('jenis_aktivitas', 'survey_lokasi')->count(), 'icon' => 'calendar', 'color' => 'text-accent'],
                ['label' => 'Closing / Booking', 'value' => $reports->whereIn('jenis_aktivitas', ['closing', 'booking'])->count(), 'icon' => 'check-circle-2', 'color' => 'text-emerald-custom'],
            ],
        ]);
    }

    /**
     * CSV of the currently filtered reports.
     */
    public function export(Request $request)
    {
        $reports = $this->api->get('admin/reports', $request->only(['id_marketing', 'from', 'to']));

        return response()->streamDownload(function () use ($reports) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Tanggal', 'Marketing', 'Konsumen', 'Aktivitas', 'Progres']);
            foreach ($reports as $report) {
                fputcsv($out, [
                    $report['tanggal_report'],
                    $report['marketing']['nama'] ?? '',
                    $report['leads']['nama_calon'] ?? '',
                    $report['jenis_aktivitas_label'] ?? '',
                    $report['deskripsi_progres'],
                ]);
            }
            fclose($out);
        }, 'report-marketing-'.now()->format('Ymd').'.csv', ['Content-Type' => 'text/csv']);
    }
}
