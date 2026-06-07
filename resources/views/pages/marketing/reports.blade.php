@extends('layouts.dashboard')

@php
    $role = 'marketing';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $consumers = ['Ahmad Rizky (Blok A-12)', 'Siti Aminah (Cluster Premium)', 'Budi Santoso (Tipe 36/60)', 'Lead Baru / Walk-in'];
    $activities = ['Survey Lokasi', 'Follow Up WhatsApp', 'Telepon Penawaran', 'Booking Unit', 'Tanda Tangan PPJB'];

    $history = [
        ['date' => '7 Juni', 'title' => 'Survey Lokasi: Ahmad R.', 'excerpt' => 'Klien tertarik dengan hook...'],
        ['date' => '7 Juni', 'title' => 'Survey Lokasi: Ahmad R.', 'excerpt' => 'Klien tertarik dengan hook...'],
        ['date' => '7 Juni', 'title' => 'Survey Lokasi: Ahmad R.', 'excerpt' => 'Klien tertarik dengan hook...'],
    ];
@endphp

@section('main')
<div class="max-w-4xl mx-auto space-y-8" data-report-page>
    <div>
        <h1 class="text-2xl font-black text-primary">Input Laporan Harian</h1>
        <p class="text-primary/60">Laporkan aktivitas follow-up atau survey Anda hari ini.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
                {{-- Form State --}}
                <form class="space-y-6" data-report-form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pilih Konsumen</label>
                            <select class="w-full bg-surface-soft border-none rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-accent">
                                @foreach ($consumers as $consumer)
                                    <option>{{ $consumer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Jenis Aktivitas</label>
                            <select class="w-full bg-surface-soft border-none rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-accent">
                                @foreach ($activities as $activity)
                                    <option>{{ $activity }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Detail Laporan</label>
                        <textarea placeholder="Ceritakan detail pembicaraan atau hasil survey..." class="w-full bg-surface-soft border-none rounded-2xl p-6 text-sm font-medium outline-none focus:ring-2 focus:ring-accent min-h-[200px]"></textarea>
                    </div>

                    <div class="p-4 bg-accent/5 border border-accent/20 rounded-2xl flex gap-4 items-start">
                        <i data-lucide="alert-circle" class="text-accent shrink-0 size-5"></i>
                        <p class="text-xs text-primary/60 leading-relaxed font-medium">
                            Pastikan data yang Anda masukkan sudah benar. Laporan ini akan langsung tampil di dashboard Administrator untuk divalidasi.
                        </p>
                    </div>

                    <button type="submit" class="w-full btn-primary py-5 flex items-center justify-center gap-3 text-lg" data-report-submit>
                        Kirim Laporan <i data-lucide="send" class="size-5"></i>
                    </button>
                </form>

                {{-- Success State --}}
                <div class="py-20 text-center space-y-6 hidden" data-report-success>
                    <div class="w-20 h-20 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-xl mx-auto">
                        <i data-lucide="check-circle-2" class="size-10"></i>
                    </div>
                    <h3 class="text-2xl font-black">Laporan Terkirim!</h3>
                    <p class="text-primary/60">Terima kasih atas dedikasi Anda hari ini. Terus semangat mengejar closing!</p>
                    <button class="btn-gold-outline" data-report-reset>Buat Laporan Lagi</button>
                </div>
            </div>
        </div>

        {{-- History Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-6 flex items-center gap-3 text-sm uppercase tracking-widest">
                    <i data-lucide="history" class="size-[18px] text-accent"></i> History Terbaru
                </h3>
                <div class="space-y-4">
                    @foreach ($history as $item)
                        <div class="p-4 bg-surface-soft rounded-2xl group cursor-pointer hover:bg-white border border-transparent hover:border-border-subtle transition-all">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black text-primary/40 uppercase tracking-widest">{{ $item['date'] }}</span>
                                <i data-lucide="check-circle-2" class="size-3.5 text-emerald-custom"></i>
                            </div>
                            <h4 class="font-bold text-primary text-xs">{{ $item['title'] }}</h4>
                            <p class="text-[10px] text-primary/40 line-clamp-1 mt-1">{{ $item['excerpt'] }}</p>
                        </div>
                    @endforeach
                    <button class="w-full text-center text-[10px] font-black text-accent uppercase tracking-widest pt-2 hover:underline">
                        Lihat Semua History
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-report-page]');
        if (!root) return;
        var form = root.querySelector('[data-report-form]');
        var success = root.querySelector('[data-report-success]');
        var resetBtn = root.querySelector('[data-report-reset]');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            form.classList.add('hidden');
            success.classList.remove('hidden');
        });

        resetBtn.addEventListener('click', function () {
            success.classList.add('hidden');
            form.classList.remove('hidden');
        });
    })();
</script>
@endsection
