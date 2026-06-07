@extends('layouts.dashboard')

@php
    $role = 'user';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $categories = [
        ['title' => 'Pembayaran & KPR', 'desc' => 'Masalah cicilan, konfirmasi transfer, atau berkas bank.'],
        ['title' => 'Progres Pembangunan', 'desc' => 'Tanya jadwal finishing atau serah terima kunci.'],
        ['title' => 'Komplain Unit', 'desc' => 'Lapor kerusakan atau renovasi selama masa garansi.'],
        ['title' => 'Teknis Aplikasi', 'desc' => 'Masalah login portal atau notifikasi tidak masuk.'],
    ];
@endphp

@section('main')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-black text-primary">Pusat Bantuan</h1>
        <p class="text-primary/60">Kami siap membantu setiap kendala hunian Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($categories as $cat)
            <div class="bg-white p-8 rounded-[32px] border border-border-subtle shadow-sm hover:border-accent transition-all group">
                <h3 class="font-black text-primary mb-2 group-hover:text-accent transition-colors">{{ $cat['title'] }}</h3>
                <p class="text-xs text-primary/60 leading-relaxed">{{ $cat['desc'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-primary text-white p-10 rounded-[40px] shadow-2xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
            <div class="max-w-md">
                <h2 class="text-2xl font-black mb-4 italic">Pusat Layanan Terpadu</h2>
                <p class="text-white/60 text-sm">Untuk semua kendala di atas, hubungi Customer Care resmi ArkanaProperty melalui WhatsApp resmi kami.</p>
            </div>
            <div class="flex flex-col gap-4 w-full lg:w-auto">
                <a href="https://wa.me/628123456789" class="px-8 py-4 bg-accent text-white rounded-2xl font-black flex items-center justify-center gap-3 hover:scale-105 transition-all shadow-xl shadow-accent/20">
                    <i data-lucide="message-square" class="size-6"></i> Chat Customer Care
                </a>
                <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest text-center">Tersedia: Senin - Sabtu (08:00 - 17:00 WIB)</p>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/3 -translate-y-1/3"></div>
    </div>
</div>
@endsection
