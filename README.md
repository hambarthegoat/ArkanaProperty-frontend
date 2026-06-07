# ArkanaProperty

Aplikasi web ArkanaProperty — landing page properti, panel admin, panel marketing, dan portal konsumen — dibangun dengan **Laravel + Blade (server-rendered HTML)** dan **Tailwind CSS v4**.

UI direplikasi 1:1 dari prototipe desain di folder `example/` (React/Vite), namun diimplementasikan murni dengan Blade/HTML + vanilla JS — tanpa React, Inertia, atau Vue.

## Tech Stack

- PHP `^8.3`
- Laravel `^13`
- Blade templates (server-side rendering)
- Tailwind CSS v4 (via `@tailwindcss/vite`)
- Vite (compiler aset CSS/JS, hot-reload saat development)
- Vanilla JS (interaktivitas: toggle form, filter katalog, kalender, dll.)

> Catatan: saat ini seluruh data (leads, kavling, laporan, jadwal, timeline konsumen, dll.) masih berupa data statis yang di-hardcode di setiap Blade view — belum terhubung ke database. Bagian backend (auth, model, migration, dsb.) akan ditambahkan menyusul.

## Requirement

- PHP 8.3 atau lebih baru beserta ekstensi standar Laravel (`mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`)
- Composer
- Node.js (disarankan versi LTS terbaru) beserta npm

## Instalasi

Clone/masuk ke folder project, lalu jalankan:

### Linux / macOS
```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

### Windows (Command Prompt / PowerShell)
```powershell
composer install
npm install

copy .env.example .env
php artisan key:generate
```

## Menjalankan Project (Development)

Project butuh dua proses berjalan bersamaan: **server Laravel** (merender halaman) dan **Vite** (compile Tailwind CSS + hot-reload).

### Cara 1 — Jalankan satu per satu (direkomendasikan untuk debugging)

Buka dua terminal:

**Terminal 1 — Server Laravel**
```bash
php artisan serve
```
Aplikasi akan tersedia di `http://127.0.0.1:8000` (gunakan `php artisan serve --port=8001` jika port 8000 sudah dipakai).

**Terminal 2 — Vite (compile Tailwind CSS)**
```bash
npm run dev
```

Perintah di atas sama persis untuk Linux maupun Windows — tidak ada perbedaan.

### Cara 2 — Jalankan sekaligus dengan satu command

Project ini sudah menyediakan script `composer run dev` yang menjalankan server, queue listener, log viewer (`pail`), dan Vite secara paralel dalam satu terminal:

```bash
composer run dev
```

Berlaku sama untuk Linux maupun Windows (dijalankan lewat `npx concurrently`, jadi tidak bergantung pada shell tertentu). Tekan `Ctrl + C` untuk menghentikan semua proses sekaligus.

## Build untuk Production

```bash
npm run build
```
Akan menghasilkan aset CSS/JS terkompilasi & ter-minify di `public/build`, siap untuk di-deploy.

## Perintah Artisan yang Berguna

```bash
php artisan route:list        # menampilkan semua route terdaftar
php artisan view:clear        # membersihkan cache compiled Blade (perlu setelah error edit .blade.php)
php artisan config:clear      # membersihkan cache config (setelah mengubah .env)
php artisan optimize:clear    # membersihkan semua cache sekaligus
```

## Struktur Halaman

| Area | Route | Deskripsi |
|---|---|---|
| Landing | `/` | Halaman utama: hero, katalog properti, testimoni |
| Detail Properti | `/property/{id}` | Detail unit & form konsultasi |
| Login | `/login` | Halaman masuk |
| Admin | `/admin`, `/admin/leads`, `/admin/kavling`, `/admin/perumahan`, `/admin/reports` | Dashboard administrator |
| Marketing | `/marketing`, `/marketing/calendar`, `/marketing/reports` | Dashboard tim marketing |
| Portal Konsumen | `/portal`, `/portal/reminders`, `/portal/support` | Portal untuk konsumen/pembeli unit |

## Lisensi

Proyek ini dibangun di atas framework [Laravel](https://laravel.com), yang merupakan open-source software dengan lisensi [MIT](https://opensource.org/licenses/MIT).
