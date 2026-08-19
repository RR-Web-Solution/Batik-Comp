# DEPLOYMENT.md — Deploy Batik Nusantara ke Wasmer Edge

Panduan men-deploy proyek Laravel ini (PHP 8.5, MySQL) ke **Wasmer Edge** (gratis
untuk proyek hobby: ~100k request/bulan, SSL otomatis, managed MySQL bawaan, tanpa
kartu kredit). Sumber resmi: https://docs.wasmer.io/edge/guides/laravel

---

## 1. Prasyarat

- Akun di https://wasmer.io (login dengan GitHub).
- Repo ini sudah di-push ke GitHub.
- CLI Wasmer (opsional, untuk debug/secrets): `curl https://wasmer.sh -sSfL | sh`

## 2. Buat `app.yaml` di root proyek

```yaml
kind: wasmer.io/App.v0
name: batik-nusantara
package: batik-nusantara/batik-nusantara

env:
  APP_ENV: production
  APP_DEBUG: "false"
  APP_URL: "https://batik-nusantara.wasmer.app"

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
- `capabilities.database` → Wasmer membuatkan MySQL ter-manage dan mengisi otomatis
  env `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USERNAME`, `DB_PASSWORD` (Laravel tinggal
  memakainya lewat `.env` config database). Engine default memang `mysql`.
- `locality.regions` harus **satu region yang mendukung database** — cek daftarnya di
  https://docs.wasmer.io/edge/learn/regions (contoh yang dipakai docs: `fr-roub1`).
- `scaling.mode: single_concurrency` wajib untuk PHP (single-threaded).

## 3. Deploy

**Lewat web (paling mudah):**
1. Buka https://wasmer.io/apps → **Deploy** → pilih repo GitHub ini.
2. Wasmer mendeteksi Laravel otomatis (repo berisi `*.php` → install Composer deps,
   entry point `public/index.php`).
3. Aplikasi langsung live di `https://batik-nusantara.wasmer.app`. Setiap `git push`
   berikutnya auto-deploy.

**Alternatif CLI:**
```bash
wasmer login
wasmer deploy          # guided: publish package + buat app
wasmer app secrets create APP_KEY "base64:$(php artisan key:generate --show)"
```

## 4. Env & secrets

- **`APP_KEY` wajib diisi** — generate sekali:
  `php artisan key:generate --show`, lalu set sebagai env/secret (lihat `env:` di
  `app.yaml` atau `wasmer app secrets create APP_KEY "base64:..."`).
- Sebelum deploy, pastikan `.env.example` tidak menyimpan `APP_KEY` produksi.

## 5. Setup database (sekali jalan)

MySQL otomatis sudah ada; tinggal migrasi + seed. Jalankan **sekali** setelah deploy
pertama (Seeder idempotent untuk produk/kategori/setting; `OrderSeeder` membuat order
demo baru — jangan jalankan ulang tanpa perlu):

**Via SSH app** (didokumentasikan Wasmer):
```yaml
capabilities:
  ssh:
    enabled: true
    users:
      - username: <app-shortid>_admin
        authorized_keys:
          - "ssh-rsa AAAA..."
```
lalu `wasmer app ssh <app> -- php artisan migrate --seed --force`.

**Alternatif: job `post-deployment` sekali pakai** — tambahkan ke `app.yaml`, deploy
sekali, lalu hapus:
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

## 6. Update & rollback

- Update = `git push` ke branch yang terhubung (auto-deploy).
- Rollback: Wasmer menyimpan versi app — pilih versi sebelumnya di dashboard
  (https://wasmer.io/apps → app → Versions).

## 7. Batasan yang perlu diketahui

- **Gambar upload admin (`public/uploads`) tidak persisten** — filesystem Edge
  bersifat sementara (hilang saat redeploy/scale-to-zero). Commit gambar awal ke repo,
  atau tambah *volume* (`volumes:` di `app.yaml`) — tapi volume RW-many belum cocok
  untuk kasus kompleks. Untuk demo, upload lewat admin dianggap sementara.
- Database MySQL satu per app; engine tidak bisa diubah tanpa hapus DB.
- PHP single-threaded → `single_concurrency`; jangan harap 1 instance melayani banyak
  request paralel (Edge menskalakan instance otomatis).

## 8. Custom domain (opsional)

Di dashboard app → Domains, tambahkan domain `batik-nusantara.dev` (atau lainnya),
lalu arahkan DNS CNAME ke `batik-nusantara.wasmer.app`. SSL diurus otomatis.

---

Sumber: [Laravel on Wasmer Edge](https://docs.wasmer.io/edge/guides/laravel/) ·
[App Configuration](https://docs.wasmer.io/edge/configuration) · [Jobs](https://docs.wasmer.io/edge/configuration/jobs) ·
[Supported Frameworks](https://docs.wasmer.io/edge/learn/supported-frameworks-and-languages/)