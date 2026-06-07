@extends('layouts.dashboard')

@php
    $role = 'admin';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $leads = [
        ['id' => 1, 'name' => 'Ahmad Rizky', 'phone' => '081234567890', 'property' => 'Tipe 36/60', 'status' => 'Hot Prospect', 'date' => '7 Juni 2026'],
        ['id' => 2, 'name' => 'Siti Aminah', 'phone' => '089876543210', 'property' => 'Premium Cluster', 'status' => 'New Lead', 'date' => '7 Juni 2026'],
        ['id' => 3, 'name' => 'Budi Santoso', 'phone' => '081122334455', 'property' => 'Tipe 36/60', 'status' => 'Cold Lead', 'date' => '6 Juni 2026'],
        ['id' => 4, 'name' => 'Dewi Lestari', 'phone' => '085566778899', 'property' => 'Premium Cluster', 'status' => 'Interested', 'date' => '6 Juni 2026'],
    ];

    $kavlingStats = [
        ['label' => 'Total Unit', 'value' => 120, 'color' => 'bg-primary'],
        ['label' => 'Terjual', 'value' => 85, 'color' => 'bg-emerald-custom'],
        ['label' => 'Booking', 'value' => 12, 'color' => 'bg-accent'],
        ['label' => 'Tersedia', 'value' => 23, 'color' => 'bg-slate-200 text-primary'],
    ];

    $statusClasses = [
        'Hot Prospect' => 'bg-orange-100 text-orange-600',
        'New Lead' => 'bg-blue-100 text-blue-600',
    ];
@endphp

@section('main')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Overview Dashboard</h1>
            <p class="text-primary/60">Selamat pagi, Administrator. Berikut ringkasan hari ini.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
                <i data-lucide="filter" class="size-4"></i> Filter Data
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <i data-lucide="plus" class="size-4"></i> Tambah Unit
            </button>
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
                        {{ $stat['value'] }}
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
                <button class="text-accent text-xs font-bold hover:underline">Lihat Semua</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-soft border-b border-border-subtle">
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Property</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        @foreach ($leads as $lead)
                            <tr class="hover:bg-surface-soft/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-primary">{{ $lead['name'] }}</div>
                                    <div class="text-[10px] text-primary/40">{{ $lead['phone'] }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-primary/70">{{ $lead['property'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter {{ $statusClasses[$lead['status']] ?? 'bg-slate-100 text-slate-500' }}">
                                        {{ $lead['status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <button class="p-2 hover:bg-white rounded-lg border border-transparent hover:border-border-subtle transition-all">
                                            <i data-lucide="check-circle-2" class="size-4 text-emerald-custom"></i>
                                        </button>
                                        <button class="p-2 hover:bg-white rounded-lg border border-transparent hover:border-border-subtle transition-all">
                                            <i data-lucide="more-horizontal" class="size-4 text-primary/40"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
                @for ($i = 0; $i < 3; $i++)
                    <div class="relative pl-6 pb-6 border-l-2 border-surface-soft last:pb-0">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-accent border-4 border-white"></div>
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-xs font-black text-primary">Dimas Marketing</p>
                            <span class="text-[10px] text-primary/40">10:30 AM</span>
                        </div>
                        <p class="text-xs text-primary/60 leading-relaxed">
                            Menyelesaikan survey lokasi dengan Bapak Ahmad di unit Premium Cluster Blok A-12.
                        </p>
                        <div class="mt-2 flex gap-2">
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold rounded">Selesai Survey</span>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
