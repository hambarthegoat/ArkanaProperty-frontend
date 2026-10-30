@extends('layouts.dashboard', ['role' => 'user'])

@section('title', 'Portal Konsumen - ArkanaProperty')

@php
    $lead = $profile['lead'];
    $kavling = $lead['kavling'] ?? null;

    $statusIconClasses = [
        'Completed' => 'bg-emerald-100 text-emerald-600',
        'Upcoming' => 'bg-blue-100 text-blue-600',
    ];
@endphp

@section('main')
<div class="max-w-4xl mx-auto space-y-10 relative">
    {{-- Welcome Section --}}
    <div class="flex flex-col md:flex-row items-center gap-8 bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
        <div class="w-24 h-24 bg-surface-soft rounded-full overflow-hidden border-2 border-accent shrink-0">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($profile['akun']['username']) }}" alt="User" />
        </div>
        <div class="text-center md:text-left flex-grow">
            <h1 class="text-3xl font-black text-primary mb-1">Halo, {{ $profile['akun']['nama'] }}!</h1>
            <p class="text-primary/60">
                Selamat datang di portal Arkanaproperty.
                @if ($kavling)
                    Unit Anda di <span class="font-bold text-accent">{{ $kavling['blok'] ? $kavling['blok'].' · ' : '' }}{{ $kavling['label'] ?? $kavling['nomor_kavling'] }}</span> berstatus {{ strtolower($kavling['status_label']) }}.
                @elseif ($lead)
                    Anda terdaftar untuk {{ $lead['perumahan']['nama_perumahan'] ?? 'perumahan kami' }}.
                @endif
                @if ($currentStep)
                    Tahap saat ini: <span class="font-bold text-primary">{{ $currentStep['judul'] }}</span>.
                @endif
            </p>
        </div>
        <div class="hidden lg:flex gap-4">
            <div class="text-center p-4 bg-surface-soft rounded-2xl min-w-[120px]">
                <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Unit Type</p>
                <p class="font-black text-primary">{{ $kavling['tipe_rumah']['nama_tipe'] ?? $lead['tipe_rumah']['nama_tipe'] ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Progress Timeline --}}
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-primary flex items-center gap-2">
                <i data-lucide="bell" class="size-5 text-accent"></i> Agenda & Timeline
            </h2>
            <a href="{{ route('portal.reminders') }}" class="text-xs font-bold text-accent uppercase tracking-widest hover:underline">Lihat Timeline</a>
        </div>

        <div class="space-y-4">
            @forelse ($reminders as $item)
                <div class="flex gap-6 p-6 bg-white rounded-3xl border {{ $item['status'] === 'Upcoming' ? 'border-blue-100' : 'border-border-subtle opacity-80' }} shadow-sm group hover:shadow-md transition-all">
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
                    </div>
                </div>
            @empty
                <div class="p-8 bg-white rounded-3xl border border-border-subtle text-center text-primary/40 text-sm">
                    Belum ada agenda. Marketing Anda akan menjadwalkan survey atau pertemuan di sini.
                </div>
            @endforelse
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

        <a href="https://www.google.com/maps/search/{{ urlencode(($lead['perumahan']['nama_perumahan'] ?? 'ArkanaProperty').' '.($lead['perumahan']['lokasi'] ?? 'Probolinggo')) }}" target="_blank" rel="noopener" class="block bg-white border border-border-subtle p-8 rounded-[32px] group cursor-pointer shadow-sm hover:shadow-xl transition-all">
            <i data-lucide="map-pin" class="text-accent mb-4 size-8"></i>
            <h4 class="font-black text-xl text-primary mb-2">Lokasi Unit Anda</h4>
            <p class="text-primary/60 text-sm mb-6">{{ $lead['perumahan']['nama_perumahan'] ?? 'Perumahan' }} — {{ $lead['perumahan']['lokasi'] ?? 'Probolinggo' }}.</p>
            <div class="inline-flex items-center gap-2 text-xs font-bold py-2 px-4 bg-surface-soft text-primary rounded-full group-hover:bg-primary group-hover:text-white transition-colors">
                Buka Maps <i data-lucide="chevron-right" class="size-4"></i>
            </div>
        </a>
    </div>

    <div class="pt-10 flex items-center justify-center gap-4 text-primary/40">
        <i data-lucide="info" class="size-4"></i>
        <p class="text-[10px] font-bold uppercase tracking-widest">
            Butuh bantuan lain? Hubungi marketing agent Anda{{ $contact ? ': '.$contact['nama'] : '' }}.
        </p>
    </div>

    {{-- Floating Action Button --}}
    @if ($contact && $contact['wa_link'])
    <a href="{{ $contact['wa_link'] }}" target="_blank" rel="noopener" class="fixed bottom-10 right-10 w-16 h-16 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-2xl shadow-emerald-custom/40 z-[99] group hover:scale-110 active:scale-90 transition-transform" data-contact-marketing>
        <i data-lucide="message-circle" class="size-8"></i>
        <div class="absolute right-full mr-4 bg-white text-primary px-4 py-2 rounded-xl border border-border-subtle shadow-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap text-sm font-bold pointer-events-none">
            Hubungi {{ $contact['nama'] }}
        </div>
    </a>
    @endif
</div>
@endsection
