@extends('layouts.dashboard')

@php
    $role = 'admin';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $leads = [
        ['id' => 1, 'name' => 'Ahmad Rizky', 'phone' => '081234567890', 'email' => 'ahmad@example.com', 'property' => 'Tipe 36/60', 'status' => 'Hot Prospect', 'source' => 'Website', 'date' => '7 Juni 2026'],
        ['id' => 2, 'name' => 'Siti Aminah', 'phone' => '089876543210', 'email' => 'siti@example.com', 'property' => 'Premium Cluster', 'status' => 'New Lead', 'source' => 'WhatsApp', 'date' => '7 Juni 2026'],
        ['id' => 3, 'name' => 'Budi Santoso', 'phone' => '081122334455', 'email' => 'budi@example.com', 'property' => 'Tipe 36/60', 'status' => 'Cold Lead', 'source' => 'Facebook Ads', 'date' => '6 Juni 2026'],
        ['id' => 4, 'name' => 'Dewi Lestari', 'phone' => '085566778899', 'email' => 'dewi@example.com', 'property' => 'Premium Cluster', 'status' => 'Interested', 'source' => 'Instagram', 'date' => '6 Juni 2026'],
        ['id' => 5, 'name' => 'Fajri Hidayat', 'phone' => '081299887766', 'email' => 'fajri@example.com', 'property' => 'Tipe 36/60', 'status' => 'Lost', 'source' => 'Walk-in', 'date' => '5 Juni 2026'],
        ['id' => 6, 'name' => 'Lina Marlina', 'phone' => '087755443322', 'email' => 'lina@example.com', 'property' => 'Premium Cluster', 'status' => 'Hot Prospect', 'source' => 'Website', 'date' => '5 Juni 2026'],
    ];

    $statusColors = [
        'Hot Prospect' => 'bg-orange-100 text-orange-600',
        'New Lead' => 'bg-blue-100 text-blue-600',
        'Interested' => 'bg-emerald-100 text-emerald-600',
        'Cold Lead' => 'bg-slate-100 text-slate-500',
        'Lost' => 'bg-red-100 text-red-600',
    ];

    $statTiles = [
        ['label' => 'Total Prospek', 'value' => '1,284', 'icon' => 'user-plus', 'color' => 'text-blue-600'],
        ['label' => 'Hot Prospect', 'value' => '42', 'icon' => 'check-circle-2', 'color' => 'text-orange-600'],
        ['label' => 'Follow Up', 'value' => '156', 'icon' => 'clock', 'color' => 'text-accent'],
        ['label' => 'Closing Bulan Ini', 'value' => '12', 'icon' => 'check-circle-2', 'color' => 'text-emerald-custom'],
    ];

    $statuses = ['All', 'New Lead', 'Hot Prospect', 'Interested', 'Cold Lead', 'Lost'];

    function leadInitials($name) {
        return collect(explode(' ', $name))->map(fn ($n) => $n[0])->implode('');
    }
@endphp

@section('main')
<div class="space-y-6" data-leads>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Manajemen Leads</h1>
            <p class="text-primary/60">Kelola dan pantau seluruh prospek konsumen Arkanaproperty.</p>
        </div>
        <div class="flex gap-2">
            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
                <i data-lucide="download" class="size-4"></i> Export CSV
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <i data-lucide="user-plus" class="size-4"></i> Tambah Lead
            </button>
        </div>
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
            <div class="relative w-full md:w-96">
                <i data-lucide="search" class="size-[18px] absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                <input type="text" placeholder="Cari nama atau nomor telepon..." class="w-full bg-surface-soft border-none rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" data-search-input />
            </div>
            <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0" data-status-filters>
                @foreach ($statuses as $status)
                    <button data-status="{{ $status }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $status === 'All' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-surface-soft text-primary/60 hover:bg-border-subtle' }}">
                        {{ $status }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-soft border-b border-border-subtle">
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">
                            <div class="flex items-center gap-2">Konsumen <i data-lucide="arrow-up-down" class="size-3"></i></div>
                        </th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Minat Unit</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Sumber</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle" data-leads-body>
                    @foreach ($leads as $lead)
                        <tr class="hover:bg-surface-soft/30 transition-colors group" data-lead-row data-name="{{ strtolower($lead['name']) }}" data-phone="{{ $lead['phone'] }}" data-status="{{ $lead['status'] }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-surface-soft border border-border-subtle flex items-center justify-center font-black text-primary text-xs shrink-0">
                                        {{ leadInitials($lead['name']) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-primary group-hover:text-accent transition-colors">{{ $lead['name'] }}</div>
                                        <div class="text-[10px] text-primary/40">{{ $lead['phone'] }} • {{ $lead['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-primary/70">{{ $lead['property'] }}</div>
                                <div class="text-[9px] text-primary/40 uppercase tracking-tighter">Terdaftar: {{ $lead['date'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium text-primary/60">{{ $lead['source'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter {{ $statusColors[$lead['status']] }}">
                                    {{ $lead['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-1">
                                    <button class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="WhatsApp">
                                        <i data-lucide="message-circle" class="size-[18px]"></i>
                                    </button>
                                    <button class="p-2 text-primary/40 hover:bg-surface-soft rounded-lg transition-colors">
                                        <i data-lucide="more-horizontal" class="size-[18px]"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-border-subtle bg-surface-soft/30 flex items-center justify-between">
            <p class="text-xs text-primary/40 font-medium">Menampilkan <span data-visible-count>{{ count($leads) }}</span> dari {{ count($leads) }} leads</p>
            <div class="flex gap-2">
                <button class="px-3 py-1 bg-white border border-border-subtle rounded-lg text-xs font-bold opacity-50 cursor-not-allowed">Prev</button>
                <button class="px-3 py-1 bg-white border border-border-subtle rounded-lg text-xs font-bold hover:border-accent">Next</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-leads]');
        if (!root) return;
        var searchInput = root.querySelector('[data-search-input]');
        var statusButtons = Array.prototype.slice.call(root.querySelectorAll('[data-status-filters] button'));
        var rows = Array.prototype.slice.call(root.querySelectorAll('[data-lead-row]'));
        var visibleCount = root.querySelector('[data-visible-count]');
        var currentStatus = 'All';

        function applyFilters() {
            var term = searchInput.value.toLowerCase();
            var visible = 0;
            rows.forEach(function (row) {
                var matchesSearch = row.getAttribute('data-name').indexOf(term) !== -1 || row.getAttribute('data-phone').indexOf(term) !== -1;
                var matchesStatus = currentStatus === 'All' || row.getAttribute('data-status') === currentStatus;
                var show = matchesSearch && matchesStatus;
                row.classList.toggle('hidden', !show);
                if (show) visible++;
            });
            visibleCount.textContent = visible;
        }

        searchInput.addEventListener('input', applyFilters);

        statusButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                currentStatus = btn.getAttribute('data-status');
                statusButtons.forEach(function (b) {
                    b.classList.remove('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
                    b.classList.add('bg-surface-soft', 'text-primary/60', 'hover:bg-border-subtle');
                });
                btn.classList.add('bg-primary', 'text-white', 'shadow-lg', 'shadow-primary/20');
                btn.classList.remove('bg-surface-soft', 'text-primary/60', 'hover:bg-border-subtle');
                applyFilters();
            });
        });
    })();
</script>
@endsection
