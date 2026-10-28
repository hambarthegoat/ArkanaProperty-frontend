@extends('layouts.dashboard', ['role' => 'admin'])

@section('title', 'Manajemen Leads - ArkanaProperty')

@php
    use App\Support\Badge;
    use App\Support\Format;

    $statTiles = [
        ['label' => 'Total Prospek', 'value' => $stats['total'], 'icon' => 'user-plus', 'color' => 'text-blue-600'],
        ['label' => 'Menunggu Validasi', 'value' => $stats['pending'], 'icon' => 'clock', 'color' => 'text-orange-600'],
        ['label' => 'Tervalidasi', 'value' => $stats['validated'], 'icon' => 'check-circle-2', 'color' => 'text-emerald-custom'],
        ['label' => 'Ditolak', 'value' => $stats['rejected'], 'icon' => 'x-circle', 'color' => 'text-red-500'],
    ];

    $statuses = ['' => 'Semua', 'pending' => 'Menunggu', 'validated' => 'Tervalidasi', 'rejected' => 'Ditolak'];
    $currentStatus = $filters['status'] ?? '';
@endphp

@section('main')
<div class="space-y-6" data-leads>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Manajemen Leads</h1>
            <p class="text-primary/60">Validasi KTP, tugaskan marketing, dan pantau seluruh prospek konsumen.</p>
        </div>
        <a href="{{ config('services.arkana_api.admin_panel_url') }}/leads" class="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
            <i data-lucide="external-link" class="size-4"></i> Buka di Admin Panel
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($statTiles as $stat)
            <div class="bg-white p-5 rounded-2xl border border-border-subtle shadow-sm flex items-center gap-4">
                <div class="p-3 rounded-xl bg-surface-soft {{ $stat['color'] }}">
                    <i data-lucide="{{ $stat['icon'] }}" class="size-5"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">{{ $stat['label'] }}</p>
                    <p class="text-xl font-black text-primary">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[32px] border border-border-subtle shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border-subtle flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" action="{{ route('admin.leads') }}" class="relative w-full md:w-96">
                <input type="hidden" name="status" value="{{ $currentStatus }}" />
                <i data-lucide="search" class="size-[18px] absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama atau nomor telepon..." class="w-full bg-surface-soft border-none rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" />
            </form>
            <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                @foreach ($statuses as $value => $label)
                    <a href="{{ route('admin.leads', array_filter(['status' => $value, 'search' => $filters['search'] ?? null])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $currentStatus === $value ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-surface-soft text-primary/60 hover:bg-border-subtle' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-soft border-b border-border-subtle">
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Konsumen</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Minat Unit</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Marketing</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle">
                    @forelse ($leads as $lead)
                        <tr class="hover:bg-surface-soft/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-surface-soft border border-border-subtle flex items-center justify-center font-black text-primary text-xs shrink-0">
                                        {{ Format::initials($lead['nama_calon']) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-primary group-hover:text-accent transition-colors">{{ $lead['nama_calon'] }}</div>
                                        <div class="text-[10px] text-primary/40">{{ $lead['no_telp'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-primary/70">{{ $lead['tipe_rumah']['nama_tipe'] ?? '-' }} · {{ $lead['perumahan']['nama_perumahan'] ?? '-' }}</div>
                                <div class="text-[9px] text-primary/40 uppercase tracking-tighter">Terdaftar: {{ Format::date($lead['created_at']) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium text-primary/60">{{ $lead['marketing']['nama'] ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter {{ Badge::leadStatus($lead['status_keseriusan']) }}">
                                    {{ $lead['status_label'] }}
                                </span>
                                @unless ($lead['has_ktp'])
                                    <div class="text-[9px] text-orange-500 font-bold mt-1">KTP belum ada</div>
                                @endunless
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-1">
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $lead['no_telp']) }}" target="_blank" rel="noopener" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="WhatsApp">
                                        <i data-lucide="message-circle" class="size-[18px]"></i>
                                    </a>
                                    <button type="button" class="p-2 text-primary/40 hover:bg-surface-soft rounded-lg transition-colors" title="Kelola" data-toggle-row="{{ $lead['id'] }}">
                                        <i data-lucide="more-horizontal" class="size-[18px]"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hidden bg-surface-soft/40" data-manage-row="{{ $lead['id'] }}">
                            <td colspan="5" class="px-6 py-6">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Pesan</p>
                                        <p class="text-sm text-primary/70">{{ $lead['pesan'] ?: '-' }}</p>
                                        @if ($lead['akun_leads'])
                                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest pt-2">Akun Portal</p>
                                            <p class="text-sm font-bold text-primary">{{ $lead['akun_leads']['username'] }}</p>
                                        @endif
                                    </div>

                                    <div class="space-y-3">
                                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">KTP</p>
                                        @if ($lead['has_ktp'])
                                            <a href="{{ route('admin.leads.ktp', $lead['id']) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-accent hover:underline">
                                                <i data-lucide="file-image" class="size-4"></i> Lihat KTP
                                            </a>
                                        @else
                                            <p class="text-sm text-primary/50">Belum diunggah. KTP diunggah oleh marketing.</p>
                                        @endif
                                    </div>

                                    <div class="space-y-3">
                                        @if ($lead['status_keseriusan'] !== 'validated')
                                            @if ($lead['status_keseriusan'] === 'pending')
                                                <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Tugaskan Marketing</p>
                                                <form method="POST" action="{{ route('admin.leads.assign', $lead['id']) }}" class="flex gap-2">
                                                    @csrf
                                                    <select name="id_marketing" required class="w-full bg-white border border-border-subtle rounded-lg px-3 py-2 text-xs font-bold">
                                                        <option value="">Pilih marketing</option>
                                                        @foreach ($marketing as $m)
                                                            <option value="{{ $m['id'] }}" @selected(($lead['id_marketing'] ?? null) === $m['id'])>{{ $m['nama'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="px-3 py-2 bg-white border border-border-subtle rounded-lg text-xs font-bold hover:border-accent shrink-0">{{ ($lead['id_marketing'] ?? null) ? 'Ubah' : 'Tugaskan' }}</button>
                                                </form>
                                            @endif
                                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest pt-1">Validasi</p>
                                            <form method="POST" action="{{ route('admin.leads.validate', $lead['id']) }}" class="flex gap-2 items-center">
                                                @csrf
                                                <button type="submit" class="px-3 py-2 bg-emerald-custom text-white rounded-lg text-xs font-bold shrink-0" @disabled(! $lead['has_ktp'] || ! ($lead['id_marketing'] ?? null))>Validasi</button>
                                                @if (! ($lead['id_marketing'] ?? null))
                                                    <span class="text-[10px] text-orange-500 font-bold">Tugaskan marketing terlebih dahulu</span>
                                                @elseif (! $lead['has_ktp'])
                                                    <span class="text-[10px] text-orange-500 font-bold">Menunggu marketing mengunggah KTP</span>
                                                @endif
                                            </form>
                                            @if ($lead['status_keseriusan'] === 'pending')
                                                <form method="POST" action="{{ route('admin.leads.reject', $lead['id']) }}" onsubmit="return confirm('Tolak lead ini?')">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-bold text-red-500 hover:underline">Tolak lead</button>
                                                </form>
                                            @endif
                                        @else
                                            <p class="text-sm text-emerald-600 font-bold">Sudah divalidasi · {{ $lead['prioritas_label'] ?? 'Prioritas belum diatur' }}</p>
                                            @if ($lead['catatan'])
                                                <p class="text-xs text-primary/60">Catatan marketing: {{ $lead['catatan'] }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-primary/40">Tidak ada lead yang cocok dengan filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-border-subtle bg-surface-soft/30">
            <p class="text-xs text-primary/40 font-medium">Menampilkan {{ count($leads) }} dari {{ $stats['total'] }} leads</p>
        </div>
    </div>
</div>

<script>
    (function () {
        document.querySelectorAll('[data-toggle-row]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var row = document.querySelector('[data-manage-row="' + btn.getAttribute('data-toggle-row') + '"]');
                row.classList.toggle('hidden');
            });
        });
    })();
</script>
@endsection
