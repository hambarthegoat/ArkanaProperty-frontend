@extends('layouts.dashboard')

@php
    $role = 'marketing';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $assignedLeads = [
        ['id' => 1, 'name' => 'Ahmad Rizky', 'phone' => '081234567890', 'property' => 'Tipe 36/60', 'lastContact' => '2 jam lalu', 'priority' => 'High', 'status' => 'Survey Lokasi', 'email' => 'ahmad.rizky@email.com', 'notes' => 'Tertarik dengan unit hook, rencana survey minggu ini.'],
        ['id' => 2, 'name' => 'Siti Aminah', 'phone' => '089876543210', 'property' => 'Premium Cluster', 'lastContact' => '1 hari lalu', 'priority' => 'Medium', 'status' => 'Follow Up', 'email' => 'siti.a@email.com', 'notes' => 'Menunggu persetujuan suami untuk booking fee.'],
        ['id' => 3, 'name' => 'Budi Santoso', 'phone' => '081122334455', 'property' => 'Tipe 36/60', 'lastContact' => '3 hari lalu', 'priority' => 'Low', 'status' => 'Pikir-pikir', 'email' => 'budi.s@email.com', 'notes' => 'Masih membandingkan dengan perumahan sebelah.'],
    ];

    $schedule = [
        ['time' => '09:00', 'title' => 'Survey Lokasi: Bpk Ahmad', 'location' => 'Blok A-12', 'type' => 'Survey'],
        ['time' => '13:30', 'title' => 'Follow Up: Ibu Siti', 'location' => 'Telepon/WA', 'type' => 'Follow Up'],
        ['time' => '15:00', 'title' => 'Tanda Tangan PPJB', 'location' => 'Kantor Pusat', 'type' => 'Closing'],
    ];

    $priorityClasses = [
        'High' => 'bg-red-100 text-red-600',
        'Medium' => 'bg-orange-100 text-orange-600',
        'Low' => 'bg-slate-100 text-slate-500',
    ];

    function marketingInitials($name) {
        return collect(explode(' ', $name))->map(fn ($n) => $n[0])->implode('');
    }
@endphp

@section('main')
<div class="space-y-8" data-marketing-dashboard data-leads='@json($assignedLeads)'>
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
                    <button class="p-3 bg-surface-soft hover:bg-border-subtle rounded-full text-primary transition-all" data-lead-modal-close>
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
                            <p class="text-xs text-primary/40" data-lead-modal-email></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Catatan</p>
                            <p class="text-sm text-primary/60 italic" data-lead-modal-notes></p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-8 border-t border-border-subtle">
                    <button class="flex-grow btn-primary flex items-center justify-center gap-2">
                        <i data-lucide="phone" class="size-[18px]"></i> Hubungi Telepon
                    </button>
                    <button class="flex-grow py-4 bg-emerald-500 text-white rounded-2xl font-black flex items-center justify-center gap-2 hover:bg-emerald-600 transition-all">
                        <i data-lucide="message-square" class="size-[18px]"></i> Chat WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Leads Saya</h1>
            <p class="text-primary/60">Semangat pagi! Hari ini Anda memiliki {{ count($schedule) }} jadwal pertemuan.</p>
        </div>
        <button class="btn-primary !py-2 !px-4 text-xs flex items-center gap-2">
            <i data-lucide="plus" class="size-4"></i> Lead Baru
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Assigned Leads Section --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($assignedLeads as $lead)
                    <div class="bg-white p-6 rounded-3xl border border-border-subtle shadow-sm flex flex-col justify-between hover:scale-[1.02] transition-transform">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $priorityClasses[$lead['priority']] }}">
                                    {{ $lead['priority'] }} Priority
                                </span>
                                <button class="text-primary/20 hover:text-primary"><i data-lucide="more-vertical" class="size-4"></i></button>
                            </div>
                            <h3 class="font-bold text-lg text-primary">{{ $lead['name'] }}</h3>
                            <p class="text-xs text-primary/40 mb-4">{{ $lead['property'] }}</p>
                        </div>
                        <div class="space-y-3 pt-4 border-t border-border-subtle">
                            <div class="flex items-center justify-between text-[10px] font-bold">
                                <span class="text-primary/40 uppercase tracking-widest">Terakhir Kontak</span>
                                <span class="text-primary/60">{{ $lead['lastContact'] }}</span>
                            </div>
                            <div class="flex gap-2">
                                <button class="flex-grow py-2 bg-surface-soft text-primary rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition-all group" data-open-lead='@json($lead)'>
                                    <i data-lucide="external-link" class="size-3.5 group-hover:scale-110 transition-transform"></i> Detail
                                </button>
                                <button class="flex-grow py-2 bg-emerald-500 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-emerald-600 transition-colors">
                                    <i data-lucide="message-square" class="size-3.5"></i> WhatsApp
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Daily Report Input --}}
            <div class="bg-white rounded-3xl border border-border-subtle shadow-sm p-8">
                <h3 class="font-black text-primary mb-4 flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="size-5 text-accent"></i> Input Report Harian
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pilih Lead</label>
                            <select class="w-full bg-surface-soft border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent">
                                @foreach ($assignedLeads as $lead)
                                    <option>{{ $lead['name'] }}</option>
                                @endforeach
                                <option>Lead Baru / Walk-in</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Status Progress</label>
                            <select class="w-full bg-surface-soft border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent">
                                <option>Survey Lokasi Selesai</option>
                                <option>Follow Up via Telepon</option>
                                <option>Minat / Booking Unit</option>
                                <option>Pembatalan / Tidak Minat</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Keterangan Detail</label>
                        <textarea placeholder="Ceritakan detail aktivitas Anda..." class="w-full bg-surface-soft border-none rounded-xl p-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent min-h-[100px]"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button class="btn-primary !px-8 flex items-center gap-2">
                            Kirim Laporan <i data-lucide="send" class="size-[18px]"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar: Calendar/Schedule --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-border-subtle shadow-sm p-6">
                <h3 class="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="calendar" class="size-[18px] text-accent"></i> Jadwal Hari Ini
                </h3>
                <div class="space-y-4">
                    @foreach ($schedule as $item)
                        <div class="flex gap-4 p-4 rounded-2xl hover:bg-surface-soft transition-colors group cursor-pointer border border-transparent hover:border-border-subtle">
                            <div class="shrink-0 flex flex-col items-center justify-center w-14 h-14 bg-surface-soft rounded-xl group-hover:bg-accent group-hover:text-white transition-colors">
                                <span class="text-[10px] font-black opacity-50 uppercase leading-none">Pkl</span>
                                <span class="text-sm font-black">{{ $item['time'] }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-primary text-sm">{{ $item['title'] }}</h4>
                                <p class="text-[10px] text-primary/40 font-medium uppercase tracking-wider mb-1">{{ $item['location'] }}</p>
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase {{ $item['type'] === 'Closing' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600' }}">
                                    {{ $item['type'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
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
        var initials = modal.querySelector('[data-lead-modal-initials]');
        var name = modal.querySelector('[data-lead-modal-name]');
        var priority = modal.querySelector('[data-lead-modal-priority]');
        var status = modal.querySelector('[data-lead-modal-status]');
        var property = modal.querySelector('[data-lead-modal-property]');
        var phone = modal.querySelector('[data-lead-modal-phone]');
        var email = modal.querySelector('[data-lead-modal-email]');
        var notes = modal.querySelector('[data-lead-modal-notes]');

        function openModal(lead) {
            initials.textContent = lead.name.split(' ').map(function (n) { return n[0]; }).join('');
            name.textContent = lead.name;
            priority.textContent = lead.priority + ' Priority';
            priority.className = 'px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest ' + (lead.priority === 'High' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600');
            status.textContent = lead.status;
            property.textContent = lead.property;
            phone.textContent = lead.phone;
            email.textContent = lead.email;
            notes.textContent = '"' + lead.notes + '"';
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
        modal.querySelector('[data-lead-modal-close]').addEventListener('click', closeModal);
        modal.querySelector('[data-lead-modal-backdrop]').addEventListener('click', closeModal);
    })();
</script>
@endsection
