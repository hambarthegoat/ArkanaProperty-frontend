<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Services\ArkanaApi;
use App\Support\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    /**
     * Month grid from ?month=YYYY-MM with the agenda of ?date=YYYY-MM-DD
     * (defaults: current month, today).
     */
    public function index(Request $request)
    {
        $month = rescue(fn () => Carbon::createFromFormat('Y-m', (string) $request->query('month'))->startOfMonth(), now()->startOfMonth(), false);
        $selected = rescue(fn () => Carbon::createFromFormat('Y-m-d', (string) $request->query('date'))->startOfDay(), null, false)
            ?? (now()->isSameMonth($month) ? now()->startOfDay() : $month->copy());

        $events = collect($this->api->get('marketing/calendar', [
            'from' => $month->toDateString(),
            'to' => $month->copy()->endOfMonth()->toDateString(),
        ]))->map(fn ($e) => $e + ['date' => Format::carbon($e['tanggal_kegiatan'])->toDateString()]);

        return view('pages.marketing.calendar', [
            'month' => $month,
            'selected' => $selected,
            'eventDays' => $events->pluck('date')->unique()->values()->all(),
            'dayEvents' => $events->where('date', $selected->toDateString())->values(),
            'leads' => collect($this->api->get('marketing/leads'))->where('status_keseriusan', 'validated')->values(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'jam' => 'required|date_format:H:i',
        ]);

        $this->api->post('marketing/calendar', [
            'id_lead' => $request->integer('id_lead'),
            'judul' => $request->input('judul'),
            'jenis' => $request->input('jenis'),
            'tanggal_kegiatan' => $request->input('tanggal').' '.$request->input('jam').':00',
            'lokasi' => $request->input('lokasi'),
            'deskripsi_agenda' => $request->input('deskripsi_agenda'),
        ]);

        return redirect()->route('marketing.calendar', [
            'month' => substr($request->input('tanggal'), 0, 7),
            'date' => $request->input('tanggal'),
        ])->with('success', 'Agenda berhasil dibuat dan akan muncul di portal konsumen.');
    }
}
