@extends('layouts.dashboard', ['role' => 'admin'])

@section('title', 'Dashboard Admin - ArkanaProperty')

@php
    use App\Support\Badge;
    use App\Support\Format;

    $kavlingStats = [
        ['label' => 'Total Unit', 'value' => $summary['unit']['total'], 'color' => 'bg-primary'],
        ['label' => 'Terjual', 'value' => $summary['unit']['terjual'], 'color' => 'bg-emerald-custom'],
        ['label' => 'Booking', 'value' => $summary['unit']['booking'], 'color' => 'bg-accent'],
        ['label' => 'Tersedia', 'value' => $summary['unit']['tersedia'], 'color' => 'bg-slate-200 text-primary'],
    ];
@endphp

@section('main')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Overview Dashboard</h1>
            <p class="text-primary/60">
                Selamat datang, {{ session('api.akun.nama', 'Administrator') }}.
                {{ $summary['leads']['pending'] }} lead menunggu validasi dari {{ $summary['perumahan'] }} perumahan dan {{ $summary['marketing'] }} marketing aktif.
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.leads', ['status' => 'pending']) }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
                <i data-lucide="filter" class="size-4"></i> Leads Menunggu
            </a>
            <a href="{{ route('admin.kavling') }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <i data-lucide="plus" class="size-4"></i> Tambah Unit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($kavlingStats as $stat)
            <div class="bg-white p-6 rounded-3xl border border-border-subtle shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                    <h3 class="text-3xl font-black text-primary">{{ $stat['value'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl {{ $stat['color'] }} flex items-center justify-center text-white font-bold">
                    @if ($stat['label'] === 'Total Unit')
                        <i data-lucide="home" class="size-6"></i>
                    @else
                        {{ $summary['unit']['total'] ? round($stat['value'] / $summary['unit']['total'] * 100) : 0 }}%
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Recent Leads Table --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-border-subtle shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-border-subtle flex items-center justify-between">
                <h3 class="font-black text-primary flex items-center gap-2">
                    <i data-lucide="users" class="size-[18px] text-accent"></i> Data Leads Terbaru
                </h3>
                <a href="{{ route('admin.leads') }}" class="text-accent text-xs font-bold hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-soft border-b border-border-subtle">
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Property</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        @forelse ($summary['leads_terbaru'] as $lead)
                            <tr class="hover:bg-surface-soft/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-primary">{{ $lead['nama_calon'] }}</div>
                                    <div class="text-[10px] text-primary/40">{{ $lead['no_telp'] }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-primary/70">
                                    {{ $lead['tipe_rumah']['nama_tipe'] ?? '-' }}
                                    <div class="text-[10px] text-primary/40">{{ $lead['perumahan']['nama_perumahan'] ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter {{ Badge::leadStatus($lead['status_keseriusan']) }}">
                                        {{ $lead['status_label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-primary/50">{{ Format::date($lead['created_at'], 'D MMM YYYY') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-10 text-center text-primary/40">Belum ada lead masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Marketing Activity Feed --}}
        <div class="bg-white rounded-3xl border border-border-subtle shadow-sm p-6">
            <h3 class="font-black text-primary mb-6 flex items-center gap-2">
                <i data-lucide="trending-up" class="size-[18px] text-accent"></i> Laporan Marketing
            </h3>
            <div class="space-y-6">
                @forelse ($summary['report_terbaru'] as $report)
                    <div class="relative pl-6 pb-6 border-l-2 border-surface-soft last:pb-0">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-accent border-4 border-white"></div>
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-xs font-black text-primary">{{ $report['marketing']['nama'] ?? '-' }}</p>
                            <span class="text-[10px] text-primary/40">{{ Format::date($report['tanggal_report'], 'D MMM') }}</span>
                        </div>
                        <p class="text-xs text-primary/60 leading-relaxed">{{ $report['deskripsi_progres'] }}</p>
                        @if ($report['jenis_aktivitas'])
                            <div class="mt-2 flex gap-2">
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded {{ Badge::activity($report['jenis_aktivitas']) }}">{{ $report['jenis_aktivitas_label'] }}</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-primary/40">Belum ada laporan.</p>
                @endforelse
            </div>
            <a href="{{ route('admin.reports') }}" class="mt-6 inline-block text-accent text-xs font-bold hover:underline">Semua laporan</a>
        </div>
    </div>
</div>
@endsection
