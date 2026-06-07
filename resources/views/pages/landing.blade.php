@extends('layouts.main')

@section('title', 'Design Arkanaproperty Web App')

@php
    $properties = [
        [
            'id' => 1,
            'name' => 'Arkanaproperty Residence - Tipe 36/60',
            'price' => '162.000.000',
            'dp' => '5.000.000',
            'installment' => '900rb-an',
            'type' => 'Subsidi',
            'location' => 'Kec. Mayangan, Probolinggo',
            'specs' => '2 KT, 1 KM, Dapur, Carport',
            'image' => 'https://images.unsplash.com/photo-1721815693498-cc28507c0ba2?q=80&w=2070',
        ],
        [
            'id' => 2,
            'name' => 'Arkana Premium Cluster',
            'price' => '450.000.000',
            'dp' => '45.000.000',
            'installment' => '3jt-an',
            'type' => 'Cluster Premium',
            'location' => 'Kec. Kanigaran, Probolinggo',
            'specs' => '3 KT, 2 KM, Private Garden, Smart Home',
            'image' => 'https://images.unsplash.com/photo-1628744876497-eb30460be9f6?q=80&w=2070',
        ],
        [
            'id' => 3,
            'name' => 'Scandinavian Hill - Phase 2',
            'price' => '575.000.000',
            'dp' => '57.000.000',
            'installment' => '4jt-an',
            'type' => 'Cluster Premium',
            'location' => 'Kec. Wonoasih, Probolinggo',
            'specs' => '3 KT, 2 KM, Attic Room, Balcony',
            'image' => 'https://images.unsplash.com/photo-1660361338485-c926a27d4eb8?q=80&w=2070',
        ],
    ];

    $whyUs = [
        ['title' => 'Legalitas Terjamin', 'desc' => 'Seluruh unit memiliki sertifikat (SHM) dan perizinan IMB/PBG yang lengkap dan aman.', 'icon' => 'shield-check'],
        ['title' => 'Lokasi Strategis', 'desc' => 'Akses mudah menuju pusat kota, sekolah, rumah sakit, dan fasilitas publik lainnya.', 'icon' => 'map-pin'],
        ['title' => 'Kualitas Bangunan', 'desc' => 'Material pilihan dan pengawasan konstruksi ketat untuk hunian tahan lama.', 'icon' => 'check-circle-2'],
        ['title' => 'Proses Transparan', 'desc' => 'Pantau progres berkas dan pembangunan unit Anda secara real-time melalui portal.', 'icon' => 'clock'],
    ];

    $testimonials = [
        ['name' => 'Bpk. Rendi Saputra', 'role' => 'Pembeli Tipe 36', 'content' => 'Prosesnya sangat cepat dan transparan. Marketing sangat membantu dalam pengurusan berkas KPR sampai akad.', 'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Rendi'],
        ['name' => 'Ibu Maya Lestari', 'role' => 'Investor Properti', 'content' => 'Lokasi perumahan Arkanaproperty selalu strategis. Nilai investasinya naik signifikan setiap tahunnya.', 'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Maya'],
        ['name' => 'Bpk. Hendra Kurniawan', 'role' => 'Pembeli Premium Cluster', 'content' => 'Kualitas bangunan jempolan. Desainnya modern dan lingkungannya sangat asri untuk anak-anak.', 'image' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Hendra'],
    ];
@endphp

@section('main')
<div class="bg-surface-soft pb-20" x-cloak data-landing>
    {{-- Hero Section --}}
    <section class="relative h-[85vh] flex items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070" class="w-full h-full object-cover" alt="Hero Background" />
            <div class="absolute inset-0 bg-primary/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/20 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="max-w-3xl">
                <span class="inline-block px-4 py-1 bg-accent text-white rounded-full text-xs font-bold tracking-widest uppercase mb-6">
                    Pilihan Terpercaya di Probolinggo
                </span>
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-[1.1]">
                    Wujudkan Hunian Impian Keluarga Anda.
                </h1>
                <p class="text-xl text-white/80 mb-10 max-w-2xl">
                    Temukan berbagai pilihan rumah subsidi dan cluster premium dengan akses strategis dan lingkungan asri di jantung kota Probolinggo.
                </p>
                <div class="flex flex-wrap gap-4 mb-6">
                    <a href="#katalog" class="btn-primary flex items-center gap-2">
                        Lihat Katalog Properti <i data-lucide="arrow-right" class="size-5"></i>
                    </a>
                    <button class="btn-gold-outline !text-white border-white hover:bg-white hover:text-primary">
                        Konsultasi Gratis
                    </button>
                </div>

                <div class="flex gap-8 border-t border-white/10 pt-4">
                    <div>
                        <p class="text-accent text-3xl font-black">500+</p>
                        <p class="text-white/60 text-xs font-bold uppercase tracking-widest">Unit Terjual</p>
                    </div>
                    <div class="w-[1px] h-20 bg-white/10 -mt-8"></div>
                    <div>
                        <p class="text-accent text-3xl font-black">12+</p>
                        <p class="text-white/60 text-xs font-bold uppercase tracking-widest">Proyek Berjalan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Filter Widget --}}
    <section class="relative -mt-12 z-10 px-4">
        <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl p-8 lg:p-10 border border-border-subtle">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="map-pin" class="size-3.5 text-accent"></i> Lokasi
                    </label>
                    <select class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none">
                        <option>Seluruh Probolinggo</option>
                        <option>Kec. Mayangan</option>
                        <option>Kec. Kanigaran</option>
                        <option>Kec. Wonoasih</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="wallet" class="size-3.5 text-accent"></i> Kisaran Budget
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="number" placeholder="Min" class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold text-sm outline-none" />
                        <span class="text-primary/20">-</span>
                        <input type="number" placeholder="Max" class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold text-sm outline-none" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="clock" class="size-3.5 text-accent"></i> Lama Angsuran
                    </label>
                    <select class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none">
                        <option>Pilih Tenor</option>
                        <option>5 Tahun</option>
                        <option>10 Tahun</option>
                        <option>15 Tahun</option>
                        <option>20 Tahun</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="home" class="size-3.5 text-accent"></i> Jenis Rumah
                    </label>
                    <div class="flex gap-2">
                        <select class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none" data-filter-type>
                            <option>Semua Jenis</option>
                            <option>Subsidi</option>
                            <option>Cluster Premium</option>
                        </select>
                        <button class="bg-primary text-white p-3 rounded-xl hover:bg-accent transition-colors shrink-0" data-search-btn>
                            <i data-lucide="search" class="size-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Property List --}}
    <section id="katalog" class="max-w-7xl mx-auto px-4 mt-24">
        <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-6">
            <div class="max-w-xl">
                <span class="text-accent text-xs font-black uppercase tracking-[0.3em] mb-4 inline-block">Katalog Properti</span>
                <h2 class="text-4xl md:text-5xl font-black text-primary leading-tight">Temukan Unit Pilihan Untuk Keluarga Anda.</h2>
            </div>
            <div class="flex gap-4 mb-2">
                <button class="p-4 bg-white border border-border-subtle rounded-2xl text-primary hover:border-accent transition-all shadow-sm">
                    <i data-lucide="arrow-right" class="size-5 rotate-180"></i>
                </button>
                <button class="p-4 bg-white border border-border-subtle rounded-2xl text-primary hover:border-accent transition-all shadow-sm">
                    <i data-lucide="arrow-right" class="size-5"></i>
                </button>
            </div>
        </div>

        <div class="py-20 flex-col items-center justify-center space-y-4 hidden" data-searching>
            <div class="w-12 h-12 border-4 border-accent border-t-transparent rounded-full animate-spin mx-auto"></div>
            <p class="font-bold text-primary/40 uppercase tracking-widest text-xs text-center">Mencari Properti Terbaik...</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-property-grid>
            @foreach ($properties as $property)
                <div class="bg-white rounded-[40px] overflow-hidden border border-border-subtle shadow-sm group hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500 flex flex-col h-full" data-property-card data-type="{{ $property['type'] }}">
                    <div class="relative h-72 overflow-hidden shrink-0">
                        <img src="{{ $property['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $property['name'] }}" />
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-white {{ $property['type'] === 'Subsidi' ? 'bg-blue-600' : 'bg-accent' }}">
                                {{ $property['type'] }}
                            </span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-primary/40 font-bold text-[10px] uppercase tracking-widest mb-3">
                            <i data-lucide="map-pin" class="size-3 text-accent"></i> {{ $property['location'] }}
                        </div>
                        <h3 class="text-xl font-black text-primary mb-4 line-clamp-2 leading-tight group-hover:text-accent transition-colors">
                            {{ $property['name'] }}
                        </h3>

                        <div class="grid grid-cols-2 gap-4 mb-8 pt-6 border-t border-border-subtle">
                            <div>
                                <p class="text-[9px] font-bold text-primary/40 uppercase tracking-widest mb-1">Harga Mulai</p>
                                <p class="text-lg font-black text-primary">Rp {{ $property['price'] }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-primary/40 uppercase tracking-widest mb-1">Cicilan / bln</p>
                                <p class="text-lg font-black text-accent">{{ $property['installment'] }}</p>
                            </div>
                        </div>

                        <div class="mt-auto flex items-center justify-between gap-4">
                            <button class="flex-grow btn-primary !py-4 text-xs" data-open-property='@json($property)'>
                                Detail Unit
                            </button>
                            <a href="{{ route('property.show', $property['id']) }}" class="p-4 bg-surface-soft text-primary rounded-2xl hover:bg-primary hover:text-white transition-all shadow-sm">
                                <i data-lucide="arrow-right" class="size-[18px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="py-20 text-center bg-white rounded-[40px] border border-border-subtle hidden" data-empty-state>
            <h3 class="text-xl font-black text-primary mb-2">Properti Tidak Ditemukan</h3>
            <p class="text-primary/60">Coba ubah kriteria pencarian atau pilih jenis rumah yang berbeda.</p>
        </div>

        <div class="mt-16 text-center">
            <button class="btn-gold-outline inline-flex items-center gap-3">
                Lihat Semua Unit Properti <i data-lucide="arrow-right" class="size-[18px]"></i>
            </button>
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="bg-primary text-white py-24 mt-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-accent text-xs font-black uppercase tracking-[0.3em] mb-4 inline-block">Keunggulan Kami</span>
                <h2 class="text-4xl md:text-5xl font-black mb-6">Mengapa Arkanaproperty?</h2>
                <p class="text-white/60 max-w-2xl mx-auto">Kami tidak hanya membangun rumah, kami membangun masa depan keluarga Anda dengan standar kualitas terbaik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($whyUs as $item)
                    <div class="bg-white/5 p-8 rounded-[32px] border border-white/10 hover:bg-white/10 transition-all group">
                        <div class="w-14 h-14 bg-accent/20 text-accent rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <i data-lucide="{{ $item['icon'] }}" class="size-7"></i>
                        </div>
                        <h4 class="text-xl font-black mb-3">{{ $item['title'] }}</h4>
                        <p class="text-white/60 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-24 max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between mb-16 gap-8">
            <div class="text-center md:text-left">
                <h2 class="text-4xl font-black text-primary mb-4">Apa Kata Mereka?</h2>
                <p class="text-primary/60">Lebih dari 500 keluarga telah mempercayakan hunian mereka kepada kami.</p>
            </div>
            <button class="btn-gold-outline">Lihat Semua Review</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($testimonials as $item)
                <div class="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm relative hover:scale-[1.02] transition-transform">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ $item['image'] }}" class="w-12 h-12 rounded-full bg-surface-soft border border-border-subtle" alt="{{ $item['name'] }}" />
                        <div>
                            <h4 class="font-bold text-primary text-sm">{{ $item['name'] }}</h4>
                            <p class="text-[10px] text-primary/40 font-bold uppercase tracking-widest">{{ $item['role'] }}</p>
                        </div>
                    </div>
                    <p class="text-primary/70 text-sm italic leading-relaxed">"{{ $item['content'] }}"</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Contact CTA --}}
    <section class="max-w-7xl mx-auto px-4 mb-24">
        <div class="bg-accent rounded-[48px] p-8 md:p-16 flex flex-col md:flex-row items-center justify-between gap-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full translate-x-1/3 -translate-y-1/3"></div>
            <div class="relative z-10 text-center md:text-left">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6 leading-tight">Mulai Perjalanan Hunian <br/>Impian Anda Sekarang.</h2>
                <p class="text-white/80 text-lg mb-8 max-w-lg">Konsultasikan kebutuhan hunian Anda dengan tim ahli kami secara gratis.</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <button class="px-8 py-4 bg-primary text-white rounded-2xl font-black flex items-center gap-3 hover:scale-105 transition-all shadow-2xl shadow-primary/40">
                        <i data-lucide="message-circle" class="size-6"></i> Hubungi Lewat WhatsApp
                    </button>
                    <button class="px-8 py-4 bg-white text-primary rounded-2xl font-black hover:scale-105 transition-all shadow-xl shadow-white/20">
                        Lihat Lokasi Project
                    </button>
                </div>
            </div>
            <div class="hidden lg:block relative z-10">
                <div class="w-80 h-80 bg-white/20 backdrop-blur-xl rounded-[60px] p-10 flex flex-col justify-center">
                    <i data-lucide="phone" class="size-12 text-white mb-6"></i>
                    <p class="text-white/60 text-sm font-bold uppercase tracking-widest mb-2">Layanan 24/7</p>
                    <h4 class="text-white text-3xl font-black">(0335) 423-123</h4>
                </div>
            </div>
        </div>
    </section>

    {{-- Property Detail Modal & Lead Form --}}
    <div class="fixed inset-0 z-[100] items-center justify-center p-4 hidden" data-property-modal>
        <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" data-modal-backdrop></div>

        <div class="relative w-full max-w-5xl bg-white rounded-[32px] overflow-hidden shadow-2xl flex flex-col lg:flex-row max-h-[90vh]">
            <button class="absolute top-6 right-6 z-50 p-3 bg-white/10 hover:bg-white/20 backdrop-blur-xl border border-white/20 rounded-full text-white lg:text-primary lg:bg-surface-soft lg:border-border-subtle transition-all" data-modal-close>
                <i data-lucide="x" class="size-5"></i>
            </button>

            <div class="lg:w-3/5 overflow-y-auto">
                <div class="h-80 lg:h-96 w-full">
                    <img src="" class="w-full h-full object-cover" alt="" data-modal-image />
                </div>
                <div class="p-10">
                    <div class="flex items-center gap-2 text-accent text-xs font-bold uppercase tracking-widest mb-4">
                        <i data-lucide="home" class="size-3.5"></i> <span data-modal-type></span> Unit
                    </div>
                    <h2 class="text-3xl font-black text-primary mb-6" data-modal-name></h2>

                    <div class="grid grid-cols-2 gap-8 mb-10">
                        <div class="p-6 bg-surface-soft rounded-2xl">
                            <p class="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">Booking Fee</p>
                            <p class="text-xl font-black text-primary">Rp 1.000.000</p>
                        </div>
                        <div class="p-6 bg-surface-soft rounded-2xl">
                            <p class="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">Uang Muka (DP)</p>
                            <p class="text-xl font-black text-accent">Rp <span data-modal-dp></span></p>
                        </div>
                    </div>

                    <h4 class="font-black text-primary mb-4">Spesifikasi Bangunan</h4>
                    <ul class="grid grid-cols-2 gap-y-3 gap-x-6 text-primary/70 mb-10">
                        <li class="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Pondasi Batu Kali</li>
                        <li class="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Dinding Bata Ringan</li>
                        <li class="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Rangka Atap Galvalum</li>
                        <li class="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Lantai Granit 60x60</li>
                        <li class="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Listrik 1300 Watt</li>
                        <li class="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Air Bersih PDAM</li>
                    </ul>
                </div>
            </div>

            <div class="lg:w-2/5 bg-surface-soft p-10 flex flex-col border-l border-border-subtle">
                <div data-lead-form-wrapper>
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-primary mb-2">Tertarik dengan Unit Ini?</h3>
                        <p class="text-primary/60 text-sm">Isi data di bawah ini, Marketing kami akan segera menghubungi Anda melalui WhatsApp.</p>
                    </div>

                    <form class="space-y-4" data-lead-form>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Nama Lengkap</label>
                            <div class="relative">
                                <i data-lucide="user" class="size-4 absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                                <input required type="text" class="w-full bg-white border border-border-subtle rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" placeholder="Contoh: Ahmad Rizky" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Nomor WhatsApp</label>
                            <div class="relative">
                                <i data-lucide="phone" class="size-4 absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                                <input required type="tel" class="w-full bg-white border border-border-subtle rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" placeholder="0812xxxxxx" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pesan Tambahan</label>
                            <textarea class="w-full bg-white border border-border-subtle rounded-xl py-3 px-4 focus:ring-2 focus:ring-accent outline-none font-medium min-h-[100px]" placeholder="Ingin tanya jadwal survey lokasi..."></textarea>
                        </div>

                        <button type="submit" class="w-full btn-primary py-4 flex items-center justify-center gap-2">
                            Kirim Ketertarikan <i data-lucide="arrow-right" class="size-5"></i>
                        </button>
                    </form>

                    <p class="text-[10px] text-center text-primary/40 mt-6 leading-relaxed uppercase tracking-tighter">
                        Dengan menekan tombol, Anda menyetujui kebijakan privasi kami dan bersedia dihubungi oleh tim marketing.
                    </p>
                </div>

                <div class="flex-grow flex-col items-center justify-center text-center space-y-6 hidden" data-lead-success>
                    <div class="w-20 h-20 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-xl shadow-emerald-custom/20 mx-auto">
                        <i data-lucide="message-circle" class="size-10"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-primary mb-2">Terima Kasih!</h3>
                        <p class="text-primary/60">Data Anda telah kami terima. Marketing kami akan segera menghubungi Anda dalam waktu maksimal 1x24 jam.</p>
                    </div>
                    <button class="btn-gold-outline" data-lead-reset>
                        Kembali ke Beranda
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-landing]');
        if (!root) return;

        // Filter + search
        var filterSelect = root.querySelector('[data-filter-type]');
        var searchBtn = root.querySelector('[data-search-btn]');
        var grid = root.querySelector('[data-property-grid]');
        var searching = root.querySelector('[data-searching]');
        var emptyState = root.querySelector('[data-empty-state]');
        var cards = Array.prototype.slice.call(root.querySelectorAll('[data-property-card]'));

        function applyFilter() {
            var type = filterSelect.value;
            var visible = 0;
            cards.forEach(function (card) {
                var match = type === 'Semua Jenis' || card.getAttribute('data-type') === type;
                card.classList.toggle('hidden', !match);
                if (match) visible++;
            });
            grid.classList.toggle('hidden', visible === 0);
            emptyState.classList.toggle('hidden', visible !== 0);
        }

        filterSelect.addEventListener('change', applyFilter);

        searchBtn.addEventListener('click', function () {
            grid.classList.add('hidden');
            emptyState.classList.add('hidden');
            searching.classList.remove('hidden');
            searching.classList.add('flex');
            setTimeout(function () {
                searching.classList.add('hidden');
                searching.classList.remove('flex');
                applyFilter();
            }, 800);
        });

        // Property modal
        var modal = root.querySelector('[data-property-modal]');
        var modalImage = modal.querySelector('[data-modal-image]');
        var modalType = modal.querySelector('[data-modal-type]');
        var modalName = modal.querySelector('[data-modal-name]');
        var modalDp = modal.querySelector('[data-modal-dp]');
        var leadFormWrapper = modal.querySelector('[data-lead-form-wrapper]');
        var leadSuccess = modal.querySelector('[data-lead-success]');
        var leadForm = modal.querySelector('[data-lead-form]');

        function openModal(property) {
            modalImage.src = property.image;
            modalImage.alt = property.name;
            modalType.textContent = property.type;
            modalName.textContent = property.name;
            modalDp.textContent = property.dp;
            leadFormWrapper.classList.remove('hidden');
            leadSuccess.classList.add('hidden');
            leadSuccess.classList.remove('flex');
            leadForm.reset();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        root.querySelectorAll('[data-open-property]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openModal(JSON.parse(btn.getAttribute('data-open-property')));
            });
        });

        modal.querySelector('[data-modal-close]').addEventListener('click', closeModal);
        modal.querySelector('[data-modal-backdrop]').addEventListener('click', closeModal);

        leadForm.addEventListener('submit', function (e) {
            e.preventDefault();
            leadFormWrapper.classList.add('hidden');
            leadSuccess.classList.remove('hidden');
            leadSuccess.classList.add('flex');
        });

        modal.querySelector('[data-lead-reset]').addEventListener('click', closeModal);
    })();
</script>
@endsection
