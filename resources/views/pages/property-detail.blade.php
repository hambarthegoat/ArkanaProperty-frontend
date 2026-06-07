@extends('layouts.main')

@section('title', 'Design Arkanaproperty Web App')

@php
    $property = [
        'id' => 1,
        'name' => 'Arkanaproperty Residence - Tipe 36/60',
        'price' => '162.000.000',
        'dp' => '5.000.000',
        'installment' => '900rb-an',
        'type' => 'Subsidi',
        'location' => 'Kec. Mayangan, Probolinggo',
        'specs' => '2 KT, 1 KM, Dapur, Carport',
        'desc' => 'Hunian subsidi ternyaman di Probolinggo dengan kualitas bangunan komersil. Lokasi strategis dekat dengan pusat kota, sekolah, dan area perbelanjaan. Cocok untuk keluarga muda yang ingin memiliki rumah pertama.',
        'image' => 'https://images.unsplash.com/photo-1721815693498-cc28507c0ba2?q=80&w=2070',
    ];

    $specs = [
        ['label' => 'Luas Tanah', 'value' => '60 m²', 'icon' => 'maximize'],
        ['label' => 'Luas Bangunan', 'value' => '36 m²', 'icon' => 'home'],
        ['label' => 'Kamar Tidur', 'value' => '2 Ruangan', 'icon' => 'home'],
        ['label' => 'Kamar Mandi', 'value' => '1 Ruangan', 'icon' => 'droplet'],
        ['label' => 'Daya Listrik', 'value' => '1300 Watt', 'icon' => 'zap'],
        ['label' => 'Arah Bangunan', 'value' => 'Utara / Selatan', 'icon' => 'compass'],
    ];
@endphp

@section('main')
<div class="bg-surface-soft min-h-screen pb-20 pt-24">
    <div class="max-w-7xl mx-auto px-4">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary/40 hover:text-accent font-bold text-xs uppercase tracking-widest mb-8 transition-colors group">
            <i data-lucide="chevron-left" class="size-4 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Katalog
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-10">
                {{-- Image Gallery --}}
                <div class="relative rounded-[40px] overflow-hidden shadow-2xl h-[500px]">
                    <img src="{{ $property['image'] }}" class="w-full h-full object-cover" alt="{{ $property['name'] }}" />
                    <div class="absolute bottom-8 right-8 flex gap-3">
                        <button class="p-4 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl text-white hover:bg-white hover:text-primary transition-all">
                            <i data-lucide="maximize" class="size-5"></i>
                        </button>
                        <button class="p-4 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl text-white hover:bg-white hover:text-primary transition-all">
                            <i data-lucide="share-2" class="size-5"></i>
                        </button>
                        <button class="p-4 bg-accent text-white rounded-2xl shadow-xl shadow-accent/20">
                            <i data-lucide="heart" class="size-5" fill="currentColor"></i>
                        </button>
                    </div>
                </div>

                {{-- Title & Info --}}
                <div class="bg-white p-10 rounded-[40px] border border-border-subtle shadow-sm">
                    <div class="flex items-center gap-2 text-accent text-xs font-bold uppercase tracking-widest mb-4">
                        <i data-lucide="home" class="size-3.5"></i> {{ $property['type'] }} Unit
                    </div>
                    <h1 class="text-4xl font-black text-primary mb-6">{{ $property['name'] }}</h1>
                    <div class="flex items-center gap-2 text-primary/40 font-bold text-sm mb-8">
                        <i data-lucide="map-pin" class="size-4 text-accent"></i> {{ $property['location'] }}
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10 pt-10 border-t border-border-subtle">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Harga Mulai</p>
                            <p class="text-xl font-black text-accent">Rp {{ $property['price'] }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Cicilan</p>
                            <p class="text-xl font-black text-primary">{{ $property['installment'] }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Uang Muka</p>
                            <p class="text-xl font-black text-primary">Rp {{ $property['dp'] }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Booking</p>
                            <p class="text-xl font-black text-primary">Rp 1jt</p>
                        </div>
                    </div>

                    <div class="prose prose-slate max-w-none">
                        <h4 class="font-black text-primary text-xl mb-4">Deskripsi Properti</h4>
                        <p class="text-primary/60 leading-relaxed text-lg">{{ $property['desc'] }}</p>
                    </div>
                </div>

                {{-- Specifications --}}
                <div class="bg-white p-10 rounded-[40px] border border-border-subtle shadow-sm">
                    <h4 class="font-black text-primary text-xl mb-8">Spesifikasi Bangunan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        @foreach ($specs as $spec)
                            <div class="flex items-center justify-between py-4 border-b border-border-subtle last:border-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-surface-soft rounded-xl flex items-center justify-center text-accent">
                                        <i data-lucide="{{ $spec['icon'] }}" class="size-5"></i>
                                    </div>
                                    <span class="text-sm font-bold text-primary/60">{{ $spec['label'] }}</span>
                                </div>
                                <span class="font-black text-primary">{{ $spec['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sidebar: Form --}}
            <div class="space-y-8" data-property-sidebar>
                <div class="sticky top-24 bg-primary text-white p-10 rounded-[40px] shadow-2xl">
                    <div data-consult-form-wrapper>
                        <h3 class="text-2xl font-black mb-4">Konsultasi Gratis</h3>
                        <p class="text-white/60 text-sm mb-8">Dapatkan penawaran cicilan khusus dan jadwal survey lokasi gratis hari ini.</p>

                        <form class="space-y-4" data-consult-form>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-2">Nama Lengkap</label>
                                <input required type="text" placeholder="Ahmad Rizky" class="w-full bg-white/10 border border-white/10 rounded-2xl py-4 px-6 focus:bg-white/20 focus:ring-2 focus:ring-accent outline-none font-medium transition-all" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-white/40 uppercase tracking-widest px-2">Nomor WhatsApp</label>
                                <input required type="tel" placeholder="0812xxxxxxxx" class="w-full bg-white/10 border border-white/10 rounded-2xl py-4 px-6 focus:bg-white/20 focus:ring-2 focus:ring-accent outline-none font-medium transition-all" />
                            </div>
                            <button type="submit" class="w-full bg-accent text-white py-5 rounded-2xl font-black text-lg shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                Hubungi Marketing <i data-lucide="arrow-right" class="size-[22px]"></i>
                            </button>
                        </form>
                        <p class="text-[10px] text-center text-white/30 mt-8 leading-relaxed uppercase tracking-tighter">
                            Tanpa biaya pendaftaran. Marketing kami akan memandu Anda sepenuhnya.
                        </p>
                    </div>

                    <div class="text-center py-10 space-y-6 hidden" data-consult-success>
                        <div class="w-20 h-20 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-xl mx-auto">
                            <i data-lucide="check-circle-2" class="size-10"></i>
                        </div>
                        <h3 class="text-2xl font-black">Berhasil!</h3>
                        <p class="text-white/60">Terima kasih atas minat Anda. Tim kami akan menghubungi melalui WhatsApp dalam waktu dekat.</p>
                        <button class="text-accent font-bold hover:underline" data-consult-reset>Kirim pesan lain</button>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm flex items-center gap-6 group cursor-pointer">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <i data-lucide="message-circle" class="size-8"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-primary">Chat WhatsApp</h4>
                        <p class="text-xs text-primary/40">Respon cepat via WA Marketing</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var sidebar = document.querySelector('[data-property-sidebar]');
        if (!sidebar) return;
        var formWrapper = sidebar.querySelector('[data-consult-form-wrapper]');
        var success = sidebar.querySelector('[data-consult-success]');
        var form = sidebar.querySelector('[data-consult-form]');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            formWrapper.classList.add('hidden');
            success.classList.remove('hidden');
        });

        sidebar.querySelector('[data-consult-reset]').addEventListener('click', function () {
            formWrapper.classList.remove('hidden');
            success.classList.add('hidden');
            form.reset();
        });
    })();
</script>
@endsection
