# DEPLOYMENT.md — Deploy Batik Nusantara ke Wasmer Edge

Panduan men-deploy proyek Laravel ini ke **Wasmer Edge** (https://wasmer.io) — gratis
untuk proyek hobby (~100k request/bulan, SSL otomatis, managed MySQL bawaan, **tanpa kartu
kredit**). Sumber resmi: https://docs.wasmer.io/edge/guides/laravel

---

## 1. Prasyarat

- Akun di https://wasmer.io (login dengan GitHub).
- Repo ini sudah di-push ke GitHub.
- CLI Wasmer (opsional, untuk debug/secrets): `curl https://wasmer.sh -sSfL | sh`

## 2. File `app.yaml` (sudah ada di repo)

```yaml
kind: wasmer.io/App.v0
name: batik-mock
description: Batik Nusantara storefront (Laravel + MySQL) on Wasmer Edge
package: batik-mock/batik-mock

env:
  APP_ENV: production
  APP_DEBUG: "false"
  APP_URL: "https://batik-mock.wasmer.app"

capabilities:
  database:
    engine: mysql

locality:
  regions:
    - ap-singapore

scaling:
  mode: single_concurrency
```

Catatan:
- `capabilities.database` → Wasmer membuatkan MySQL ter-manage dan mengisi otomatis env
  `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USERNAME`, `DB_PASSWORD` (Laravel tinggal
  memakainya).
- `locality.regions` harus region yang mendukung database (contoh docs: `fr-roub1`).
- `scaling.mode: single_concurrency` wajib untuk PHP (single-threaded).

## 3. Persyaratan build (PENTING)

Wasmer membangun app di image **PHP 8.3** dan menjalankan `composer install` (termasuk
dev deps). Cabang `Deploy-Wasmer` sudah disiapkan agar build lolos:

- `config.platform.php` dipatok **8.3.0** di `composer.json`.
- Dev deps diturunkan: `pestphp/pest ^4.0` + `pestphp/pest-plugin-laravel ^4.0`
  (PHPUnit 12.5) — versi yang kompatibel PHP 8.3.
- JANGAN pindahkan dev deps kembali ke Pest 5/PHPUnit 13 (butuh PHP ≥ 8.4 → build gagal
  dengan `Parse error ... Version.php`).

## 4. Deploy

**Lewat web (paling mudah):**
1. Buka https://wasmer.io/apps → **Deploy** → pilih repo GitHub ini **pada branch
   `Deploy-Wasmer`**.
2. Wasmer mendeteksi Laravel otomatis → install Composer deps, entry `public/index.php`.
3. Aplikasi live di `https://batik-mock.wasmer.app`. Setiap `git push` ke branch itu
   auto-deploy.

**Alternatif CLI:**
```bash
wasmer login
wasmer deploy
wasmer app secrets create APP_KEY "base64:$(php artisan key:generate --show)"
```

## 5. Env & secrets

- **`APP_KEY` wajib diisi** — generate sekali: `php artisan key:generate --show`, lalu set
  sebagai secret (`wasmer app secrets create APP_KEY "base64:..."` atau dashboard).
- `APP_ENV`, `APP_DEBUG`, `APP_URL` sudah diisi lewat `env:` di `app.yaml`.

## 6. Setup database (sekali jalan)

MySQL otomatis sudah ada; tinggal migrasi + seed. Jalankan **sekali** setelah deploy
pertama (Seeder idempotent untuk produk/kategori/setting; `OrderSeeder` membuat order demo
baru — jangan jalankan ulang tanpa perlu):

- **Via job `post-deployment` sekali pakai** — tambahkan ke `app.yaml`, deploy sekali, lalu
  hapus:
```yaml
jobs:
  - name: migrate-db
    trigger: post-deployment
    action:
      execute:
        command: php
        cli_args: ["artisan", "migrate", "--seed", "--force"]
        timeout: 5m
```
- **Alternatif SSH app** (jika mengaktifkan `capabilities.ssh`): `wasmer app ssh <app> -- php artisan migrate --seed --force`.

## 7. Update & rollback

- Update = `git push` ke branch terhubung (auto-deploy).
- Rollback: dashboard app → Versions → pilih versi sebelumnya.

## 8. Batasan yang perlu diketahui

- **Gambar upload admin (`public/uploads`) tidak persisten** — filesystem Edge sementara
  (hilang saat redeploy). Commit gambar awal ke repo, atau tambah *volume*. Untuk demo,
  upload lewat admin dianggap sementara.
- Database MySQL satu per app; engine tidak bisa diubah tanpa hapus DB.
- PHP single-threaded → `single_concurrency`; instance diskalakan otomatis.

## 9. Custom domain (opsional)

Dashboard app → Domains → tambahkan domain, arahkan DNS CNAME ke
`batik-mock.wasmer.app`. SSL otomatis.

---

Sumber: [Laravel on Wasmer Edge](https://docs.wasmer.io/edge/guides/laravel/) ·
[App Configuration](https://docs.wasmer.io/edge/configuration) ·
[Jobs](https://docs.wasmer.io/edge/configuration/jobs)
