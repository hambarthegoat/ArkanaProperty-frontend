@extends('layouts.dashboard')

@php
    $role = 'admin';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $projects = [
        [
            'id' => 1,
            'name' => 'Arkana Residence Mayangan',
            'location' => 'Kec. Mayangan, Probolinggo',
            'units' => 120, 'sold' => 85, 'available' => 35,
            'status' => 'Active', 'type' => 'Subsidi & Komersil',
            'image' => 'https://images.unsplash.com/photo-1592595894519-575e510d936a?q=80&w=2070',
        ],
        [
            'id' => 2,
            'name' => 'Arkana Premium Kanigaran',
            'location' => 'Kec. Kanigaran, Probolinggo',
            'units' => 45, 'sold' => 12, 'available' => 33,
            'status' => 'Active', 'type' => 'Premium Cluster',
            'image' => 'https://images.unsplash.com/photo-1628744876497-eb30460be9f6?q=80&w=2070',
        ],
        [
            'id' => 3,
            'name' => 'Scandinavian Hill Phase 2',
            'location' => 'Kec. Wonoasih, Probolinggo',
            'units' => 60, 'sold' => 5, 'available' => 55,
            'status' => 'Pre-Launch', 'type' => 'Premium Cluster',
            'image' => 'https://images.unsplash.com/photo-1660361338485-c926a27d4eb8?q=80&w=2070',
        ],
    ];
@endphp

@section('main')
<div class="space-y-8" data-housing>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Kelola Perumahan</h1>
            <p class="text-primary/60">Daftar proyek perumahan aktif dan pengembangan mendatang.</p>
        </div>
        <div class="flex gap-2">
            <div class="bg-white border border-border-subtle rounded-xl p-1 flex" data-view-toggle>
                <button data-view="grid" class="p-2 rounded-lg transition-all bg-surface-soft text-primary shadow-sm">
                    <i data-lucide="layout-grid" class="size-[18px]"></i>
                </button>
                <button data-view="list" class="p-2 rounded-lg transition-all text-primary/40 hover:text-primary">
                    <i data-lucide="list" class="size-[18px]"></i>
                </button>
            </div>
            <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <i data-lucide="plus" class="size-4"></i> Proyek Baru
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($projects as $project)
            <div class="bg-white rounded-[32px] overflow-hidden border border-border-subtle shadow-sm flex flex-col h-full hover:-translate-y-1 transition-transform">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $project['image'] }}" class="w-full h-full object-cover" alt="{{ $project['name'] }}" />
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest text-white {{ $project['status'] === 'Active' ? 'bg-emerald-custom' : 'bg-accent' }}">
                            {{ $project['status'] }}
                        </span>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 text-primary/40 font-bold text-[9px] uppercase tracking-widest mb-2">
                        <i data-lucide="map-pin" class="size-3 text-accent"></i> {{ $project['location'] }}
                    </div>
                    <h3 class="text-lg font-black text-primary mb-2 leading-tight">{{ $project['name'] }}</h3>
                    <p class="text-xs text-primary/40 font-bold uppercase tracking-tighter mb-6">{{ $project['type'] }}</p>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="text-center p-3 bg-surface-soft rounded-2xl">
                            <p class="text-[8px] font-black text-primary/40 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-sm font-black text-primary">{{ $project['units'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-emerald-50 rounded-2xl">
                            <p class="text-[8px] font-black text-emerald-600/60 uppercase tracking-widest mb-1">Terjual</p>
                            <p class="text-sm font-black text-emerald-600">{{ $project['sold'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-orange-50 rounded-2xl">
                            <p class="text-[8px] font-black text-orange-600/60 uppercase tracking-widest mb-1">Sisa</p>
                            <p class="text-sm font-black text-orange-600">{{ $project['available'] }}</p>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-border-subtle flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-surface-soft flex items-center justify-center">
                                <i data-lucide="trending-up" class="size-3.5 text-accent"></i>
                            </div>
                            <span class="text-[10px] font-bold text-primary/60">72% Sold Out</span>
                        </div>
                        <button class="p-2 hover:bg-surface-soft rounded-xl transition-colors">
                            <i data-lucide="arrow-right" class="size-[18px] text-primary/40"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-housing]');
        if (!root) return;
        var buttons = Array.prototype.slice.call(root.querySelectorAll('[data-view-toggle] button'));
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                buttons.forEach(function (b) {
                    b.classList.remove('bg-surface-soft', 'text-primary', 'shadow-sm');
                    b.classList.add('text-primary/40', 'hover:text-primary');
                });
                btn.classList.add('bg-surface-soft', 'text-primary', 'shadow-sm');
                btn.classList.remove('text-primary/40', 'hover:text-primary');
            });
        });
    })();
</script>
@endsection
