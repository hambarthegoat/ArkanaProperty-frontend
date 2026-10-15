<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use App\Support\Format;

class DashboardController extends Controller
{
    public function __invoke(ArkanaApi $api)
    {
        $today = now()->toDateString();

        $leads = collect($api->get('marketing/leads'))->map(fn ($lead) => [
            'id' => $lead['id'],
            'name' => $lead['nama_calon'],
            'initials' => Format::initials($lead['nama_calon']),
            'phone' => $lead['no_telp'],
            'wa' => preg_replace('/^0/', '62', $lead['no_telp']),
            'property' => trim(($lead['tipe_rumah']['nama_tipe'] ?? '').' · '.($lead['perumahan']['nama_perumahan'] ?? ''), ' ·'),
            'status' => $lead['status_label'],
            'priority' => $lead['prioritas'],
            'priority_label' => $lead['prioritas_label'] ?? 'Belum diatur',
            'notes' => $lead['catatan'],
            'message' => $lead['pesan'],
            'unit' => $lead['kavling'] ? $lead['kavling']['nomor_kavling'].' ('.$lead['kavling']['status_label'].')' : null,
            'last_update' => Format::carbon($lead['updated_at'])->diffForHumans(),
        ]);

        return view('pages.marketing.dashboard', [
            'assignedLeads' => $leads,
            'schedule' => $api->get('marketing/calendar', ['from' => $today, 'to' => $today]),
            'activities' => ReportController::ACTIVITIES,
        ]);
    }
}
