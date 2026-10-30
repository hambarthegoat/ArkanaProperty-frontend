@extends('layouts.dashboard', ['role' => 'user'])

@section('title', 'Timeline Progres - ArkanaProperty')

@php
    $badgeClasses = [
        'Completed' => 'bg-emerald-100 text-emerald-600',
        'Current' => 'bg-accent text-white',
        'Upcoming' => 'bg-slate-200 text-slate-500',
    ];

    $statusLabels = ['Completed' => 'Selesai', 'Current' => 'Sedang Berjalan', 'Upcoming' => 'Berikutnya'];

    $iconCircleClasses = [
        'Completed' => 'bg-emerald-500 text-white',
        'Current' => 'bg-accent text-white scale-110',
        'Upcoming' => 'bg-white text-primary/20 border-2 border-border-subtle',
    ];
@endphp

@section('main')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Timeline Progres</h1>
            <p class="text-primary/60">Pantau setiap tahapan kepemilikan hunian Anda.</p>
        </div>
        @if ($lead)
            <span class="px-4 py-2 bg-white border border-border-subtle rounded-full font-bold text-xs text-primary/60">
                {{ $lead['perumahan']['nama_perumahan'] ?? '' }}{{ $lead['kavling'] ? ' · '.($lead['kavling']['label'] ?? $lead['kavling']['nomor_kavling']) : '' }}
            </span>
        @endif
    </div>

    <div class="bg-white p-8 md:p-12 rounded-[40px] border border-border-subtle shadow-sm">
        <div class="relative">
            <div class="absolute left-[27px] top-2 bottom-2 w-0.5 bg-border-subtle md:left-1/2 md:-translate-x-1/2 hidden sm:block"></div>

            <div class="space-y-12 relative">
                @foreach ($steps as $index => $step)
                    <div class="flex flex-col sm:flex-row items-start gap-8 relative {{ $index % 2 === 0 ? 'sm:flex-row-reverse' : '' }}">
                        <div class="flex-1 w-full sm:w-1/2 {{ $index % 2 === 0 ? 'sm:pl-12' : 'sm:pr-12 text-left sm:text-right' }}">
                            <div class="p-6 rounded-[32px] border transition-all {{ $step['status'] === 'Current' ? 'border-accent bg-accent/5 ring-4 ring-accent/5' : 'border-border-subtle bg-surface-soft/50' }}">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 {{ $badgeClasses[$step['status']] }}">
                                    {{ $statusLabels[$step['status']] }}
                                </div>
                                <h3 class="text-lg font-black text-primary mb-2">{{ $step['title'] }}</h3>
                                <p class="text-sm text-primary/60 leading-relaxed mb-4">{{ $step['desc'] }}</p>
                                @if ($step['date'])
                                    <div class="flex items-center gap-2 text-xs font-bold text-primary/40 {{ $index % 2 === 0 ? '' : 'sm:justify-end' }}">
                                        <i data-lucide="clock" class="size-3.5"></i> {{ $step['date'] }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="absolute left-0 sm:left-1/2 sm:-translate-x-1/2 flex items-center justify-center">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center z-10 shadow-lg transition-transform hover:scale-110 {{ $iconCircleClasses[$step['status']] }}">
                                <i data-lucide="{{ $step['icon'] }}" class="size-6"></i>
                            </div>
                        </div>

                        <div class="flex-1 hidden sm:block"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-primary text-white p-8 rounded-[32px] flex flex-col md:flex-row items-center gap-6">
        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center shrink-0">
            <i data-lucide="shield-check" class="size-8 text-accent"></i>
        </div>
        <div class="flex-grow text-center md:text-left">
            <h4 class="font-black text-lg mb-1">Jaminan Kualitas Bangunan</h4>
            <p class="text-white/60 text-sm">Setiap unit Arkanaproperty melalui proses QC ketat dan memiliki garansi konstruksi selama 12 bulan setelah serah terima.</p>
        </div>
        @if ($lead && $lead['id_tipe'])
            <a href="{{ route('property.show', $lead['id_tipe']) }}" class="px-6 py-3 bg-white text-primary rounded-xl font-bold text-sm whitespace-nowrap hover:bg-accent hover:text-white transition-colors">
                Lihat Spesifikasi Teknis
            </a>
        @endif
    </div>
</div>
@endsection
