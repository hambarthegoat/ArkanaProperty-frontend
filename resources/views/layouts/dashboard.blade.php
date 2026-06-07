@extends('layouts.base')

@php
    $menuItems = [
        'admin' => [
            ['path' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
            ['path' => route('admin.perumahan'), 'active' => request()->routeIs('admin.perumahan'), 'icon' => 'home', 'label' => 'Kelola Perumahan'],
            ['path' => route('admin.kavling'), 'active' => request()->routeIs('admin.kavling'), 'icon' => 'clipboard-list', 'label' => 'Kelola Kavling'],
            ['path' => route('admin.leads'), 'active' => request()->routeIs('admin.leads'), 'icon' => 'users', 'label' => 'Data Leads'],
            ['path' => route('admin.reports'), 'active' => request()->routeIs('admin.reports'), 'icon' => 'file-text', 'label' => 'Report Marketing'],
        ],
        'marketing' => [
            ['path' => route('marketing.dashboard'), 'active' => request()->routeIs('marketing.dashboard'), 'icon' => 'layout-dashboard', 'label' => 'Leads Saya'],
            ['path' => route('marketing.calendar'), 'active' => request()->routeIs('marketing.calendar'), 'icon' => 'calendar', 'label' => 'Jadwal/Kalender'],
            ['path' => route('marketing.reports'), 'active' => request()->routeIs('marketing.reports'), 'icon' => 'file-text', 'label' => 'Report Harian'],
        ],
        'user' => [
            ['path' => route('portal.dashboard'), 'active' => request()->routeIs('portal.dashboard'), 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
            ['path' => route('portal.reminders'), 'active' => request()->routeIs('portal.reminders'), 'icon' => 'bell', 'label' => 'Timeline'],
            ['path' => route('portal.support'), 'active' => request()->routeIs('portal.support'), 'icon' => 'message-square', 'label' => 'Bantuan'],
        ],
    ][$role];
@endphp

@section('content')
<div class="flex h-screen bg-surface-soft overflow-hidden text-sm" data-dashboard>
    {{-- Sidebar --}}
    <aside class="w-64 bg-primary text-white transition-all duration-300 flex flex-col z-50" data-sidebar>
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 bg-accent rounded-lg shrink-0 flex items-center justify-center font-bold text-white">A</div>
            <span class="font-bold tracking-tight text-lg" data-sidebar-label>ARKANA PANEL</span>
        </div>

        <nav class="flex-grow mt-6 px-3 space-y-2">
            @foreach ($menuItems as $item)
                <a href="{{ $item['path'] }}"
                   class="flex items-center gap-3 p-3 rounded-xl transition-all {{ $item['active'] ? 'bg-accent text-white' : 'text-white/60 hover:bg-white/10 hover:text-white' }}">
                    <i data-lucide="{{ $item['icon'] }}" class="size-5 shrink-0"></i>
                    <span data-sidebar-label>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-white/10">
            <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 w-full text-white/60 hover:text-white transition-colors">
                <i data-lucide="log-out" class="size-5 shrink-0"></i>
                <span data-sidebar-label>Keluar</span>
            </a>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-grow flex flex-col min-w-0">
        <header class="h-16 bg-white border-b border-border-subtle flex items-center justify-between px-6 shrink-0">
            <button class="p-2 hover:bg-surface-soft rounded-lg" data-sidebar-toggle>
                <i data-lucide="menu" class="size-5"></i>
            </button>

            <div class="flex items-center gap-4">
                <button class="p-2 hover:bg-surface-soft rounded-full relative">
                    <i data-lucide="bell" class="size-5"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div class="flex items-center gap-3 pl-4 border-l border-border-subtle">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs uppercase opacity-50">{{ $role }}</p>
                        <p class="font-medium">Sistem User</p>
                    </div>
                    <div class="w-10 h-10 bg-surface-soft rounded-full border border-border-subtle overflow-hidden">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $role }}" alt="Avatar" />
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow overflow-y-auto p-6 lg:p-10">
            @yield('main')
        </main>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-dashboard]');
        if (!root) return;
        var sidebar = root.querySelector('[data-sidebar]');
        var toggle = root.querySelector('[data-sidebar-toggle]');
        var labels = root.querySelectorAll('[data-sidebar-label]');
        var open = true;
        toggle.addEventListener('click', function () {
            open = !open;
            sidebar.classList.toggle('w-64', open);
            sidebar.classList.toggle('w-20', !open);
            labels.forEach(function (label) {
                label.classList.toggle('hidden', !open);
            });
        });
    })();
</script>
@endsection
