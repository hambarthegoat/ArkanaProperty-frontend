@extends('layouts.dashboard', ['role' => 'admin'])

@section('title', 'Kelola Perumahan - ArkanaProperty')

@php
    use App\Support\Format;
    use App\Support\PropertyPresenter;
@endphp

@section('main')
<div class="space-y-8" data-housing>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Kelola Perumahan</h1>
            <p class="text-primary/60">Daftar proyek perumahan aktif dan pengembangan mendatang.</p>
        </div>
        <div class="flex gap-2">
            <div class="bg-white border border-border-subtle rounded-xl p-1 flex" data-view-toggle>
                <button data-view="grid" class="p-2 rounded-lg transition-all bg-surface-soft text-primary shadow-sm">
                    <i data-lucide="layout-grid" class="size-[18px]"></i>
                </button>
                <button data-view="list" class="p-2 rounded-lg transition-all text-primary/40 hover:text-primary">
                    <i data-lucide="list" class="size-[18px]"></i>
                </button>
            </div>
            <button type="button" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all" data-toggle-create>
                <i data-lucide="plus" class="size-4"></i> Proyek Baru
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.perumahan.store') }}" enctype="multipart/form-data" class="{{ $errors->any() ? '' : 'hidden' }} bg-white rounded-[32px] border border-border-subtle shadow-sm p-8 space-y-6" data-create-form>
        @csrf
        <h3 class="font-black text-primary text-lg">Proyek Perumahan Baru</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input name="nama_perumahan" value="{{ old('nama_perumahan') }}" required placeholder="Nama perumahan" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" />
            <input name="lokasi" value="{{ old('lokasi') }}" required placeholder="Kec. Mayangan, Probolinggo" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" />
            <select name="status" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none">
                <option value="aktif">Aktif</option>
                <option value="pre_launch" @selected(old('status') === 'pre_launch')>Pre-Launch</option>
            </select>
            <input type="file" name="gambar" accept="image/*" class="bg-surface-soft rounded-xl p-2 text-sm" />
            <textarea name="deskripsi" placeholder="Deskripsi singkat" class="md:col-span-2 bg-surface-soft rounded-xl p-3 outline-none min-h-[80px]">{{ old('deskripsi') }}</textarea>
        </div>
        <div>
            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-3">Tipe rumah pertama (opsional)</p>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <input name="tipe[nama_tipe]" value="{{ old('tipe.nama_tipe') }}" placeholder="Tipe 36/60" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <select name="tipe[jenis_rumah]" class="bg-surface-soft rounded-xl p-3 text-sm outline-none">
                    <option value="subsidi">Subsidi</option>
                    <option value="premium" @selected(old('tipe.jenis_rumah') === 'premium')>Premium</option>
                </select>
                <input name="tipe[harga]" type="number" min="0" value="{{ old('tipe.harga') }}" placeholder="Harga (Rp)" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <input name="tipe[dp]" type="number" min="0" value="{{ old('tipe.dp') }}" placeholder="DP (Rp)" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <input name="tipe[cicilan]" type="number" min="0" value="{{ old('tipe.cicilan') }}" placeholder="Cicilan/bln (Rp)" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <input name="tipe[luas_tanah]" type="number" min="0" value="{{ old('tipe.luas_tanah') }}" placeholder="Luas tanah m²" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <input name="tipe[luas_bangunan]" type="number" min="0" value="{{ old('tipe.luas_bangunan') }}" placeholder="Luas bangunan m²" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <input name="tipe[kamar_tidur]" type="number" min="0" value="{{ old('tipe.kamar_tidur') }}" placeholder="Kamar tidur" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <input name="tipe[kamar_mandi]" type="number" min="0" value="{{ old('tipe.kamar_mandi') }}" placeholder="Kamar mandi" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
                <input name="tipe[spesifikasi]" value="{{ old('tipe.spesifikasi') }}" placeholder="Spesifikasi singkat" class="bg-surface-soft rounded-xl p-3 text-sm outline-none" />
            </div>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" class="btn-gold-outline" data-toggle-create>Batal</button>
            <button type="submit" class="btn-primary">Simpan Proyek</button>
        </div>
    </form>

    {{-- Edit modal --}}
    <div class="fixed inset-0 z-[100] items-center justify-center p-4 hidden" data-edit-modal>
        <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" data-edit-backdrop></div>
        <form method="POST" action="#" enctype="multipart/form-data" class="relative w-full max-w-2xl bg-white rounded-[32px] shadow-2xl p-8 space-y-5" data-edit-form>
            @csrf
            @method('PUT')
            <div class="flex items-center justify-between">
                <h3 class="font-black text-primary text-lg">Edit Perumahan</h3>
                <button type="button" class="p-2 bg-surface-soft rounded-full text-primary" data-edit-close aria-label="Tutup"><i data-lucide="x" class="size-4"></i></button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input name="nama_perumahan" required placeholder="Nama perumahan" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" data-edit-nama />
                <input name="lokasi" required placeholder="Lokasi" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" data-edit-lokasi />
                <select name="status" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none" data-edit-status>
                    <option value="aktif">Aktif</option>
                    <option value="pre_launch">Pre-Launch</option>
                </select>
                <input type="file" name="gambar" accept="image/*" class="bg-surface-soft rounded-xl p-2 text-sm" />
                <textarea name="deskripsi" placeholder="Deskripsi singkat" class="md:col-span-2 bg-surface-soft rounded-xl p-3 outline-none min-h-[80px]" data-edit-deskripsi></textarea>
            </div>
            <p class="text-[10px] text-primary/40">Kosongkan gambar bila tidak ingin menggantinya.</p>
            <div class="flex justify-end gap-3">
                <button type="button" class="btn-gold-outline" data-edit-close>Batal</button>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-project-list>
        @forelse ($projects as $project)
            <div class="bg-white rounded-[32px] overflow-hidden border border-border-subtle shadow-sm flex flex-col h-full hover:-translate-y-1 transition-transform">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $project['gambar_url'] ?? PropertyPresenter::FALLBACK_IMAGE }}" class="w-full h-full object-cover" alt="{{ $project['nama_perumahan'] }}" />
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest text-white {{ $project['status'] === 'aktif' ? 'bg-emerald-custom' : 'bg-accent' }}">
                            {{ $project['status_label'] }}
                        </span>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 text-primary/40 font-bold text-[9px] uppercase tracking-widest mb-2">
                        <i data-lucide="map-pin" class="size-3 text-accent"></i> {{ $project['lokasi'] }}
                    </div>
                    <h3 class="text-lg font-black text-primary mb-2 leading-tight">{{ $project['nama_perumahan'] }}</h3>
                    <p class="text-xs text-primary/40 font-bold uppercase tracking-tighter mb-6">
                        {{ collect($project['tipe_rumah'])->pluck('jenis_rumah_label')->unique()->implode(' & ') ?: 'Belum ada tipe' }}
                        · {{ count($project['tipe_rumah']) }} tipe
                        @if ($project['harga_mulai'])
                            · mulai Rp {{ Format::short($project['harga_mulai']) }}
                        @endif
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="text-center p-3 bg-surface-soft rounded-2xl">
                            <p class="text-[8px] font-black text-primary/40 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-sm font-black text-primary">{{ $project['unit']['total'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-emerald-50 rounded-2xl">
                            <p class="text-[8px] font-black text-emerald-600/60 uppercase tracking-widest mb-1">Terjual</p>
                            <p class="text-sm font-black text-emerald-600">{{ $project['unit']['terjual'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-orange-50 rounded-2xl">
                            <p class="text-[8px] font-black text-orange-600/60 uppercase tracking-widest mb-1">Sisa</p>
                            <p class="text-sm font-black text-orange-600">{{ $project['unit']['tersedia'] }}</p>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-border-subtle flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-surface-soft flex items-center justify-center">
                                <i data-lucide="trending-up" class="size-3.5 text-accent"></i>
                            </div>
                            <span class="text-[10px] font-bold text-primary/60">
                                {{ $project['unit']['total'] ? round(($project['unit']['terjual'] + $project['unit']['booking']) / $project['unit']['total'] * 100) : 0 }}% terjual/booking
                            </span>
                        </div>
                        <div class="flex items-center gap-1">
                            <button type="button" class="p-2 hover:bg-surface-soft rounded-xl transition-colors" title="Edit perumahan" data-edit-project="{{ json_encode(['id' => $project['id'], 'nama' => $project['nama_perumahan'], 'lokasi' => $project['lokasi'], 'deskripsi' => $project['deskripsi'] ?? '', 'status' => $project['status']]) }}">
                                <i data-lucide="pencil" class="size-[18px] text-primary/40"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.perumahan.destroy', $project['id']) }}" onsubmit="return confirm('Hapus perumahan {{ e($project['nama_perumahan']) }} beserta tipe rumah dan kavlingnya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-red-50 rounded-xl transition-colors" title="Hapus perumahan">
                                    <i data-lucide="trash-2" class="size-[18px] text-red-400"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.kavling', ['perumahan' => $project['id']]) }}" class="p-2 hover:bg-surface-soft rounded-xl transition-colors" title="Lihat kavling">
                                <i data-lucide="arrow-right" class="size-[18px] text-primary/40"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-primary/40">Belum ada perumahan.</p>
        @endforelse
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-housing]');
        if (!root) return;
        var form = root.querySelector('[data-create-form]');
        root.querySelectorAll('[data-toggle-create]').forEach(function (btn) {
            btn.addEventListener('click', function () { form.classList.toggle('hidden'); });
        });

        var modal = root.querySelector('[data-edit-modal]');
        var editForm = root.querySelector('[data-edit-form]');
        var updateBase = @json(url('admin/perumahan'));
        function closeEdit() { modal.classList.add('hidden'); modal.classList.remove('flex'); }
        root.querySelectorAll('[data-edit-project]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var p = JSON.parse(btn.getAttribute('data-edit-project'));
                editForm.action = updateBase + '/' + p.id;
                editForm.reset();
                editForm.querySelector('[data-edit-nama]').value = p.nama;
                editForm.querySelector('[data-edit-lokasi]').value = p.lokasi;
                editForm.querySelector('[data-edit-status]').value = p.status;
                editForm.querySelector('[data-edit-deskripsi]').value = p.deskripsi || '';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });
        root.querySelectorAll('[data-edit-close], [data-edit-backdrop]').forEach(function (el) { el.addEventListener('click', closeEdit); });

        var list = root.querySelector('[data-project-list]');
        var buttons = Array.prototype.slice.call(root.querySelectorAll('[data-view-toggle] button'));
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                buttons.forEach(function (b) {
                    b.classList.remove('bg-surface-soft', 'text-primary', 'shadow-sm');
                    b.classList.add('text-primary/40', 'hover:text-primary');
                });
                btn.classList.add('bg-surface-soft', 'text-primary', 'shadow-sm');
                btn.classList.remove('text-primary/40', 'hover:text-primary');
                var listView = btn.getAttribute('data-view') === 'list';
                list.classList.toggle('lg:grid-cols-3', !listView);
                list.classList.toggle('md:grid-cols-2', !listView);
            });
        });
    })();
</script>
@endsection
