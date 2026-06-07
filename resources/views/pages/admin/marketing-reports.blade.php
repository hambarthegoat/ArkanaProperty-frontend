@extends('layouts.dashboard')

@php
    $role = 'admin';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $reports = [
        ['id' => 1, 'agent' => 'Dimas Marketing', 'date' => '7 Juni 2026', 'time' => '10:30', 'client' => 'Ahmad Rizky', 'activity' => 'Survey Lokasi', 'status' => 'Completed', 'note' => 'Klien sangat tertarik dengan Blok A-12, menanyakan skema cicilan 15 tahun.'],
        ['id' => 2, 'agent' => 'Santi Agent', 'date' => '7 Juni 2026', 'time' => '09:15', 'client' => 'Ibu Siti', 'activity' => 'Follow Up WA', 'status' => 'In Progress', 'note' => 'Menunggu konfirmasi jadwal kunjungan hari Sabtu depan.'],
        ['id' => 3, 'agent' => 'Dimas Marketing', 'date' => '6 Juni 2026', 'time' => '16:00', 'client' => 'Bpk Budi', 'activity' => 'Closing Unit', 'status' => 'Completed', 'note' => 'Tanda tangan PPJB selesai. Berkas sudah diserahkan ke Admin.'],
        ['id' => 4, 'agent' => 'Rian Sales', 'date' => '6 Juni 2026', 'time' => '14:20', 'client' => 'Dewi Lestari', 'activity' => 'Survey Lokasi', 'status' => 'Completed', 'note' => 'Klien ingin membandingkan Tipe 36 dengan Tipe 45.'],
    ];

    $stats = [
        ['label' => 'Total Aktivitas', 'value' => '342', 'icon' => 'trending-up', 'color' => 'text-blue-600'],
        ['label' => 'Survey Lokasi', 'value' => '128', 'icon' => 'calendar', 'color' => 'text-accent'],
        ['label' => 'Closing / Booking', 'value' => '15', 'icon' => 'check-circle-2', 'color' => 'text-emerald-custom'],
    ];

    function reportInitials($name) {
        return collect(explode(' ', $name))->map(fn ($n) => $n[0])->implode('');
    }
@endphp

@section('main')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Laporan Aktivitas Marketing</h1>
            <p class="text-primary/60">Pantau performa dan catatan harian dari seluruh tim lapangan.</p>
        </div>
        <div class="flex gap-2">
            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
                <i data-lucide="calendar" class="size-4"></i> Filter Tanggal
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <i data-lucide="download" class="size-4"></i> Download Report
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($stats as $stat)
            <div class="bg-white p-6 rounded-3xl border border-border-subtle shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                    <h3 class="text-3xl font-black text-primary">{{ $stat['value'] }}</h3>
                </div>
                <div class="p-4 rounded-2xl bg-surface-soft {{ $stat['color'] }}">
                    <i data-lucide="{{ $stat['icon'] }}" class="size-6"></i>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[40px] border border-border-subtle shadow-sm overflow-hidden">
        <div class="p-8 border-b border-border-subtle">
            <h3 class="font-black text-primary flex items-center gap-3">
                <i data-lucide="file-text" class="size-5 text-accent"></i> Feed Laporan Terbaru
            </h3>
        </div>

        <div class="divide-y divide-border-subtle">
            @foreach ($reports as $report)
                <div class="p-8 flex flex-col lg:flex-row gap-8 lg:items-center hover:bg-surface-soft/50 transition-colors">
                    <div class="lg:w-1/4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-full bg-surface-soft flex items-center justify-center font-bold text-[10px] text-primary">
                                {{ reportInitials($report['agent']) }}
                            </div>
                            <span class="font-bold text-primary text-sm">{{ $report['agent'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] font-bold text-primary/30 uppercase tracking-widest">
                            <i data-lucide="clock" class="size-3"></i> {{ $report['date'] }} • {{ $report['time'] }}
                        </div>
                    </div>

                    <div class="lg:w-1/4">
                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Konsumen</p>
                        <p class="font-black text-primary">{{ $report['client'] }}</p>
                        <div class="inline-flex items-center gap-2 px-2 py-0.5 bg-surface-soft rounded text-[10px] font-bold text-accent mt-1">
                            {{ $report['activity'] }}
                        </div>
                    </div>

                    <div class="lg:w-1/3">
                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Catatan</p>
                        <p class="text-sm text-primary/60 leading-relaxed italic">"{{ $report['note'] }}"</p>
                    </div>

                    <div class="lg:w-1/6 flex items-center justify-between lg:justify-end gap-4">
                        <span class="px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter {{ $report['status'] === 'Completed' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600' }}">
                            {{ $report['status'] }}
                        </span>
                        <button class="p-2 hover:bg-white rounded-lg transition-all text-primary/20 hover:text-primary">
                            <i data-lucide="more-vertical" class="size-[18px]"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-8 border-t border-border-subtle text-center">
            <button class="text-accent text-xs font-black uppercase tracking-widest hover:gap-3 transition-all flex items-center gap-2 mx-auto">
                Lihat Laporan Lebih Lama <i data-lucide="arrow-right" class="size-3.5"></i>
            </button>
        </div>
    </div>
</div>
@endsection
