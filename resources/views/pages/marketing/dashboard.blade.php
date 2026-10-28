@extends('layouts.dashboard', ['role' => 'marketing'])

@section('title', 'Leads Saya - ArkanaProperty')

@php
    use App\Support\Badge;
    use App\Support\Format;
@endphp

@section('main')
<div class="space-y-8" data-marketing-dashboard>
    {{-- Lead Detail Modal --}}
    <div class="fixed inset-0 z-[100] items-center justify-center p-4 hidden" data-lead-modal>
        <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" data-lead-modal-backdrop></div>
        <div class="relative w-full max-w-2xl bg-white rounded-[40px] overflow-hidden shadow-2xl">
            <div class="p-10">
                <div class="flex justify-between items-start mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-surface-soft rounded-3xl flex items-center justify-center text-primary font-black text-xl" data-lead-modal-initials></div>
                        <div>
                            <h2 class="text-2xl font-black text-primary" data-lead-modal-name></h2>
                            <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest" data-lead-modal-priority></span>
                        </div>
                    </div>
                    <button type="button" class="p-3 bg-surface-soft hover:bg-border-subtle rounded-full text-primary transition-all" data-lead-modal-close>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Status Saat Ini</p>
                            <div class="flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="size-4 text-emerald-custom"></i>
                                <span class="font-bold text-primary" data-lead-modal-status></span>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Unit Diminati</p>
                            <p class="font-bold text-primary" data-lead-modal-property></p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Kontak Person</p>
                            <p class="font-bold text-primary" data-lead-modal-phone></p>
                            <p class="text-xs text-primary/40" data-lead-modal-unit></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Pesan Konsumen</p>
                            <p class="text-sm text-primary/60 italic" data-lead-modal-message></p>
                        </div>
                    </div>
                </div>

                <div class="mb-8 p-5 bg-surface-soft rounded-2xl space-y-3" data-lead-modal-ktp>
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">KTP Calon Pembeli</p>
                        <span class="text-xs font-bold" data-lead-modal-ktp-status></span>
                    </div>
                    <form method="POST" action="#" enctype="multipart/form-data" class="flex gap-2 items-center" data-lead-modal-ktp-form>
                        @csrf
                        <input type="file" name="file_ktp" accept=".jpg,.jpeg,.png,.pdf" required class="text-xs w-full file:mr-2 file:rounded-lg file:border-0 file:bg-white file:px-3 file:py-1 file:font-bold" />
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-xs font-bold shrink-0" data-lead-modal-ktp-button>Unggah</button>
                    </form>
                    <p class="text-[10px] text-primary/40">JPG/PNG/PDF maks 5MB. Setelah KTP ada, admin dapat memvalidasi lead ini.</p>
                </div>

                <form method="POST" action="#" class="space-y-3 pb-8" data-lead-modal-form>
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <select name="prioritas" class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" data-lead-modal-priority-input>
                            <option value="">Prioritas belum diatur</option>
                            <option value="tinggi">Prioritas Tinggi</option>
                            <option value="sedang">Prioritas Sedang</option>
                            <option value="rendah">Prioritas Rendah</option>
                        </select>
                        <textarea name="catatan" rows="2" placeholder="Catatan follow-up..." class="md:col-span-2 bg-surface-soft rounded-xl p-3 text-sm outline-none" data-lead-modal-notes></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-xl text-xs font-bold">Simpan Catatan</button>
                    </div>
                </form>

                <div class="flex gap-4 pt-8 border-t border-border-subtle">
                    <a href="#" class="flex-grow btn-primary flex items-center justify-center gap-2" data-lead-modal-call>
                        <i data-lucide="phone" class="size-[18px]"></i> Hubungi Telepon
                    </a>
                    <a href="#" target="_blank" rel="noopener" class="flex-grow py-4 bg-emerald-500 text-white rounded-2xl font-black flex items-center justify-center gap-2 hover:bg-emerald-600 transition-all" data-lead-modal-wa>
                        <i data-lucide="message-square" class="size-[18px]"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Leads Saya</h1>
            <p class="text-primary/60">Semangat! Anda menangani {{ count($assignedLeads) }} lead, ada {{ count($queuedLeads) }} lead baru menunggu KTP, dan {{ count($schedule) }} jadwal hari ini.</p>
        </div>
        <a href="{{ route('marketing.calendar') }}" class="btn-primary !py-2 !px-4 text-xs flex items-center gap-2">
            <i data-lucide="plus" class="size-4"></i> Buat Agenda
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Assigned Leads Section --}}
        <div class="lg:col-span-2 space-y-6">
            @if (count($queuedLeads))
                <div class="space-y-3" data-lead-queue>
                    <h2 class="text-xs font-black text-primary/50 uppercase tracking-widest">Antrean Lead Baru · unggah KTP untuk mengambil lead</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($queuedLeads as $lead)
                            <div class="bg-white p-6 rounded-3xl border border-dashed border-accent shadow-sm flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase bg-accent/10 text-accent">Antrean Baru</span>
                                        <span class="text-[9px] font-bold text-primary/40 uppercase">{{ $lead['last_update'] }}</span>
                                    </div>
                                    <h3 class="font-bold text-lg text-primary">{{ $lead['name'] }}</h3>
                                    <p class="text-xs text-primary/40 mb-4">{{ $lead['property'] }}</p>
                                </div>
                                <div class="flex gap-2 pt-4 border-t border-border-subtle">
                                    <button type="button" class="flex-grow py-2 bg-primary text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-accent transition-colors" data-open-lead='@json($lead)'>
                                        <i data-lucide="upload" class="size-3.5"></i> Unggah KTP
                                    </button>
                                    <a href="https://wa.me/{{ $lead['wa'] }}" target="_blank" rel="noopener" class="flex-grow py-2 bg-emerald-500 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-emerald-600 transition-colors">
                                        <i data-lucide="message-square" class="size-3.5"></i> WhatsApp
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($assignedLeads as $lead)
                    <div class="bg-white p-6 rounded-3xl border border-border-subtle shadow-sm flex flex-col justify-between hover:scale-[1.02] transition-transform">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ Badge::priority($lead['priority']) }}">
                                    Prioritas {{ $lead['priority_label'] }}
                                </span>
                                <span class="text-[9px] font-bold text-primary/40 uppercase">{{ $lead['status'] }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-primary">{{ $lead['name'] }}</h3>
                            <p class="text-xs text-primary/40 mb-4">{{ $lead['property'] }}</p>
                        </div>
                        <div class="space-y-3 pt-4 border-t border-border-subtle">
                            <div class="flex items-center justify-between text-[10px] font-bold">
                                <span class="text-primary/40 uppercase tracking-widest">Update Terakhir</span>
                                <span class="text-primary/60">{{ $lead['last_update'] }}</span>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" class="flex-grow py-2 bg-surface-soft text-primary rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition-all group" data-open-lead='@json($lead)'>
                                    <i data-lucide="external-link" class="size-3.5 group-hover:scale-110 transition-transform"></i> Detail
                                </button>
                                <a href="https://wa.me/{{ $lead['wa'] }}" target="_blank" rel="noopener" class="flex-grow py-2 bg-emerald-500 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-emerald-600 transition-colors">
                                    <i data-lucide="message-square" class="size-3.5"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 bg-white p-10 rounded-3xl border border-border-subtle text-center text-primary/40">
                        Belum ada lead yang ditugaskan kepada Anda.
                    </div>
                @endforelse
            </div>

            {{-- Daily Report Input --}}
            <div class="bg-white rounded-3xl border border-border-subtle shadow-sm p-8">
                <h3 class="font-black text-primary mb-4 flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="size-5 text-accent"></i> Input Report Harian
                </h3>
                <form method="POST" action="{{ route('marketing.reports.store') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pilih Lead</label>
                            <select name="id_lead" class="w-full bg-surface-soft border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent">
                                @foreach ($assignedLeads as $lead)
                                    <option value="{{ $lead['id'] }}">{{ $lead['name'] }}</option>
                                @endforeach
                                <option value="">Lead Baru / Walk-in</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Jenis Aktivitas</label>
                            <select name="jenis_aktivitas" class="w-full bg-surface-soft border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent">
                                @foreach ($activities as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Keterangan Detail</label>
                        <textarea name="deskripsi_progres" required placeholder="Ceritakan detail aktivitas Anda..." class="w-full bg-surface-soft border-none rounded-xl p-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent min-h-[100px]"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary !px-8 flex items-center gap-2">
                            Kirim Laporan <i data-lucide="send" class="size-[18px]"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar: Calendar/Schedule --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-border-subtle shadow-sm p-6">
                <h3 class="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="calendar" class="size-[18px] text-accent"></i> Jadwal Hari Ini
                </h3>
                <div class="space-y-4">
                    @forelse ($schedule as $item)
                        <div class="flex gap-4 p-4 rounded-2xl hover:bg-surface-soft transition-colors group border border-transparent hover:border-border-subtle">
                            <div class="shrink-0 flex flex-col items-center justify-center w-14 h-14 bg-surface-soft rounded-xl group-hover:bg-accent group-hover:text-white transition-colors">
                                <span class="text-[10px] font-black opacity-50 uppercase leading-none">Pkl</span>
                                <span class="text-sm font-black">{{ Format::time($item['tanggal_kegiatan']) }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-primary text-sm">{{ $item['judul'] }}</h4>
                                <p class="text-[10px] text-primary/40 font-medium uppercase tracking-wider mb-1">{{ $item['lokasi'] ?? '-' }} · {{ $item['leads']['nama'] ?? '' }}</p>
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase {{ Badge::agenda($item['jenis']) }}">
                                    {{ $item['jenis_label'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-primary/40 px-2">Tidak ada jadwal hari ini.</p>
                    @endforelse
                    <div class="pt-4 mt-4 border-t border-border-subtle">
                        <a href="{{ route('marketing.calendar') }}" class="block text-center w-full py-3 text-xs font-black text-accent hover:bg-accent hover:text-white border border-accent rounded-xl transition-all uppercase tracking-widest">
                            Buka Kalender Lengkap
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-primary text-white rounded-3xl p-8 relative overflow-hidden shadow-xl">
                <div class="relative z-10">
                    <i data-lucide="clock" class="size-8 text-accent mb-4"></i>
                    <h4 class="font-black text-xl mb-2 italic">Ingat!</h4>
                    <p class="text-white/60 text-sm leading-relaxed">
                        Laporan harian maksimal dikirimkan pukul 20:00 WIB setiap harinya untuk sinkronisasi data Admin.
                    </p>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-marketing-dashboard]');
        if (!root) return;
        var modal = root.querySelector('[data-lead-modal]');
        var updateBase = @json(url('marketing/leads'));
        var priorityClasses = { tinggi: 'bg-red-100 text-red-600', sedang: 'bg-orange-100 text-orange-600', rendah: 'bg-slate-100 text-slate-500' };

        function q(selector) { return modal.querySelector(selector); }

        function openModal(lead) {
            q('[data-lead-modal-initials]').textContent = lead.initials;
            q('[data-lead-modal-name]').textContent = lead.name;
            q('[data-lead-modal-priority]').textContent = lead.queued ? 'Antrean Baru' : 'Prioritas ' + lead.priority_label;
            q('[data-lead-modal-priority]').className = 'px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest ' + (priorityClasses[lead.priority] || 'bg-slate-100 text-slate-400');
            q('[data-lead-modal-status]').textContent = lead.status;
            q('[data-lead-modal-property]').textContent = lead.property || '-';
            q('[data-lead-modal-phone]').textContent = lead.phone;
            q('[data-lead-modal-unit]').textContent = lead.unit ? 'Unit: ' + lead.unit : 'Belum memilih unit';
            q('[data-lead-modal-message]').textContent = lead.message ? '"' + lead.message + '"' : '-';
            q('[data-lead-modal-notes]').value = lead.notes || '';
            q('[data-lead-modal-priority-input]').value = lead.priority || '';
            q('[data-lead-modal-form]').action = updateBase + '/' + lead.id;
            q('[data-lead-modal-form]').classList.toggle('hidden', !!lead.queued);
            q('[data-lead-modal-ktp-form]').action = updateBase + '/' + lead.id + '/ktp';
            q('[data-lead-modal-ktp-form]').reset();
            q('[data-lead-modal-ktp-button]').textContent = lead.has_ktp ? 'Ganti' : 'Unggah';
            q('[data-lead-modal-ktp-status]').textContent = lead.has_ktp ? 'Sudah diunggah' : 'Belum diunggah';
            q('[data-lead-modal-ktp-status]').className = 'text-xs font-bold ' + (lead.has_ktp ? 'text-emerald-600' : 'text-orange-500');
            q('[data-lead-modal-call]').href = 'tel:' + lead.phone;
            q('[data-lead-modal-wa]').href = 'https://wa.me/' + lead.wa;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        root.querySelectorAll('[data-open-lead]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openModal(JSON.parse(btn.getAttribute('data-open-lead')));
            });
        });
        q('[data-lead-modal-close]').addEventListener('click', closeModal);
        q('[data-lead-modal-backdrop]').addEventListener('click', closeModal);
    })();
</script>
@endsection
