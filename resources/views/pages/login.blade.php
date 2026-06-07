@extends('layouts.base')

@section('title', 'Design Arkanaproperty Web App')

@php
    $roles = [
        ['id' => 'admin', 'label' => 'Panel Admin', 'path' => route('admin.dashboard'), 'description' => 'Kelola data, leads & marketing'],
        ['id' => 'marketing', 'label' => 'Dashboard Marketing', 'path' => route('marketing.dashboard'), 'description' => 'Kelola leads & laporan harian'],
        ['id' => 'user', 'label' => 'Portal Penghuni', 'path' => route('portal.dashboard'), 'description' => 'Pantau progres unit Anda'],
    ];
@endphp

@section('content')
<div class="flex min-h-screen bg-surface-soft font-sans">
    {{-- Left side: Form/Navigation --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-20">
        <div class="max-w-md w-full">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-primary mb-2">
                    Arkana<span class="text-accent">Property</span>
                </h1>
                <p class="text-primary/60">Selamat datang kembali. Silakan pilih akses masuk Anda untuk melanjutkan.</p>
            </div>

            <div class="space-y-4">
                @foreach ($roles as $role)
                    <a href="{{ $role['path'] }}" class="group w-full flex items-center justify-between p-6 bg-white border border-border-subtle rounded-2xl hover:border-accent hover:shadow-xl hover:shadow-accent/5 transition-all text-left">
                        <div>
                            <h3 class="font-bold text-lg text-primary group-hover:text-accent transition-colors">{{ $role['label'] }}</h3>
                            <p class="text-sm text-primary/60">{{ $role['description'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-surface-soft flex items-center justify-center group-hover:bg-accent group-hover:text-white transition-all">
                            <i data-lucide="arrow-right" class="size-5"></i>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12 pt-8 border-t border-border-subtle text-center">
                <p class="text-sm text-primary/40">
                    Butuh bantuan akses? Hubungi Admin IT Kami
                </p>
            </div>
        </div>
    </div>

    {{-- Right side: Visual --}}
    <div class="hidden lg:block lg:w-1/2 bg-primary relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070')] bg-cover bg-center opacity-40 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-tr from-primary via-transparent to-transparent"></div>

        <div class="absolute bottom-20 left-20 right-20">
            <div>
                <h2 class="text-4xl font-bold text-white mb-4 italic">"Rumah bukan hanya sekadar tempat tinggal, tapi investasi masa depan."</h2>
                <div class="flex items-center gap-4 text-white/60">
                    <div class="w-12 h-[2px] bg-accent"></div>
                    <span>Arkanaproperty Team</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
