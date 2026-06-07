@extends('layouts.dashboard')

@php
    $role = 'marketing';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $current = \Carbon\Carbon::create(2026, 6, 7);
    $daysInMonth = $current->copy()->endOfMonth()->day;
    $firstDayOfMonth = (int) $current->copy()->startOfMonth()->format('w'); // 0 (Sun) - 6 (Sat)
    $monthName = ucfirst($current->locale('id')->isoFormat('MMMM'));
    $year = $current->year;

    $events = [
        ['id' => 1, 'title' => 'Survey Lokasi: Bpk Ahmad', 'time' => '09:00', 'date' => '2026-06-07', 'location' => 'Blok A-12', 'type' => 'Survey'],
        ['id' => 2, 'title' => 'Follow Up: Ibu Siti', 'time' => '13:30', 'date' => '2026-06-07', 'location' => 'Telepon/WA', 'type' => 'Follow Up'],
        ['id' => 3, 'title' => 'Tanda Tangan PPJB', 'time' => '15:00', 'date' => '2026-06-07', 'location' => 'Kantor Pusat', 'type' => 'Closing'],
        ['id' => 4, 'title' => 'Survey Lokasi: Bpk Budi', 'time' => '10:00', 'date' => '2026-06-08', 'location' => 'Blok B-05', 'type' => 'Survey'],
        ['id' => 5, 'title' => 'Meeting Progress Project', 'time' => '14:00', 'date' => '2026-06-09', 'location' => 'Meeting Room', 'type' => 'Internal'],
    ];

    $todaysEvents = array_values(array_filter($events, fn ($e) => $e['date'] === '2026-06-07'));

    $weekDays = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
@endphp

@section('main')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Jadwal & Kalender</h1>
            <p class="text-primary/60">Kelola janji temu survey dan aktivitas harian Anda.</p>
        </div>
        <button class="btn-primary !py-2 !px-4 text-xs flex items-center gap-2">
            <i data-lucide="plus" class="size-4"></i> Tambah Jadwal
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Calendar View --}}
        <div class="lg:col-span-2 bg-white rounded-[40px] border border-border-subtle shadow-sm overflow-hidden">
            <div class="p-8 border-b border-border-subtle flex items-center justify-between">
                <h3 class="font-black text-primary text-lg">{{ $monthName }} {{ $year }}</h3>
                <div class="flex gap-2">
                    <button class="p-2 hover:bg-surface-soft rounded-xl transition-colors"><i data-lucide="chevron-left" class="size-5"></i></button>
                    <button class="p-2 hover:bg-surface-soft rounded-xl transition-colors"><i data-lucide="chevron-right" class="size-5"></i></button>
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
                        @php($isToday = $day === 7)
                        <div class="aspect-square rounded-2xl flex flex-col items-center justify-center relative border transition-all cursor-pointer {{ $isToday ? 'bg-primary border-primary text-white shadow-xl shadow-primary/20' : 'bg-surface-soft border-transparent hover:border-accent group' }}">
                            <span class="text-sm font-black {{ $isToday ? '' : 'text-primary' }}">{{ $day }}</span>
                            @if ($day === 7)
                                <div class="absolute bottom-2 w-1.5 h-1.5 bg-accent rounded-full"></div>
                            @endif
                            @if ($day === 8)
                                <div class="absolute bottom-2 w-1.5 h-1.5 bg-primary/20 rounded-full group-hover:bg-accent transition-colors"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Schedule Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="clock" class="size-4 text-accent"></i> Detail Jadwal
                </h3>
                <div class="space-y-6">
                    @foreach ($todaysEvents as $event)
                        <div class="relative pl-6 pb-6 border-l-2 border-surface-soft last:pb-0">
                            <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-accent border-4 border-white"></div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-black text-accent uppercase tracking-widest">{{ $event['time'] }}</span>
                                <span class="px-2 py-0.5 rounded-[4px] text-[8px] font-black uppercase {{ $event['type'] === 'Closing' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600' }}">
                                    {{ $event['type'] }}
                                </span>
                            </div>
                            <h4 class="font-bold text-primary text-sm mb-1">{{ $event['title'] }}</h4>
                            <p class="text-[10px] text-primary/40 flex items-center gap-1 font-bold">
                                <i data-lucide="map-pin" class="size-2.5"></i> {{ $event['location'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-primary text-white p-8 rounded-[40px] shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <i data-lucide="users" class="size-8 text-accent mb-4"></i>
                    <h4 class="text-xl font-black mb-2 italic">Siap Survey?</h4>
                    <p class="text-white/60 text-sm leading-relaxed mb-6">Jangan lupa konfirmasi ulang konsumen 1 jam sebelum jadwal dimulai.</p>
                    <button class="w-full py-3 bg-white text-primary rounded-2xl font-black text-xs hover:bg-accent hover:text-white transition-all">
                        Cek Data Konsumen
                    </button>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            </div>
        </div>
    </div>
</div>
@endsection
