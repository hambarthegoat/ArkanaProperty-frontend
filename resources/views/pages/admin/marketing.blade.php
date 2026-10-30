@extends('layouts.dashboard', ['role' => 'admin'])

@section('title', 'Kelola Marketing - ArkanaProperty')

@section('main')
<div class="space-y-8" data-marketing-accounts>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-primary">Kelola Marketing</h1>
            <p class="text-primary/60">Buat akun untuk tim marketing. Mereka masuk memakai username dan password di bawah.</p>
        </div>
        <button type="button" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all" data-toggle-create>
            <i data-lucide="user-plus" class="size-4"></i> Akun Baru
        </button>
    </div>

    <form method="POST" action="{{ route('admin.marketing.store') }}" class="{{ $errors->any() ? '' : 'hidden' }} bg-white rounded-[32px] border border-border-subtle shadow-sm p-8 space-y-6" data-create-form>
        @csrf
        <h3 class="font-black text-primary text-lg">Akun Marketing Baru</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" />
            <input name="no_telp" value="{{ old('no_telp') }}" type="tel" placeholder="Nomor WhatsApp (0812...)" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" />
            <input name="username" value="{{ old('username') }}" required autocomplete="off" placeholder="Username" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" />
            <input name="password" type="password" required minlength="6" autocomplete="new-password" placeholder="Password (minimal 6 karakter)" class="bg-surface-soft rounded-xl p-3 font-semibold outline-none focus:ring-2 focus:ring-accent" />
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" class="btn-gold-outline" data-toggle-create>Batal</button>
            <button type="submit" class="btn-primary">Simpan Akun</button>
        </div>
    </form>

    <div class="bg-white rounded-[32px] border border-border-subtle shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-surface-soft border-b border-border-subtle">
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Nama</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Username</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">No. WhatsApp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle">
                    @forelse ($accounts as $akun)
                        <tr class="hover:bg-surface-soft/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-primary">{{ $akun['nama'] ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-primary/70">{{ $akun['username'] }}</td>
                            <td class="px-6 py-4 text-sm text-primary/70">{{ $akun['no_telp'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-primary/40">Belum ada akun marketing.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-border-subtle bg-surface-soft/30">
            <p class="text-xs text-primary/40 font-medium">{{ count($accounts) }} akun marketing</p>
        </div>
    </div>
</div>

<script>
    (function () {
        var root = document.querySelector('[data-marketing-accounts]');
        if (!root) return;
        var form = root.querySelector('[data-create-form]');
        root.querySelectorAll('[data-toggle-create]').forEach(function (btn) {
            btn.addEventListener('click', function () { form.classList.toggle('hidden'); });
        });
    })();
</script>
@endsection
