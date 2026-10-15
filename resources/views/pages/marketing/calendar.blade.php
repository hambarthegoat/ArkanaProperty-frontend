@extends('layouts.dashboard', ['role' => 'marketing'])

@section('title', 'Jadwal & Kalender - ArkanaProperty')

@php
    use App\Support\Badge;
    use App\Support\Format;

    $daysInMonth = $month->daysInMonth;
    $firstDayOfMonth = (int) $month->format('w');
    $weekDays = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    $prev = $month->copy()->subMonth()->format('Y-m');
    $next = $month->copy()->addMonth()->format('Y-m');
@endphp

@section('main')
<div class="space-y-8" data-calendar>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Jadwal & Kalender</h1>
            <p class="text-primary/60">Kelola janji temu survey dan aktivitas harian Anda. Agenda tampil juga di portal konsumen.</p>
        </div>
        <button type="button" class="btn-primary !py-2 !px-4 text-xs flex items-center gap-2" data-toggle-create>
            <i data-lucide="plus" class="size-4"></i> Tambah Jadwal
        </button>
    </div>

    <form method="POST" action="{{ route('marketing.calendar.store') }}" class="{{ $errors->any() ? '' : 'hidden' }} bg-white rounded-[32px] border border-border-subtle shadow-sm p-6 space-y-4" data-create-form>
        @csrf
        <h3 class="font-black text-primary">Agenda Baru</h3>
        @if ($leads->isEmpty())
            <p class="text-sm text-orange-600 font-semibold">Belum ada lead tervalidasi yang ditugaskan kepada Anda.</p>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <select name="id_lead" required class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none">
                @foreach ($leads as $lead)
                    <option value="{{ $lead['id'] }}" @selected((int) old('id_lead') === $lead['id'])>{{ $lead['nama_calon'] }}</option>
                @endforeach
            </select>
            <input name="judul" value="{{ old('judul') }}" required placeholder="Survey Lokasi: Bpk Ahmad" class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
            <select name="jenis" class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none">
                <option value="survey">Survey</option>
                <option value="follow_up" @selected(old('jenis') === 'follow_up')>Follow Up</option>
                <option value="closing" @selected(old('jenis') === 'closing')>Closing</option>
                <option value="lainnya" @selected(old('jenis') === 'lainnya')>Lainnya</option>
            </select>
            <input type="date" name="tanggal" value="{{ old('tanggal', $selected->toDateString()) }}" required class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
            <input type="time" name="jam" value="{{ old('jam', '09:00') }}" required class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
            <input name="lokasi" value="{{ old('lokasi') }}" placeholder="Blok A-01 / Kantor Pemasaran" class="bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
            <textarea name="deskripsi_agenda" placeholder="Catatan untuk konsumen (opsional)" class="md:col-span-3 bg-surface-soft rounded-xl p-3 text-sm outline-none">{{ old('deskripsi_agenda') }}</textarea>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" class="btn-gold-outline" data-toggle-create>Batal</button>
            <button type="submit" class="btn-primary" @disabled($leads->isEmpty())>Simpan Agenda</button>
        </div>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Calendar View --}}
        <div class="lg:col-span-2 bg-white rounded-[40px] border border-border-subtle shadow-sm overflow-hidden">
            <div class="p-8 border-b border-border-subtle flex items-center justify-between">
                <h3 class="font-black text-primary text-lg">{{ ucfirst($month->locale('id')->isoFormat('MMMM YYYY')) }}</h3>
                <div class="flex gap-2">
                    <a href="{{ route('marketing.calendar', ['month' => $prev]) }}" class="p-2 hover:bg-surface-soft rounded-xl transition-colors" aria-label="Bulan sebelumnya"><i data-lucide="chevron-left" class="size-5"></i></a>
                    <a href="{{ route('marketing.calendar', ['month' => $next]) }}" class="p-2 hover:bg-surface-soft rounded-xl transition-colors" aria-label="Bulan berikutnya"><i data-lucide="chevron-right" class="size-5"></i></a>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-7 gap-4 mb-4">
                    @foreach ($weekDays as $day)
                        <div class="text-center text-[10px] font-black text-primary/30 uppercase tracking-[0.2em]">{{ $day }}</div>
                    @endforeach
                </div>
                <div class="grid grid-cols-7 gap-2">
                    @for ($i = 0; $i < $firstDayOfMonth; $i++)
                        <div class="aspect-square"></div>
                    @endfor
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $date = $month->copy()->day($day);
                            $isSelected = $date->isSameDay($selected);
                            $hasEvent = in_array($date->toDateString(), $eventDays, true);
                        @endphp
                        <a href="{{ route('marketing.calendar', ['month' => $month->format('Y-m'), 'date' => $date->toDateString()]) }}"
                           class="aspect-square rounded-2xl flex flex-col items-center justify-center relative border transition-all {{ $isSelected ? 'bg-primary border-primary text-white shadow-xl shadow-primary/20' : 'bg-surface-soft border-transparent hover:border-accent group' }} {{ $date->isToday() && ! $isSelected ? 'ring-2 ring-accent/40' : '' }}">
                            <span class="text-sm font-black {{ $isSelected ? '' : 'text-primary' }}">{{ $day }}</span>
                            @if ($hasEvent)
                                <div class="absolute bottom-2 w-1.5 h-1.5 bg-accent rounded-full" data-event-dot></div>
                            @endif
                        </a>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Schedule Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-2 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="clock" class="size-4 text-accent"></i> Detail Jadwal
                </h3>
                <p class="text-xs text-primary/40 font-bold mb-6">{{ $selected->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                <div class="space-y-6">
                    @forelse ($dayEvents as $event)
                        <div class="relative pl-6 pb-6 border-l-2 border-surface-soft last:pb-0">
                            <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-accent border-4 border-white"></div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-black text-accent uppercase tracking-widest">{{ Format::time($event['tanggal_kegiatan']) }}</span>
                                <span class="px-2 py-0.5 rounded-[4px] text-[8px] font-black uppercase {{ Badge::agenda($event['jenis']) }}">
                                    {{ $event['jenis_label'] }}
                                </span>
                            </div>
                            <h4 class="font-bold text-primary text-sm mb-1">{{ $event['judul'] }}</h4>
                            <p class="text-[10px] text-primary/40 flex items-center gap-1 font-bold">
                                <i data-lucide="map-pin" class="size-2.5"></i> {{ $event['lokasi'] ?? '-' }} · {{ $event['leads']['nama'] ?? '' }}
                            </p>
                            @if ($event['deskripsi_agenda'])
                                <p class="text-xs text-primary/60 mt-2">{{ $event['deskripsi_agenda'] }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-xs text-primary/40">Tidak ada agenda pada tanggal ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-primary text-white p-8 rounded-[40px] shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <i data-lucide="users" class="size-8 text-accent mb-4"></i>
                    <h4 class="text-xl font-black mb-2 italic">Siap Survey?</h4>
                    <p class="text-white/60 text-sm leading-relaxed mb-6">Jangan lupa konfirmasi ulang konsumen 1 jam sebelum jadwal dimulai.</p>
                    <a href="{{ route('marketing.dashboard') }}" class="block text-center w-full py-3 bg-white text-primary rounded-2xl font-black text-xs hover:bg-accent hover:text-white transition-all">
                        Cek Data Konsumen
                    </a>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-calendar]');
        if (!root) return;
        var form = root.querySelector('[data-create-form]');
        root.querySelectorAll('[data-toggle-create]').forEach(function (btn) {
            btn.addEventListener('click', function () { form.classList.toggle('hidden'); });
        });
    })();
</script>
@endsection
