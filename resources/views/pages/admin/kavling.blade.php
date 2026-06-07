@extends('layouts.dashboard')

@php
    $role = 'admin';
@endphp
@section('title', 'Design Arkanaproperty Web App')

@php
    $projects = ['Arkana Residence Mayangan', 'Arkana Premium Kanigaran', 'Scandinavian Hill Phase 2'];

    $blocks = [
        'Arkana Residence Mayangan' => ['Blok A', 'Blok B', 'Blok C', 'Blok D'],
        'Arkana Premium Kanigaran' => ['Blok Premium 1', 'Blok Premium 2'],
        'Scandinavian Hill Phase 2' => ['Blok Scandi A', 'Blok Scandi B'],
    ];

    $houseTypes = [
        'Arkana Residence Mayangan' => ['Tipe 36/60', 'Tipe 45/84'],
        'Arkana Premium Kanigaran' => ['Tipe 60/100', 'Tipe 72/120'],
        'Scandinavian Hill Phase 2' => ['Tipe Nordic 50', 'Tipe Nordic 70'],
    ];

    $kavlingData = [
        ['id' => 'A-01', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok A', 'type' => 'Tipe 36/60', 'price' => '162jt', 'status' => 'Sold', 'customer' => 'Ahmad Rizky'],
        ['id' => 'A-02', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok A', 'type' => 'Tipe 36/60', 'price' => '162jt', 'status' => 'Available', 'customer' => null],
        ['id' => 'A-03', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok A', 'type' => 'Tipe 36/60', 'price' => '162jt', 'status' => 'Booking', 'customer' => 'Siti Aminah'],
        ['id' => 'A-04', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok A', 'type' => 'Tipe 36/60', 'price' => '162jt', 'status' => 'Available', 'customer' => null],
        ['id' => 'A-05', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok A', 'type' => 'Tipe 45/84', 'price' => '245jt', 'status' => 'Sold', 'customer' => 'Budi S.'],
        ['id' => 'A-06', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok A', 'type' => 'Tipe 45/84', 'price' => '245jt', 'status' => 'Available', 'customer' => null],
        ['id' => 'B-01', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok B', 'type' => 'Tipe 36/60', 'price' => '162jt', 'status' => 'Available', 'customer' => null],
        ['id' => 'B-02', 'project' => 'Arkana Residence Mayangan', 'block' => 'Blok B', 'type' => 'Tipe 36/60', 'price' => '162jt', 'status' => 'Booking', 'customer' => 'Rani M.'],
        ['id' => 'P1-01', 'project' => 'Arkana Premium Kanigaran', 'block' => 'Blok Premium 1', 'type' => 'Tipe 60/100', 'price' => '450jt', 'status' => 'Available', 'customer' => null],
        ['id' => 'P1-02', 'project' => 'Arkana Premium Kanigaran', 'block' => 'Blok Premium 1', 'type' => 'Tipe 72/120', 'price' => '550jt', 'status' => 'Sold', 'customer' => 'Irwan H.'],
        ['id' => 'S1-01', 'project' => 'Scandinavian Hill Phase 2', 'block' => 'Blok Scandi A', 'type' => 'Tipe Nordic 50', 'price' => '385jt', 'status' => 'Booking', 'customer' => 'Rian F.'],
        ['id' => 'S2-01', 'project' => 'Scandinavian Hill Phase 2', 'block' => 'Blok Scandi B', 'type' => 'Tipe Nordic 70', 'price' => '495jt', 'status' => 'Available', 'customer' => null],
    ];

    $statusTiles = [
        ['label' => 'All', 'count' => 120, 'color' => 'bg-slate-200'],
        ['label' => 'Available', 'count' => 23, 'color' => 'bg-white border border-border-subtle'],
        ['label' => 'Booking', 'count' => 12, 'color' => 'bg-accent'],
        ['label' => 'Sold', 'count' => 85, 'color' => 'bg-emerald-custom'],
    ];
@endphp

@section('main')
<div class="space-y-8 relative" data-kavling
     data-projects='@json($projects)'
     data-blocks='@json($blocks)'
     data-house-types='@json($houseTypes)'
     data-kavling-data='@json($kavlingData)'>

    {{-- Unit Detail Overlay --}}
    <div class="fixed inset-0 bg-primary/20 backdrop-blur-sm z-50 items-center justify-center p-4 hidden" data-kavling-overlay>
        <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl" data-kavling-modal-card>
            <div class="p-8 text-white" data-kavling-modal-header>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60">Detail Kavling</p>
                        <h2 class="text-4xl font-black" data-kavling-modal-id></h2>
                    </div>
                    <button class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors" data-kavling-modal-close>
                        <i data-lucide="x-circle" class="size-6"></i>
                    </button>
                </div>
                <div class="flex gap-4">
                    <div class="px-4 py-2 bg-white/10 rounded-xl text-xs font-bold" data-kavling-modal-type></div>
                    <div class="px-4 py-2 bg-white/10 rounded-xl text-xs font-bold" data-kavling-modal-price></div>
                </div>
            </div>

            <div class="p-8 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status Unit</p>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" data-kavling-modal-dot></div>
                            <span class="font-bold text-primary" data-kavling-modal-status></span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Nama Konsumen</p>
                        <span class="font-bold text-primary" data-kavling-modal-customer></span>
                    </div>
                </div>

                <div class="pt-6 border-t border-border-subtle space-y-4">
                    <h4 class="text-xs font-black text-primary uppercase tracking-widest">Opsi Manajemen</h4>
                    <div class="grid grid-cols-1 gap-2">
                        <button class="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary hover:bg-border-subtle transition-all">
                            Update Status Unit <i data-lucide="chevron-right" class="size-4"></i>
                        </button>
                        <button class="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary hover:bg-border-subtle transition-all">
                            Lihat Berkas Konsumen <i data-lucide="chevron-right" class="size-4"></i>
                        </button>
                        <button class="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary hover:bg-border-subtle transition-all">
                            Edit Spesifikasi Kavling <i data-lucide="chevron-right" class="size-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Manajemen Kavling</h1>
            <p class="text-primary/60">Monitor ketersediaan unit dan status penjualan secara real-time.</p>
        </div>
        <div class="flex gap-2">
            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
                <i data-lucide="maximize-2" class="size-4"></i> Site Plan View
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <i data-lucide="plus" class="size-4"></i> Tambah Kavling
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Sidebar Filters --}}
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="building-2" class="size-4 text-accent"></i> Pilih Perumahan
                </h3>
                <select class="w-full p-4 bg-surface-soft rounded-2xl font-bold text-primary outline-none focus:ring-1 focus:ring-accent appearance-none" data-project-select>
                    @foreach ($projects as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div class="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="map-pin" class="size-4 text-accent"></i> Pilih Blok
                </h3>
                <div class="space-y-2 max-h-[200px] overflow-y-auto pr-2" data-block-list></div>
            </div>

            <div class="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-4 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="home" class="size-4 text-accent"></i> Tipe Rumah
                </h3>
                <div class="space-y-2" data-type-list></div>
            </div>

            <div class="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-4 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="tag" class="size-4 text-accent"></i> Status Unit
                </h3>
                <div class="space-y-3" data-status-list>
                    @foreach ($statusTiles as $status)
                        <button data-status="{{ $status['label'] }}" class="w-full flex items-center justify-between p-2 rounded-xl text-xs font-bold transition-all {{ $status['label'] === 'All' ? 'bg-surface-soft ring-1 ring-accent/30' : 'hover:bg-surface-soft' }}">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full {{ $status['color'] }}"></div>
                                {{ $status['label'] }}
                            </div>
                            <span class="text-primary/40">{{ $status['count'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kavling Grid --}}
        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-black text-primary"><span data-current-block></span> <span class="text-accent">—</span> Detail Unit</h2>
                    <div class="relative">
                        <i data-lucide="search" class="size-4 absolute left-3 top-1/2 -translate-y-1/2 text-primary/30"></i>
                        <input type="text" placeholder="Cari nomor unit..." class="bg-surface-soft border-none rounded-xl py-2 pl-10 pr-4 text-xs font-bold outline-none focus:ring-1 focus:ring-accent" data-kavling-search />
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" data-kavling-grid></div>

                <div class="mt-12 flex flex-wrap gap-6 pt-8 border-t border-border-subtle">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-md bg-white border-2 border-dashed border-border-subtle"></div>
                        <span class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Available</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-md bg-accent"></div>
                        <span class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Booking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-md bg-emerald-custom"></div>
                        <span class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Sold</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-kavling]');
        if (!root) return;

        var projects = JSON.parse(root.getAttribute('data-projects'));
        var blocks = JSON.parse(root.getAttribute('data-blocks'));
        var houseTypes = JSON.parse(root.getAttribute('data-house-types'));
        var kavlingData = JSON.parse(root.getAttribute('data-kavling-data'));

        var state = {
            project: projects[0],
            block: blocks[projects[0]][0],
            type: 'All',
            status: 'All',
            search: '',
        };

        var projectSelect = root.querySelector('[data-project-select]');
        var blockList = root.querySelector('[data-block-list]');
        var typeList = root.querySelector('[data-type-list]');
        var statusButtons = Array.prototype.slice.call(root.querySelectorAll('[data-status-list] button'));
        var searchInput = root.querySelector('[data-kavling-search]');
        var grid = root.querySelector('[data-kavling-grid]');
        var currentBlockLabel = root.querySelector('[data-current-block]');

        function statusStyle(status) {
            switch (status) {
                case 'Sold': return 'bg-emerald-custom text-white shadow-lg shadow-emerald-custom/20';
                case 'Booking': return 'bg-accent text-white shadow-lg shadow-emerald-custom/20';
                case 'Available': return 'bg-white border-2 border-dashed border-border-subtle text-primary/40 hover:border-accent hover:text-accent';
                default: return 'bg-slate-100 text-slate-500';
            }
        }

        function renderBlocks() {
            blockList.innerHTML = '';
            blocks[state.project].forEach(function (block) {
                var active = state.block === block;
                var btn = document.createElement('button');
                btn.className = 'w-full flex items-center justify-between p-4 rounded-2xl font-bold transition-all ' + (active ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-surface-soft text-primary/60 hover:bg-border-subtle');
                btn.innerHTML = '<span class="text-xs">' + block + '</span><i data-lucide="chevron-right" class="size-3.5 ' + (active ? 'opacity-100' : 'opacity-0') + '"></i>';
                btn.addEventListener('click', function () {
                    state.block = block;
                    renderAll();
                });
                blockList.appendChild(btn);
            });
        }

        function renderTypes() {
            typeList.innerHTML = '';
            var allBtn = document.createElement('button');
            allBtn.className = 'w-full p-3 rounded-xl text-xs font-bold transition-all ' + (state.type === 'All' ? 'bg-accent text-white' : 'bg-surface-soft text-primary/60');
            allBtn.textContent = 'Semua Tipe';
            allBtn.addEventListener('click', function () { state.type = 'All'; renderAll(); });
            typeList.appendChild(allBtn);

            houseTypes[state.project].forEach(function (type) {
                var btn = document.createElement('button');
                btn.className = 'w-full p-3 rounded-xl text-xs font-bold transition-all ' + (state.type === type ? 'bg-accent text-white' : 'bg-surface-soft text-primary/60');
                btn.textContent = type;
                btn.addEventListener('click', function () { state.type = type; renderAll(); });
                typeList.appendChild(btn);
            });
        }

        function renderGrid() {
            currentBlockLabel.textContent = state.block;
            grid.innerHTML = '';
            var term = state.search.toLowerCase();

            kavlingData.filter(function (k) {
                if (k.project !== state.project) return false;
                if (k.block !== state.block) return false;
                if (state.type !== 'All' && k.type !== state.type) return false;
                if (state.status !== 'All' && k.status !== state.status) return false;
                if (term && k.id.toLowerCase().indexOf(term) === -1 && !(k.customer && k.customer.toLowerCase().indexOf(term) !== -1)) return false;
                return true;
            }).forEach(function (k) {
                var card = document.createElement('div');
                card.className = 'aspect-square rounded-3xl p-4 flex flex-col justify-between cursor-pointer transition-all hover:-translate-y-1 ' + statusStyle(k.status);
                card.innerHTML =
                    '<div class="flex justify-between items-start">' +
                        '<span class="text-lg font-black">' + k.id + '</span>' +
                        '<button class="p-1 hover:bg-black/5 rounded-md transition-colors"><i data-lucide="more-vertical" class="size-3.5"></i></button>' +
                    '</div>' +
                    '<div>' +
                        '<p class="text-[9px] font-black uppercase tracking-widest mb-1 ' + (k.status === 'Available' ? 'text-primary/20' : 'text-white/60') + '">' + k.type + '</p>' +
                        '<p class="text-[10px] font-bold truncate">' + (k.customer || 'TERSEDIA') + '</p>' +
                    '</div>';
                card.addEventListener('click', function () { openOverlay(k); });
                grid.appendChild(card);
            });

            if (window.lucide) lucide.createIcons();
        }

        function renderAll() {
            renderBlocks();
            renderTypes();
            renderGrid();
            if (window.lucide) lucide.createIcons();
        }

        projectSelect.addEventListener('change', function () {
            state.project = projectSelect.value;
            state.block = blocks[state.project][0];
            state.type = 'All';
            renderAll();
        });

        statusButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                state.status = btn.getAttribute('data-status');
                statusButtons.forEach(function (b) {
                    b.classList.remove('bg-surface-soft', 'ring-1', 'ring-accent/30');
                    b.classList.add('hover:bg-surface-soft');
                });
                btn.classList.add('bg-surface-soft', 'ring-1', 'ring-accent/30');
                btn.classList.remove('hover:bg-surface-soft');
                renderGrid();
            });
        });

        searchInput.addEventListener('input', function () {
            state.search = searchInput.value;
            renderGrid();
        });

        // Overlay
        var overlay = root.querySelector('[data-kavling-overlay]');
        var modalCard = root.querySelector('[data-kavling-modal-card]');
        var modalHeader = root.querySelector('[data-kavling-modal-header]');
        var modalId = root.querySelector('[data-kavling-modal-id]');
        var modalType = root.querySelector('[data-kavling-modal-type]');
        var modalPrice = root.querySelector('[data-kavling-modal-price]');
        var modalDot = root.querySelector('[data-kavling-modal-dot]');
        var modalStatus = root.querySelector('[data-kavling-modal-status]');
        var modalCustomer = root.querySelector('[data-kavling-modal-customer]');

        function openOverlay(k) {
            modalHeader.className = 'p-8 text-white ' + (k.status === 'Sold' ? 'bg-emerald-custom' : k.status === 'Booking' ? 'bg-accent' : 'bg-primary');
            modalId.textContent = k.id;
            modalType.textContent = k.type;
            modalPrice.textContent = k.price;
            modalDot.className = 'w-3 h-3 rounded-full ' + (k.status === 'Sold' ? 'bg-emerald-500' : k.status === 'Booking' ? 'bg-accent' : 'bg-slate-300');
            modalStatus.textContent = k.status;
            modalCustomer.textContent = k.customer || 'Belum Ada';
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            if (window.lucide) lucide.createIcons();
        }

        function closeOverlay() {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeOverlay();
        });
        root.querySelector('[data-kavling-modal-close]').addEventListener('click', closeOverlay);
        modalCard.addEventListener('click', function (e) { e.stopPropagation(); });

        renderAll();
    })();
</script>
@endsection
