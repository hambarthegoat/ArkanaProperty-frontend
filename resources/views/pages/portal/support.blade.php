@extends('layouts.dashboard', ['role' => 'user'])
@section('title', 'Pusat Bantuan - ArkanaProperty')

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

    @if ($contact)
        <div class="bg-white p-8 rounded-[32px] border border-border-subtle shadow-sm flex flex-col md:flex-row items-center justify-between gap-6" data-marketing-contact>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="user-check" class="size-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Marketing Pendamping Anda</p>
                    <h3 class="font-black text-primary text-lg">{{ $contact['nama'] }}</h3>
                    <p class="text-sm text-primary/60">{{ $contact['no_wa'] }}</p>
                </div>
            </div>
            @if ($contact['wa_link'])
                <a href="{{ $contact['wa_link'] }}" target="_blank" rel="noopener" class="px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black flex items-center gap-2 hover:bg-emerald-600 transition-all">
                    <i data-lucide="message-square" class="size-5"></i> Chat WhatsApp
                </a>
            @endif
        </div>
    @else
        <div class="p-6 bg-orange-50 border border-orange-100 rounded-3xl text-sm font-semibold text-orange-700">
            Marketing pendamping belum ditugaskan. Tim admin akan segera menghubungi Anda.
        </div>
    @endif

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
