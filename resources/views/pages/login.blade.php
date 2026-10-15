@extends('layouts.base')

@section('title', 'Design Arkanaproperty Web App')

@php
    $roles = [
        ['icon' => 'shield-check', 'label' => 'Admin', 'description' => 'Kelola data, leads & marketing'],
        ['icon' => 'briefcase', 'label' => 'Marketing', 'description' => 'Kelola leads & laporan harian'],
        ['icon' => 'home', 'label' => 'Konsumen', 'description' => 'Username = nomor HP terdaftar'],
    ];
@endphp

@section('content')
<div class="flex min-h-screen bg-surface-soft font-sans">
    {{-- Left side: Form/Navigation --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-20">
        <div class="max-w-md w-full">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-primary mb-2">
                    Arkana<span class="text-accent">Property</span>
                </h1>
                <p class="text-primary/60">Selamat datang kembali. Masuk dengan akun Anda untuk melanjutkan.</p>
            </div>

            @if (session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm font-semibold" role="alert">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5" data-login-form>
                @csrf
                <div class="space-y-1">
                    <label for="username" class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="size-4 absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus autocomplete="username"
                               class="w-full bg-white border {{ $errors->has('username') ? 'border-red-300' : 'border-border-subtle' }} rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium"
                               placeholder="Username atau nomor HP" />
                    </div>
                    @error('username')
                        <p class="text-xs text-red-500 font-semibold px-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="password" class="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="size-4 absolute left-4 top-1/2 -translate-y-1/2 text-primary/30"></i>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="w-full bg-white border {{ $errors->has('password') ? 'border-red-300' : 'border-border-subtle' }} rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium"
                               placeholder="••••••••" />
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 font-semibold px-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-primary py-4 flex items-center justify-center gap-2">
                    Masuk <i data-lucide="arrow-right" class="size-5"></i>
                </button>
            </form>

            <div class="mt-10 grid grid-cols-3 gap-3">
                @foreach ($roles as $role)
                    <div class="p-4 bg-white border border-border-subtle rounded-2xl text-center">
                        <i data-lucide="{{ $role['icon'] }}" class="size-5 text-accent mx-auto mb-2"></i>
                        <p class="font-bold text-xs text-primary">{{ $role['label'] }}</p>
                        <p class="text-[10px] text-primary/50 leading-tight mt-1">{{ $role['description'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 pt-8 border-t border-border-subtle text-center">
                <p class="text-sm text-primary/40">
                    Admin juga bisa mengelola data lewat
                    <a href="{{ config('services.arkana_api.admin_panel_url') }}" class="font-bold text-accent hover:underline">Admin Panel</a>.
                    Butuh bantuan akses? Hubungi Admin IT kami.
                </p>
            </div>
        </div>
    </div>

    {{-- Right side: Visual --}}
    <div class="hidden lg:block lg:w-1/2 bg-primary relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070')] bg-cover bg-center opacity-40 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-tr from-primary via-transparent to-transparent"></div>

        <div class="absolute bottom-20 left-20 right-20">
            <div>
                <h2 class="text-4xl font-bold text-white mb-4 italic">"Rumah bukan hanya sekadar tempat tinggal, tapi investasi masa depan."</h2>
                <div class="flex items-center gap-4 text-white/60">
                    <div class="w-12 h-[2px] bg-accent"></div>
                    <span>Arkanaproperty Team</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
