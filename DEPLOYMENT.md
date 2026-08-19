# DEPLOYMENT.md — Deploy Batik Nusantara ke Laravel Cloud

Panduan men-deploy proyek Laravel ini ke **Laravel Cloud** (https://cloud.laravel.com) —
platform resmi dari tim Laravel: auto-deploy tiap `git push`, SSL otomatis, managed
MySQL/Postgres, tanpa perlu khawatir build image. Sumber resmi:
https://laravel.com/cloud/docs/quickstart

---

## 1. Prasyarat

- Akun di https://cloud.laravel.com (login dengan GitHub).
- Repo ini sudah di-push ke GitHub (`github.com/rndyv9/Coffee-Comp-Mock`).
- Versi PHP aplikasi: `^8.3` (local PHP 8.4). Laravel Cloud mendukung PHP 8.2+.

## 2. Buat aplikasi dari repo yang sudah ada

1. Buka https://cloud.laravel.com → **New application** → **From existing repository**.
2. Hubungkan akun GitHub (Laravel Cloud App → pilih akses ke repo ini).
3. Pilih repo `Coffee-Comp-Mock`, beri nama aplikasi (mis. `batik-nusantara`), pilih
   **Region**, lalu **Create Application**.
4. Aplikasi dibuat dengan environment default (`production`).

## 3. Konfigurasi environment (dashboard)

Buka environment **production** → tab **Settings**:

- **Runtime:** `PHP`, pilih versi PHP (sesuai kebutuhan; `^8.3` aplikasi ini OK di 8.3).
- **Build command:**
  ```sh
  composer install --no-dev
  ```
  (Aplikasi tidak memakai `@vite`/Vite di view — Bootstrap via CDN — jadi `npm run build`
  tidak wajib. Tambahkan `&& npm run build` jika nanti mulai memakai Vite.)
- **Deploy command** (migrasi otomatis tiap deploy):
  ```sh
  php artisan migrate --force
  ```

Catatan: `composer install --no-dev` membuat dev dependencies (Pest/PHPUnit) **tidak**
ikut terpasang di produksi — tidak ada isu versi PHP untuk tooling.

## 4. Environment variables

Di dashboard environment → tab **Variables**, set minimal:

- **`APP_KEY`** (wajib) — generate sekali di lokal:
  ```sh
  php artisan key:generate --show
  ```
  lalu paste nilainya ke dashboard.
- `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` sesuai URL aplikasi
  (dari dashboard, otomatis terisi).

## 5. Database (managed)

1. Di **infrastructure canvas** environment, klik **Create and connect a database** →
   **Create new database cluster** → pilih **MySQL** (atau Postgres).
2. Laravel Cloud otomatis meng-inject env `DB_HOST`, `DB_PORT`, `DB_DATABASE`,
   `DB_USERNAME`, `DB_PASSWORD` — tidak perlu set manual.
3. Selesai deploy pertama, jalankan seeder **sekali** untuk data demo (produk/kategori/
   setting + user admin `admin@gmail.com` / `123123123`). Karena `php artisan migrate --force`
   sudah otomatis, seed bisa dijalankan via **Deploy command** sekali pakai:
   ```sh
   php artisan migrate --force --seed
   ```
   lalu kembalikan ke `php artisan migrate --force` untuk deploy berikutnya.
   (Seeder idempotent; `OrderSeeder` membuat order demo baru tiap jalan — jangan ulang
   tanpa perlu.)

## 6. Deploy & update

- Klik **Deploy** → Laravel Cloud build, jalankan deploy command, dan langsung live di URL
  `https://<nama-app>.laravel.cloud` (dapat diganti custom domain di tab Domains).
- **Update** = `git push` ke branch yang terhubung (auto-deploy otomatis).
- **Rollback**: dashboard environment → Deployment history → pilih versi sebelumnya.

## 7. Catatan yang perlu diketahui

- **Gambar upload admin (`public/uploads`) tidak persisten** — filesystem instance
  bersifat sementara (hilang saat redeploy). Untuk demo cukup commit gambar ke repo, atau
  gunakan object storage (S3-compatible) via `cloud:files` bila nanti perlu upload nyata.
- Session/cache default (file) aman untuk skala kecil; gunakan Redis/DB driver bila perlu.

---

Sumber: [Laravel Cloud Quickstart](https://laravel.com/cloud/docs/quickstart) ·
[Databases (MySQL)](https://laravel.com/cloud/docs/resources/databases/laravel-mysql) ·
[CLI (cloud deploy)](https://cloud.laravel.com/docs/api/cli)