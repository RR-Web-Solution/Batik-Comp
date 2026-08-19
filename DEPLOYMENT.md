# DEPLOYMENT.md — Deploy Batik Nusantara ke Railway

Panduan men-deploy proyek Laravel ini ke **Railway** (https://railway.com) — platform
usage-based yang mendeteksi Laravel otomatis (Railpack → php-fpm + Caddy) dan punya
plugin MySQL/Postgres. Gratis dicoba **tanpa kartu kredit** (trial $5 / 30 hari); lanjut
pakai = usage-based (lihat §8). Sumber resmi:
https://docs.railway.com/guides/laravel

---

## 1. Prasyarat

- Akun di https://railway.com (login dengan GitHub).
- Repo ini sudah di-push ke GitHub (`github.com/rndyv9/Coffee-Comp-Mock`).
- Aplikasi butuh PHP `^8.3` (Railpack otomatis menyediakan runtime PHP modern).

## 2. Deploy dari GitHub (cara paling mudah)

1. **New Project** → **Deploy from GitHub repo**.
2. Hubungkan akun GitHub jika belum, pilih repo `Coffee-Comp-Mock`.
3. Klik **Add Variables** → isi minimal `APP_KEY` (lihat §3).
4. Klik **Deploy**.

Railway otomatis mendeteksi Laravel (file `artisan` + `composer.json`) dan menjalankannya
via **php-fpm + Caddy** — tanpa Dockerfile. `composer install` dijalankan otomatis.

> Catatan: Railway **tidak mendukung Docker Compose** — jangan pakai `docker-compose.yml`
> / Laravel Sail untuk deploy.

**Alternatif CLI:**
```bash
railway init        # dari root proyek
railway up
```

## 3. Environment variables

Di service → **Variables**, set minimal:

| Variable | Nilai |
| --- | --- |
| `APP_KEY` | Output dari `php artisan key:generate --show` (wajib) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | URL domain Railway (lihat §6) |
| `DB_CONNECTION` | `mysql` (default Laravel `sqlite` — wajib diganti) |
| `DB_URL` | `${{MySQL.DATABASE_URL}}` (referensi plugin DB, lihat §4) |

## 4. Database (MySQL plugin)

1. Di Project Canvas → **New** → pilih **MySQL** plugin.
2. Referensi koneksi ke service app: atur `DB_URL` = `${{MySQL.DATABASE_URL}}` (Laravel
   membaca `DB_URL` untuk koneksi MySQL, lihat `config/database.php`).
   - Jika `DATABASE_URL` tidak tersedia di plugin MySQL, isi manual `DB_HOST`,
     `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` dari variabel plugin.
3. Variabel diberi prefix nama plugin (`${{MySQL.<var>}}`), aman digunakan antar service.

## 5. Migrasi & seed (sekali setup)

Buat script `railway/init-app.sh` di repo, lalu daftarkan sebagai **Pre-Deploy Command**:

```bash
#!/bin/bash
set -e

php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
```

- **Build section** → **Custom Build Command**: `composer install --no-dev && npm run build`
  (opsional; app ini tidak memakai Vite, cukup `composer install --no-dev`).
- **Deploy section** → **Pre-Deploy Command**: `chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh`
- Untuk **seed sekali** (data demo + user admin `admin@gmail.com` / `123123123`):
  jalankan `php artisan migrate --seed --force` satu kali (mis. lewat Pre-Deploy Command
  sementara), lalu kembalikan ke `php artisan migrate --force`.
  (Seeder idempotent; `OrderSeeder` membuat order demo baru tiap jalan.)

## 6. Networking

Service app tidak publik secara default. Di service → **Settings** → **Networking** →
**Generate Domain** untuk mendapatkan URL `https://<nama>.up.railway.app`. Set `APP_URL`
sesuai domain tersebut (atau custom domain yang dipetakan).

## 7. Update & rollback

- **Update** = `git push` ke branch yang terhubung → Railway auto-deploy.
- **Rollback** = tab **Deployments** di service → pilih deployment sebelumnya → **Deploy**.

## 8. Biaya & catatan

- **Free Trial**: $5 kredit / 30 hari, **tanpa kartu kredit**. Ada juga **Free plan**
  ($0/bulan, $1 kredit usage/bulan) — sangat ketat untuk Laravel + MySQL.
- **Hobby**: $5/bulan (termasuk $5 usage) — realistis untuk proyek ini.
  Railway usage-based: bayar sesuai CPU/RAM/egress yang dipakai (trial $5 habis → berhenti
  jika tidak upgrade).
- **Upload admin (`public/uploads`) tidak persisten** antar redeploy kecuali pasang
  **Volume** (Service → Settings → Volumes → mount ke path `public/uploads` di direktori
  app). Untuk demo, cukup commit gambar ke repo.
- Jika build mengeluh **missing PHP extension** (mis. `gd`, `exif`, `zip`), set env
  `RAILPACK_PHP_EXTENSIONS=zip,gd,exif` (sesuaikan kebutuhan).
- Bila perlu pin versi PHP (mis. 8.4), tambahkan file `.railpack/config.toml` dengan
  `[php] version = "8.4"`.

---

Sumber: [Railway Laravel Guide](https://docs.railway.com/guides/laravel) ·
[Railpack PHP](https://railpack.com/languages/php) ·
[Railway Pricing](https://railway.com/pricing) ·
[Railway MySQL Plugin](https://docs.railway.com/databases/mysql)