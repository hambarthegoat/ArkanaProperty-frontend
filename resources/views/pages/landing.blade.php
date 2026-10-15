@extends('layouts.main')

@section('title', 'ArkanaProperty - Hunian Impian di Probolinggo')

@php
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
                    <a href="#katalog" class="btn-gold-outline !text-white border-white hover:bg-white hover:text-primary">
                        Konsultasi Gratis
                    </a>
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
        <form method="GET" action="{{ route('home') }}#katalog" class="max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl p-8 lg:p-10 border border-border-subtle" data-filter-form>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-2">
                    <label for="filter-lokasi" class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="map-pin" class="size-3.5 text-accent"></i> Lokasi
                    </label>
                    <select id="filter-lokasi" name="lokasi" class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none">
                        <option value="">Seluruh Probolinggo</option>
                        @foreach ($lokasiOptions as $lokasi)
                            <option value="{{ $lokasi }}" @selected(($filters['lokasi'] ?? '') === $lokasi)>{{ $lokasi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="wallet" class="size-3.5 text-accent"></i> Kisaran Budget (Rp)
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="min_budget" min="0" step="1000000" value="{{ $filters['min_budget'] ?? '' }}" placeholder="Min" aria-label="Budget minimum" class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold text-sm outline-none" />
                        <span class="text-primary/20">-</span>
                        <input type="number" name="max_budget" min="0" step="1000000" value="{{ $filters['max_budget'] ?? '' }}" placeholder="Max" aria-label="Budget maksimum" class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold text-sm outline-none" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="filter-cicilan" class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="clock" class="size-3.5 text-accent"></i> Cicilan / Bulan
                    </label>
                    <select id="filter-cicilan" name="max_cicilan" class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none">
                        <option value="">Semua Cicilan</option>
                        @foreach ($cicilanOptions as $value => $label)
                            <option value="{{ $value }}" @selected((string) ($filters['max_cicilan'] ?? '') === (string) $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="filter-jenis" class="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="home" class="size-3.5 text-accent"></i> Jenis Rumah
                    </label>
                    <div class="flex gap-2">
                        <select id="filter-jenis" name="jenis_rumah" class="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisOptions as $jenis)
                                <option value="{{ $jenis['value'] }}" @selected(($filters['jenis_rumah'] ?? '') === $jenis['value'])>{{ $jenis['label'] }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-primary text-white p-3 rounded-xl hover:bg-accent transition-colors shrink-0" aria-label="Cari properti">
                            <i data-lucide="search" class="size-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            @if (array_filter($filters))
                <div class="mt-6 text-right">
                    <a href="{{ route('home') }}#katalog" class="text-xs font-bold text-primary/50 hover:text-accent uppercase tracking-widest">Reset Filter</a>
                </div>
            @endif
        </form>
    </section>

    {{-- Property List --}}
    <section id="katalog" class="max-w-7xl mx-auto px-4 mt-24">
        <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-6">
            <div class="max-w-xl">
                <span class="text-accent text-xs font-black uppercase tracking-[0.3em] mb-4 inline-block">Katalog Properti</span>
                <h2 class="text-4xl md:text-5xl font-black text-primary leading-tight">Temukan Unit Pilihan Untuk Keluarga Anda.</h2>
            </div>
            <p class="text-primary/50 font-semibold mb-2">{{ count($properties) }} tipe rumah ditemukan</p>
        </div>

        @if ($catalogError)
            <div class="mb-8 p-4 rounded-2xl bg-orange-50 border border-orange-100 text-orange-700 text-sm font-semibold" role="alert">
                Katalog belum bisa dimuat: {{ $catalogError }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ count($properties) ? '' : 'hidden' }}" data-property-grid>
            @foreach ($properties as $property)
                <div class="bg-white rounded-[40px] overflow-hidden border border-border-subtle shadow-sm group hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500 flex flex-col h-full" data-property-card>
                    <div class="relative h-72 overflow-hidden shrink-0">
                        <img src="{{ $property['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $property['name'] }}" />
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-white {{ $property['jenis'] === 'subsidi' ? 'bg-blue-600' : 'bg-accent' }}">
                                {{ $property['type'] }}
                            </span>
                            @if ($property['pre_launch'])
                                <span class="ml-2 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-white text-primary">Pre-Launch</span>
                            @endif
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
                            <button type="button" class="flex-grow btn-primary !py-4 text-xs" data-open-property='@json($property)'>
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

        <div class="py-20 text-center bg-white rounded-[40px] border border-border-subtle {{ count($properties) || $catalogError ? 'hidden' : '' }}" data-empty-state>
            <h3 class="text-xl font-black text-primary mb-2">Properti Tidak Ditemukan</h3>
            <p class="text-primary/60">Coba ubah kriteria pencarian atau pilih jenis rumah yang berbeda.</p>
        </div>

        @if (array_filter($filters))
            <div class="mt-16 text-center">
                <a href="{{ route('home') }}#katalog" class="btn-gold-outline inline-flex items-center gap-3">
                    Lihat Semua Unit Properti <i data-lucide="arrow-right" class="size-[18px]"></i>
                </a>
            </div>
        @endif
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
    <div class="fixed inset-0 z-[100] items-center justify-center p-4 hidden" data-property-modal
         data-reopen='@json(old('id_tipe') ? collect($properties)->firstWhere('id', (int) old('id_tipe')) : null)'
         data-submitted='@json($submittedProperty)'>
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
                            <p class="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">Harga</p>
                            <p class="text-xl font-black text-primary">Rp <span data-modal-price></span></p>
                        </div>
                        <div class="p-6 bg-surface-soft rounded-2xl">
                            <p class="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">Uang Muka (DP)</p>
                            <p class="text-xl font-black text-accent">Rp <span data-modal-dp></span></p>
                        </div>
                    </div>

                    <h4 class="font-black text-primary mb-4">Spesifikasi Bangunan</h4>
                    <p class="text-primary/70 mb-6" data-modal-specs></p>
                    <a href="#" class="inline-flex items-center gap-2 text-accent font-bold text-sm hover:underline mb-10" data-modal-detail-link>
                        Lihat detail & ketersediaan unit <i data-lucide="arrow-right" class="size-4"></i>
                    </a>
                </div>
            </div>

            <div class="lg:w-2/5 bg-surface-soft p-10 flex flex-col border-l border-border-subtle">
                <div data-lead-form-wrapper>
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-primary mb-2">Tertarik dengan Unit Ini?</h3>
                        <p class="text-primary/60 text-sm">Isi data di bawah ini, Marketing kami akan segera menghubungi Anda melalui WhatsApp.</p>
                    </div>

                    <form method="POST" action="{{ route('leads.store') }}" enctype="multipart/form-data" class="space-y-4" data-lead-form>
                        @csrf
                        <input type="hidden" name="id_tipe" value="{{ old('id_tipe') }}" data-lead-tipe />
                        @if ($errors->any())
                            <div class="p-3 rounded-xl bg-red-50 border border-red-100 text-red-600 text-xs font-semibold" role="alert">
                                @foreach ($errors->all() as $message)
                                    <p>{{ $message }}</p>
                                @endforeach
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="p-3 rounded-xl bg-red-50 border border-red-100 text-red-600 text-xs font-semibold" role="alert">{{ session('error') }}</div>
                        @endif

                        <div class="space-y-1">
                            <label for="lead-nama" class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Nama Lengkap</label>
                            <div class="relative">
                                <i data-lucide="user" class="size-4 absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                                <input id="lead-nama" name="nama_calon" value="{{ old('nama_calon') }}" required type="text" class="w-full bg-white border border-border-subtle rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" placeholder="Contoh: Ahmad Rizky" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="lead-telp" class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Nomor WhatsApp</label>
                            <div class="relative">
                                <i data-lucide="phone" class="size-4 absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                                <input id="lead-telp" name="no_telp" value="{{ old('no_telp') }}" required type="tel" class="w-full bg-white border border-border-subtle rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" placeholder="0812xxxxxx" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="lead-pesan" class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pesan Tambahan</label>
                            <textarea id="lead-pesan" name="pesan" class="w-full bg-white border border-border-subtle rounded-xl py-3 px-4 focus:ring-2 focus:ring-accent outline-none font-medium min-h-[80px]" placeholder="Ingin tanya jadwal survey lokasi...">{{ old('pesan') }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label for="lead-ktp" class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Foto KTP (opsional)</label>
                            <input id="lead-ktp" name="file_ktp" type="file" accept=".jpg,.jpeg,.png,.pdf" class="w-full bg-white border border-border-subtle rounded-xl py-2 px-4 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-surface-soft file:px-3 file:py-1 file:font-bold file:text-primary" />
                            <p class="text-[10px] text-primary/40 px-2">JPG/PNG/PDF maks 5MB. Mempercepat verifikasi oleh tim kami.</p>
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
                    <button type="button" class="btn-gold-outline" data-lead-reset>
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

        var modal = root.querySelector('[data-property-modal]');
        var leadFormWrapper = modal.querySelector('[data-lead-form-wrapper]');
        var leadSuccess = modal.querySelector('[data-lead-success]');
        var leadForm = modal.querySelector('[data-lead-form]');

        function fill(property) {
            modal.querySelector('[data-modal-image]').src = property.image;
            modal.querySelector('[data-modal-image]').alt = property.name;
            modal.querySelector('[data-modal-type]').textContent = property.type;
            modal.querySelector('[data-modal-name]').textContent = property.name;
            modal.querySelector('[data-modal-dp]').textContent = property.dp;
            modal.querySelector('[data-modal-price]').textContent = property.price;
            modal.querySelector('[data-modal-specs]').textContent = property.specs || '-';
            modal.querySelector('[data-modal-detail-link]').href = '{{ url('property') }}/' + property.id;
            modal.querySelector('[data-lead-tipe]').value = property.id;
        }

        function show(success) {
            leadFormWrapper.classList.toggle('hidden', success);
            leadSuccess.classList.toggle('hidden', !success);
            leadSuccess.classList.toggle('flex', success);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openModal(property) {
            leadForm.reset();
            fill(property);
            show(false);
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
        modal.querySelector('[data-lead-reset]').addEventListener('click', closeModal);

        // Re-open after a redirect: with errors (keep old input) or on success.
        var reopen = JSON.parse(modal.getAttribute('data-reopen') || 'null');
        var submitted = JSON.parse(modal.getAttribute('data-submitted') || 'null');
        if (reopen) { fill(reopen); show(false); }
        else if (submitted) { fill(submitted); show(true); }
    })();
</script>
@endsection
