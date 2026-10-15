@extends('layouts.dashboard', ['role' => 'admin'])

@section('title', 'Manajemen Kavling - ArkanaProperty')

@section('main')
<div class="space-y-8 relative" data-kavling
     data-projects='@json($projects)'
     data-blocks='@json($blocks)'
     data-house-types='@json($houseTypes)'
     data-kavling-data='@json($kavlingData)'
     data-initial-project="{{ $initialProject }}"
     data-update-url="{{ url('admin/kavling') }}">

    {{-- Unit Detail Overlay --}}
    <div class="fixed inset-0 bg-primary/20 backdrop-blur-sm z-50 items-center justify-center p-4 hidden" data-kavling-overlay>
        <div class="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl" data-kavling-modal-card>
            <div class="p-8 text-white" data-kavling-modal-header>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60">Detail Kavling</p>
                        <h2 class="text-4xl font-black" data-kavling-modal-id></h2>
                    </div>
                    <button type="button" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors" data-kavling-modal-close>
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

                <form method="POST" action="#" class="pt-6 border-t border-border-subtle space-y-4" data-kavling-update-form>
                    @csrf
                    @method('PUT')
                    <h4 class="text-xs font-black text-primary uppercase tracking-widest">Update Status Unit</h4>
                    <div class="grid grid-cols-1 gap-3">
                        <select name="status" class="w-full p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary outline-none" data-kavling-status-input>
                            <option value="tersedia">Tersedia</option>
                            <option value="booking">Booking</option>
                            <option value="terjual">Terjual</option>
                        </select>
                        <select name="id_leads" class="w-full p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary outline-none" data-kavling-buyer-input>
                            <option value="">— Belum ada pembeli —</option>
                            @foreach ($buyers as $buyer)
                                <option value="{{ $buyer['id'] }}">{{ $buyer['nama'] }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-primary/40">Pembeli dipilih dari lead tervalidasi. Status "Tersedia" otomatis melepas pembeli.</p>
                        <button type="submit" class="btn-primary w-full">Simpan Perubahan</button>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="#" class="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-xs text-primary hover:bg-border-subtle transition-all" data-kavling-customer-link>
                            Berkas Konsumen <i data-lucide="chevron-right" class="size-4"></i>
                        </a>
                        <a href="#" target="_blank" class="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-xs text-primary hover:bg-border-subtle transition-all" data-kavling-panel-link>
                            Edit di Panel <i data-lucide="chevron-right" class="size-4"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Manajemen Kavling</h1>
            <p class="text-primary/60">Monitor ketersediaan unit dan status penjualan secara real-time.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ config('services.arkana_api.admin_panel_url') }}/kavling" class="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
                <i data-lucide="maximize-2" class="size-4"></i> Buka di Admin Panel
            </a>
            <button type="button" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all" data-toggle-create>
                <i data-lucide="plus" class="size-4"></i> Tambah Kavling
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.kavling.store') }}" class="{{ $errors->any() ? '' : 'hidden' }} bg-white rounded-[32px] border border-border-subtle shadow-sm p-6 grid grid-cols-1 md:grid-cols-5 gap-3 items-end" data-create-form>
        @csrf
        <div class="md:col-span-2 space-y-1">
            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Perumahan / Tipe</label>
            <select name="id_tipe" required class="w-full bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none">
                @foreach ($tipeOptions as $tipe)
                    <option value="{{ $tipe['id'] }}" @selected((int) old('id_tipe') === $tipe['id'])>{{ $tipe['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="space-y-1">
            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Blok</label>
            <input name="blok" value="{{ old('blok') }}" placeholder="Blok A" class="w-full bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
        </div>
        <div class="space-y-1">
            <label class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Nomor</label>
            <input name="nomor_kavling" value="{{ old('nomor_kavling') }}" required placeholder="A-07" class="w-full bg-surface-soft rounded-xl p-3 text-sm font-bold outline-none" />
        </div>
        <button type="submit" class="btn-primary">Tambah</button>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Sidebar Filters --}}
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
                <h3 class="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
                    <i data-lucide="building-2" class="size-4 text-accent"></i> Pilih Perumahan
                </h3>
                <select class="w-full p-4 bg-surface-soft rounded-2xl font-bold text-primary outline-none focus:ring-1 focus:ring-accent appearance-none" data-project-select>
                    @foreach ($projects as $p)
                        <option value="{{ $p['id'] }}" @selected($p['id'] === $initialProject)>{{ $p['name'] }}</option>
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
                        <button type="button" data-status="{{ $status['value'] }}" class="w-full flex items-center justify-between p-2 rounded-xl text-xs font-bold transition-all {{ $status['value'] === 'all' ? 'bg-surface-soft ring-1 ring-accent/30' : 'hover:bg-surface-soft' }}">
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
                        <input type="text" placeholder="Cari unit / konsumen..." class="bg-surface-soft border-none rounded-xl py-2 pl-10 pr-4 text-xs font-bold outline-none focus:ring-1 focus:ring-accent" data-kavling-search />
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" data-kavling-grid></div>

                <div class="mt-12 flex flex-wrap gap-6 pt-8 border-t border-border-subtle">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-md bg-white border-2 border-dashed border-border-subtle"></div>
                        <span class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Tersedia</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-md bg-accent"></div>
                        <span class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Booking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-md bg-emerald-custom"></div>
                        <span class="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Terjual</span>
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
        var updateUrl = root.getAttribute('data-update-url');
        var panelUrl = @json(config('services.arkana_api.admin_panel_url'));
        var leadsUrl = @json(route('admin.leads'));

        var initialProject = parseInt(root.getAttribute('data-initial-project'), 10) || (projects[0] && projects[0].id);
        var state = { project: initialProject, block: (blocks[initialProject] || [])[0], type: 'All', status: 'all', search: '' };

        var createForm = root.querySelector('[data-create-form]');
        root.querySelectorAll('[data-toggle-create]').forEach(function (btn) {
            btn.addEventListener('click', function () { createForm.classList.toggle('hidden'); });
        });

        var projectSelect = root.querySelector('[data-project-select]');
        var blockList = root.querySelector('[data-block-list]');
        var typeList = root.querySelector('[data-type-list]');
        var statusButtons = Array.prototype.slice.call(root.querySelectorAll('[data-status-list] button'));
        var searchInput = root.querySelector('[data-kavling-search]');
        var grid = root.querySelector('[data-kavling-grid]');
        var currentBlockLabel = root.querySelector('[data-current-block]');

        function esc(value) {
            var div = document.createElement('div');
            div.textContent = value == null ? '' : String(value);
            return div.innerHTML;
        }

        function statusStyle(status) {
            switch (status) {
                case 'terjual': return 'bg-emerald-custom text-white shadow-lg shadow-emerald-custom/20';
                case 'booking': return 'bg-accent text-white shadow-lg shadow-emerald-custom/20';
                default: return 'bg-white border-2 border-dashed border-border-subtle text-primary/40 hover:border-accent hover:text-accent';
            }
        }

        function renderBlocks() {
            blockList.innerHTML = '';
            var list = blocks[state.project] || [];
            if (!list.length) {
                blockList.innerHTML = '<p class="text-xs text-primary/40">Belum ada kavling.</p>';
                return;
            }
            list.forEach(function (block) {
                var active = state.block === block;
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full flex items-center justify-between p-4 rounded-2xl font-bold transition-all ' + (active ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-surface-soft text-primary/60 hover:bg-border-subtle');
                btn.innerHTML = '<span class="text-xs">' + esc(block) + '</span><i data-lucide="chevron-right" class="size-3.5 ' + (active ? 'opacity-100' : 'opacity-0') + '"></i>';
                btn.addEventListener('click', function () { state.block = block; renderAll(); });
                blockList.appendChild(btn);
            });
        }

        function renderTypes() {
            typeList.innerHTML = '';
            var allBtn = document.createElement('button');
            allBtn.type = 'button';
            allBtn.className = 'w-full p-3 rounded-xl text-xs font-bold transition-all ' + (state.type === 'All' ? 'bg-accent text-white' : 'bg-surface-soft text-primary/60');
            allBtn.textContent = 'Semua Tipe';
            allBtn.addEventListener('click', function () { state.type = 'All'; renderAll(); });
            typeList.appendChild(allBtn);

            (houseTypes[state.project] || []).forEach(function (type) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full p-3 rounded-xl text-xs font-bold transition-all ' + (state.type === type ? 'bg-accent text-white' : 'bg-surface-soft text-primary/60');
                btn.textContent = type;
                btn.addEventListener('click', function () { state.type = type; renderAll(); });
                typeList.appendChild(btn);
            });
        }

        function renderGrid() {
            currentBlockLabel.textContent = state.block || '-';
            grid.innerHTML = '';
            var term = state.search.toLowerCase();

            var items = kavlingData.filter(function (k) {
                if (k.project !== state.project) return false;
                if (k.block !== state.block) return false;
                if (state.type !== 'All' && k.type !== state.type) return false;
                if (state.status !== 'all' && k.status !== state.status) return false;
                if (term && k.code.toLowerCase().indexOf(term) === -1 && !(k.customer && k.customer.toLowerCase().indexOf(term) !== -1)) return false;
                return true;
            });

            if (!items.length) {
                grid.innerHTML = '<p class="col-span-full text-center text-primary/40 py-10">Tidak ada unit yang cocok.</p>';
            }

            items.forEach(function (k) {
                var card = document.createElement('div');
                card.className = 'aspect-square rounded-3xl p-4 flex flex-col justify-between cursor-pointer transition-all hover:-translate-y-1 ' + statusStyle(k.status);
                card.setAttribute('data-unit', k.code);
                card.innerHTML =
                    '<div class="flex justify-between items-start">' +
                        '<span class="text-lg font-black">' + esc(k.code) + '</span>' +
                        '<i data-lucide="more-vertical" class="size-3.5"></i>' +
                    '</div>' +
                    '<div>' +
                        '<p class="text-[9px] font-black uppercase tracking-widest mb-1 ' + (k.status === 'tersedia' ? 'text-primary/20' : 'text-white/60') + '">' + esc(k.type) + '</p>' +
                        '<p class="text-[10px] font-bold truncate">' + esc(k.customer || 'TERSEDIA') + '</p>' +
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
            state.project = parseInt(projectSelect.value, 10);
            state.block = (blocks[state.project] || [])[0];
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
        var updateForm = root.querySelector('[data-kavling-update-form]');

        function openOverlay(k) {
            modalHeader.className = 'p-8 text-white ' + (k.status === 'terjual' ? 'bg-emerald-custom' : k.status === 'booking' ? 'bg-accent' : 'bg-primary');
            root.querySelector('[data-kavling-modal-id]').textContent = k.code;
            root.querySelector('[data-kavling-modal-type]').textContent = k.type;
            root.querySelector('[data-kavling-modal-price]').textContent = k.price;
            root.querySelector('[data-kavling-modal-dot]').className = 'w-3 h-3 rounded-full ' + (k.status === 'terjual' ? 'bg-emerald-500' : k.status === 'booking' ? 'bg-accent' : 'bg-slate-300');
            root.querySelector('[data-kavling-modal-status]').textContent = k.status_label;
            root.querySelector('[data-kavling-modal-customer]').textContent = k.customer || 'Belum Ada';
            updateForm.action = updateUrl + '/' + k.id;
            root.querySelector('[data-kavling-status-input]').value = k.status;
            root.querySelector('[data-kavling-buyer-input]').value = k.id_leads || '';
            var customerLink = root.querySelector('[data-kavling-customer-link]');
            customerLink.href = leadsUrl + (k.customer ? '?search=' + encodeURIComponent(k.customer) : '');
            root.querySelector('[data-kavling-panel-link]').href = panelUrl + '/kavling/' + k.id + '/edit';
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
