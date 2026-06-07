@extends('layouts.dashboard')

@php
    $role = 'user';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $reminders = [
        ['id' => 1, 'title' => 'Jadwal Survey Lokasi', 'date' => '10 Juni 2026', 'time' => '10:00 WIB', 'desc' => 'Survey bersama Marketing Dimas di Unit Blok A-12.', 'status' => 'Upcoming', 'icon' => 'calendar'],
        ['id' => 2, 'title' => 'Batas Waktu Pembayaran DP', 'date' => '15 Juni 2026', 'time' => '23:59 WIB', 'desc' => 'Segera lakukan pelunasan uang muka sebesar Rp 5.000.000.', 'status' => 'Pending', 'icon' => 'clock'],
        ['id' => 3, 'title' => 'Verifikasi Data Berkas', 'date' => '5 Juni 2026', 'time' => 'Selesai', 'desc' => 'KTP, KK, dan NPWP telah diverifikasi oleh tim admin.', 'status' => 'Completed', 'icon' => 'check-circle-2'],
    ];

    $statusIconClasses = [
        'Completed' => 'bg-emerald-100 text-emerald-600',
        'Pending' => 'bg-orange-100 text-orange-600',
        'Upcoming' => 'bg-blue-100 text-blue-600',
    ];
@endphp

@section('main')
<div class="max-w-4xl mx-auto space-y-10 relative">
    {{-- Welcome Section --}}
    <div class="flex flex-col md:flex-row items-center gap-8 bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
        <div class="w-24 h-24 bg-surface-soft rounded-full overflow-hidden border-2 border-accent shrink-0">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Ahmad" alt="User" />
        </div>
        <div class="text-center md:text-left flex-grow">
            <h1 class="text-3xl font-black text-primary mb-1">Halo, Bapak Ahmad!</h1>
            <p class="text-primary/60">Selamat datang di portal Arkanaproperty. Unit Anda di <span class="font-bold text-accent">Blok A-12</span> sedang dalam tahap persiapan berkas.</p>
        </div>
        <div class="hidden lg:flex gap-4">
            <div class="text-center p-4 bg-surface-soft rounded-2xl min-w-[120px]">
                <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Unit Type</p>
                <p class="font-black text-primary">Tipe 36/60</p>
            </div>
        </div>
    </div>

    {{-- Progress Timeline --}}
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-primary flex items-center gap-2">
                <i data-lucide="bell" class="size-5 text-accent"></i> Agenda & Timeline
            </h2>
            <span class="text-xs font-bold text-primary/40 uppercase tracking-widest">Update: 7 Juni 2026</span>
        </div>

        <div class="space-y-4">
            @foreach ($reminders as $item)
                <div class="flex gap-6 p-6 bg-white rounded-3xl border {{ $item['status'] === 'Pending' ? 'border-orange-200 bg-orange-50/30' : 'border-border-subtle' }} shadow-sm group hover:shadow-md transition-all">
                    <div class="shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center {{ $statusIconClasses[$item['status']] }}">
                        <i data-lucide="{{ $item['icon'] }}" class="size-6"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-2">
                            <h3 class="font-bold text-lg text-primary">{{ $item['title'] }}</h3>
                            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-primary/40">
                                <i data-lucide="calendar" class="size-3"></i> {{ $item['date'] }} • {{ $item['time'] }}
                            </div>
                        </div>
                        <p class="text-sm text-primary/60 leading-relaxed max-w-xl">{{ $item['desc'] }}</p>
                        @if ($item['status'] === 'Pending')
                            <button class="mt-4 flex items-center gap-2 text-xs font-bold text-orange-600 hover:gap-3 transition-all">
                                Lakukan Pembayaran Sekarang <i data-lucide="chevron-right" class="size-3.5"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Resource Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-primary text-white p-8 rounded-[32px] relative overflow-hidden group cursor-pointer shadow-xl">
            <div class="relative z-10">
                <i data-lucide="file-text" class="text-accent mb-4 size-8"></i>
                <h4 class="font-black text-xl mb-2">Dokumen Digital</h4>
                <p class="text-white/60 text-sm mb-6">Unduh brosur, denah unit, dan salinan berkas verifikasi Anda di sini.</p>
                <div class="inline-flex items-center gap-2 text-xs font-bold py-2 px-4 bg-white/10 rounded-full group-hover:bg-accent transition-colors">
                    Lihat Dokumen <i data-lucide="chevron-right" class="size-4"></i>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/5 rounded-full translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
        </div>

        <div class="bg-white border border-border-subtle p-8 rounded-[32px] group cursor-pointer shadow-sm hover:shadow-xl transition-all">
            <i data-lucide="map-pin" class="text-accent mb-4 size-8"></i>
            <h4 class="font-black text-xl text-primary mb-2">Lokasi Unit Anda</h4>
            <p class="text-primary/60 text-sm mb-6">Akses Google Maps menuju lokasi perumahan dan posisi spesifik unit Anda.</p>
            <div class="inline-flex items-center gap-2 text-xs font-bold py-2 px-4 bg-surface-soft text-primary rounded-full group-hover:bg-primary group-hover:text-white transition-colors">
                Buka Maps <i data-lucide="chevron-right" class="size-4"></i>
            </div>
        </div>
    </div>

    <div class="pt-10 flex items-center justify-center gap-4 text-primary/40">
        <i data-lucide="info" class="size-4"></i>
        <p class="text-[10px] font-bold uppercase tracking-widest">Butuh bantuan lain? Hubungi marketing agent Anda.</p>
    </div>

    {{-- Floating Action Button --}}
    <button class="fixed bottom-10 right-10 w-16 h-16 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-2xl shadow-emerald-custom/40 z-[99] group hover:scale-110 active:scale-90 transition-transform">
        <i data-lucide="message-circle" class="size-8"></i>
        <div class="absolute right-full mr-4 bg-white text-primary px-4 py-2 rounded-xl border border-border-subtle shadow-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap text-sm font-bold pointer-events-none">
            Hubungi Marketing
        </div>
    </button>
</div>
@endsection
