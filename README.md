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

## Integrasi Backend

Frontend ini **tidak punya database bisnis sendiri**. Semua data (katalog, leads, kavling, laporan, jadwal, portal konsumen) diambil dari **ArkanaProperty-backend** lewat REST API:

- Panggilan API dilakukan **di sisi server** (`App\Services\ArkanaApi`, berbasis `Http::`), sehingga tidak perlu konfigurasi CORS.
- Login (`/login`) memanggil `POST /api/auth/login`; token Sanctum disimpan di **session server** dan tidak pernah dikirim ke browser.
- Halaman panel dilindungi middleware `api.role:<role>` (`admin`, `marketing`, `leads`). Token kedaluwarsa (401) otomatis mengarahkan ke `/login`.
- Error validasi API (422) tampil sebagai error form biasa; API mati ditampilkan sebagai halaman "Data belum bisa dimuat".
- Admin bisa memakai halaman admin di frontend ini **atau** admin panel Filament di backend (`ARKANA_ADMIN_PANEL_URL`).

Kontrak API lengkap ada di repo backend: `docs/arkanaproperty-api.yaml`.

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

Lalu sesuaikan alamat backend di `.env` (default sudah cocok untuk development lokal):

```env
APP_URL=http://127.0.0.1:8001
ARKANA_API_URL=http://127.0.0.1:8000/api
ARKANA_ADMIN_PANEL_URL=http://127.0.0.1:8000/admin
```

Session, cache, dan queue memakai driver `file`/`sync`, jadi frontend tidak memerlukan migrasi database.

### Windows (Command Prompt / PowerShell)
```powershell
composer install
npm install

copy .env.example .env
php artisan key:generate
```

## Menjalankan Project (Development)

Jalankan **backend lebih dulu** di port 8000 (lihat README repo backend: `php artisan migrate --seed` lalu `php artisan serve`). Frontend dijalankan di port **8001**.

Project frontend butuh dua proses berjalan bersamaan: **server Laravel** (merender halaman) dan **Vite** (compile Tailwind CSS + hot-reload).

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

Project ini sudah menyediakan script `composer run dev` yang menjalankan server (port 8001), log viewer (`pail`), dan Vite secara paralel dalam satu terminal:

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
| Login | `/login` | Login admin / marketing / konsumen (username = nomor HP untuk konsumen) |
| Admin | `/admin`, `/admin/leads`, `/admin/kavling`, `/admin/perumahan`, `/admin/reports` | Dashboard administrator |
| Marketing | `/marketing`, `/marketing/calendar`, `/marketing/reports` | Dashboard tim marketing |
| Portal Konsumen | `/portal`, `/portal/reminders`, `/portal/support` | Portal untuk konsumen/pembeli unit |

## Lisensi

Proyek ini dibangun di atas framework [Laravel](https://laravel.com), yang merupakan open-source software dengan lisensi [MIT](https://opensource.org/licenses/MIT).

## Akun Demo

Setelah backend di-seed (`php artisan db:seed` di repo backend):

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `password` |
| Marketing | `dimas` / `santi` | `password` |
| Konsumen | `081234567890` / `089876543210` | `password` |

## Testing

```bash
php artisan test
```

Tes memakai `Http::fake()` untuk mensimulasikan backend, jadi tidak membutuhkan backend yang berjalan.
