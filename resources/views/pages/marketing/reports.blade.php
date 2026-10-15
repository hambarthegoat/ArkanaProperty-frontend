@extends('layouts.dashboard', ['role' => 'marketing'])

@section('title', 'Laporan Harian - ArkanaProperty')

@php
    use App\Support\Format;
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
                <form method="POST" action="{{ route('marketing.reports.store') }}" class="space-y-6 {{ session('success') ? 'hidden' : '' }}" data-report-form>
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pilih Konsumen</label>
                            <select name="id_lead" class="w-full bg-surface-soft border-none rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-accent">
                                @foreach ($leads as $lead)
                                    <option value="{{ $lead['id'] }}" @selected((int) old('id_lead') === $lead['id'])>{{ $lead['nama_calon'] }}{{ $lead['kavling'] ? ' ('.$lead['kavling']['nomor_kavling'].')' : '' }}</option>
                                @endforeach
                                <option value="">Lead Baru / Walk-in</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Jenis Aktivitas</label>
                            <select name="jenis_aktivitas" class="w-full bg-surface-soft border-none rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-accent">
                                @foreach ($activities as $value => $label)
                                    <option value="{{ $value }}" @selected(old('jenis_aktivitas') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Tanggal</label>
                            <input type="date" name="tanggal_report" value="{{ old('tanggal_report', now()->toDateString()) }}" max="{{ now()->toDateString() }}" class="w-full bg-surface-soft border-none rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-accent" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Detail Laporan</label>
                        <textarea name="deskripsi_progres" required placeholder="Ceritakan detail pembicaraan atau hasil survey..." class="w-full bg-surface-soft border-none rounded-2xl p-6 text-sm font-medium outline-none focus:ring-2 focus:ring-accent min-h-[200px]">{{ old('deskripsi_progres') }}</textarea>
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
                <div class="py-20 text-center space-y-6 {{ session('success') ? '' : 'hidden' }}" data-report-success>
                    <div class="w-20 h-20 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-xl mx-auto">
                        <i data-lucide="check-circle-2" class="size-10"></i>
                    </div>
                    <h3 class="text-2xl font-black">Laporan Terkirim!</h3>
                    <p class="text-primary/60">Terima kasih atas dedikasi Anda hari ini. Terus semangat mengejar closing!</p>
                    <button type="button" class="btn-gold-outline" data-report-reset>Buat Laporan Lagi</button>
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
                    @forelse (array_slice($history, 0, 8) as $item)
                        <div class="p-4 bg-surface-soft rounded-2xl border border-transparent hover:border-border-subtle hover:bg-white transition-all">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black text-primary/40 uppercase tracking-widest">{{ Format::date($item['tanggal_report'], 'D MMM YYYY') }}</span>
                                <i data-lucide="check-circle-2" class="size-3.5 text-emerald-custom"></i>
                            </div>
                            <h4 class="font-bold text-primary text-xs">{{ $item['jenis_aktivitas_label'] ?? 'Aktivitas' }}{{ $item['leads'] ? ': '.$item['leads']['nama_calon'] : '' }}</h4>
                            <p class="text-[10px] text-primary/40 line-clamp-2 mt-1">{{ $item['deskripsi_progres'] }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-primary/40">Belum ada laporan.</p>
                    @endforelse
                    <p class="text-center text-[10px] font-black text-primary/30 uppercase tracking-widest pt-2">Total {{ count($history) }} laporan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-report-page]');
        if (!root) return;
        root.querySelector('[data-report-reset]').addEventListener('click', function () {
            root.querySelector('[data-report-success]').classList.add('hidden');
            root.querySelector('[data-report-form]').classList.remove('hidden');
        });
    })();
</script>
@endsection
