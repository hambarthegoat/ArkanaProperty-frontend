@extends('layouts.dashboard', ['role' => 'admin'])

@section('title', 'Laporan Marketing - ArkanaProperty')

@php
    use App\Support\Badge;
    use App\Support\Format;
@endphp

@section('main')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Laporan Aktivitas Marketing</h1>
            <p class="text-primary/60">Pantau performa dan catatan harian dari seluruh tim lapangan.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.export', $filters) }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <i data-lucide="download" class="size-4"></i> Download CSV
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.reports') }}" class="bg-white rounded-3xl border border-border-subtle shadow-sm p-4 flex flex-col md:flex-row gap-3 md:items-end">
        <div class="space-y-1 flex-1">
            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Marketing</label>
            <select name="id_marketing" class="w-full bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none">
                <option value="">Semua marketing</option>
                @foreach ($marketing as $m)
                    <option value="{{ $m['id'] }}" @selected((string) ($filters['id_marketing'] ?? '') === (string) $m['id'])>{{ $m['nama'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-1">
            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Dari</label>
            <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
        </div>
        <div class="space-y-1">
            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Sampai</label>
            <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
        </div>
        <button type="submit" class="flex items-center justify-center gap-2 px-4 py-3 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
            <i data-lucide="calendar" class="size-4"></i> Terapkan Filter
        </button>
    </form>

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
            @forelse ($reports as $report)
                <div class="p-8 flex flex-col lg:flex-row gap-8 lg:items-center hover:bg-surface-soft/50 transition-colors">
                    <div class="lg:w-1/4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-full bg-surface-soft flex items-center justify-center font-bold text-[10px] text-primary">
                                {{ Format::initials($report['marketing']['nama'] ?? '') }}
                            </div>
                            <span class="font-bold text-primary text-sm">{{ $report['marketing']['nama'] ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] font-bold text-primary/30 uppercase tracking-widest">
                            <i data-lucide="clock" class="size-3"></i> {{ Format::date($report['tanggal_report']) }} • {{ Format::time($report['created_at']) }}
                        </div>
                    </div>

                    <div class="lg:w-1/4">
                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Konsumen</p>
                        <p class="font-black text-primary">{{ $report['leads']['nama_calon'] ?? 'Umum' }}</p>
                        @if ($report['jenis_aktivitas'])
                            <div class="inline-flex items-center gap-2 px-2 py-0.5 rounded text-[10px] font-bold mt-1 {{ Badge::activity($report['jenis_aktivitas']) }}">
                                {{ $report['jenis_aktivitas_label'] }}
                            </div>
                        @endif
                    </div>

                    <div class="lg:w-1/2">
                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Catatan</p>
                        <p class="text-sm text-primary/60 leading-relaxed italic">"{{ $report['deskripsi_progres'] }}"</p>
                    </div>
                </div>
            @empty
                <p class="p-8 text-center text-primary/40">Belum ada laporan untuk filter ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
