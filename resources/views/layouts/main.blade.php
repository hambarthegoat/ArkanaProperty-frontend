@extends('layouts.base')

@section('content')
<div class="min-h-screen flex flex-col">
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-sm border-b border-border-subtle" data-menu>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-black text-primary tracking-tighter">
                        Arkana<span class="text-accent">Property</span>
                    </span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-primary font-medium hover:text-accent transition-colors">Beranda</a>
                    <a href="#katalog" class="text-primary font-medium hover:text-accent transition-colors">Katalog</a>
                    <a href="/tentang" class="text-primary font-medium hover:text-accent transition-colors">Tentang Kami</a>
                    <a href="{{ route('login') }}" class="text-primary font-medium hover:text-accent transition-colors">Akses Panel</a>
                    <a href="{{ route('login') }}" class="btn-gold-outline flex items-center gap-2">
                        Hubungi Kami
                    </a>
                </div>

                <button class="md:hidden p-2" data-menu-toggle>
                    <i data-lucide="menu" class="size-6" data-menu-icon-open></i>
                    <i data-lucide="x" class="size-6 hidden" data-menu-icon-close></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="md:hidden bg-white border-b border-border-subtle p-4 space-y-4 hidden" data-menu-panel>
            <a href="{{ route('home') }}" class="block text-primary font-medium">Beranda</a>
            <a href="#katalog" class="block text-primary font-medium">Katalog Properti</a>
            <a href="/tentang" class="block text-primary font-medium">Tentang Kami</a>
            <a href="{{ route('login') }}" class="block text-primary font-medium">Akses Panel</a>
            <a href="{{ route('login') }}" class="btn-gold-outline w-full text-center block">Hubungi Kami</a>
        </div>
    </nav>

    <main class="flex-grow pt-20">
        @yield('main')
    </main>

    <footer class="bg-primary text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center sm:text-left grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4 italic">ArkanaProperty</h3>
                <p class="text-white/60 text-sm">
                    Solusi hunian modern dan investasi properti terpercaya di Probolinggo dan sekitarnya.
                </p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="#katalog">Katalog Properti</a></li>
                    <li><a href="/tentang">Tentang Kami</a></li>
                    <li><a href="{{ route('login') }}">Akses Panel (Admin/Marketing)</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Portal Konsumen</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('login') }}">Login Portal</a></li>
                    <li><a href="{{ route('login') }}">Pantau Progres Unit</a></li>
                    <li><a href="{{ route('login') }}">Bantuan Konsumen</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Hubungi Kami</h4>
                <p class="text-sm text-white/60 mb-2">Jl. Raya Arkanaproperty No. 1</p>
                <p class="text-sm text-white/60 mb-4">Probolinggo, Jawa Timur</p>
                <a href="https://wa.me/628123456789" class="btn-gold-outline !text-white border-white/20 hover:border-accent inline-block text-center">
                    WhatsApp Marketing
                </a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-12 pt-8 border-t border-white/10 text-center text-xs text-white/40">
            © 2026 Arkanaproperty. Seluruh hak cipta dilindungi.
        </div>
    </footer>
</div>

<script>
    (function () {
        var nav = document.querySelector('[data-menu]');
        if (!nav) return;
        var toggle = nav.querySelector('[data-menu-toggle]');
        var panel = nav.querySelector('[data-menu-panel]');
        var iconOpen = nav.querySelector('[data-menu-icon-open]');
        var iconClose = nav.querySelector('[data-menu-icon-close]');
        toggle.addEventListener('click', function () {
            panel.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
        panel.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                panel.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            });
        });
    })();
</script>
@endsection
