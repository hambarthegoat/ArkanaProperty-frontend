@extends('layouts.base')

@section('title', 'Layanan Tidak Tersedia - ArkanaProperty')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-surface-soft p-8">
    <div class="max-w-md w-full bg-white rounded-[32px] border border-border-subtle shadow-sm p-10 text-center">
        <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i data-lucide="server-off" class="size-8"></i>
        </div>
        <h1 class="text-2xl font-black text-primary mb-3">Data belum bisa dimuat</h1>
        <p class="text-primary/60 mb-8">{{ $message }}</p>
        <div class="flex justify-center gap-3">
            <a href="{{ url()->current() }}" class="btn-primary">Coba Lagi</a>
            <a href="{{ route('home') }}" class="btn-gold-outline">Beranda</a>
        </div>
    </div>
</div>
@endsection
