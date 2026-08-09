# MOVE.MD — Cara Pindah ke Host/Server Baru

Panduan langkah demi langkah untuk menjalankan proyek ini di host baru
(mesin lokal baru, VPS, atau server lain). Ikuti urutannya dari atas ke bawah.

> Proyek ini menggunakan **Laravel Sail** (Docker) dengan `compose.yaml`,
> jadi pastikan host baru sudah punya **Docker** dan **Composer** sebelum mulai.

---

## 1. Instal Prasyarat di Host Baru

### Docker & Docker Compose

- **Ubuntu/Debian**

  ```bash
  curl -fsSL https://get.docker.com | sh
  sudo usermod -aG docker $USER
  newgrp docker
  ```

- **Windows** — install [Docker Desktop](https://www.docker.com/products/docker-desktop/).
- **macOS** — install [Docker Desktop](https://www.docker.com/products/docker-desktop/).

### PHP + Composer

PHP hanya dibutuhkan di host untuk menjalankan Composer (kode aplikasi
berjalan di dalam container Sail).

- **Ubuntu/Debian**

  ```bash
  sudo apt update
  sudo apt install -y php-cli php-mbstring php-xml php-curl unzip git
  curl -sS https://getcomposer.org/installer | php
  sudo mv composer.phar /usr/local/bin/composer
  ```

- **Windows/macOS** — install Composer dari [getcomposer.org](https://getcomposer.org/download/).

Verifikasi instalasi:

```bash
docker --version
docker compose version
composer --version
```

---

## 2. Clone / Salin Kode ke Host Baru

```bash
git clone <url-repo-anda> project-name
cd project-name
```

> `.env`, `vendor/`, dan `node_modules/` tidak ikut di-git.
> Semuanya akan dibuat ulang di langkah berikutnya.

---

## 3. Instal Dependensi

```bash
composer install --no-interaction
```

> Jika `laravel/sail` sudah ada di `composer.json`, Sail akan tersedia
> di `vendor/bin/sail` setelah langkah ini. `compose.yaml` sudah ada di repo,
> jadi **tidak perlu** menjalankan `php artisan sail:install` lagi.

Instal dependensi frontend (untuk Vite / Tailwind):

```bash
npm install
```

---

## 4. Siapkan File `.env`

`composer install` (atau file `.env.example`) sudah menyediakan template:

```bash
cp .env.example .env
```

Setelah menyalin, sesuaikan minimal nilai berikut di `.env`:

```dotenv
APP_NAME=Laravel
APP_ENV=local
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

> Penting: `DB_HOST` harus `mysql` (nama service di `compose.yaml`),
> **bukan** `127.0.0.1` — database jalan di dalam container Sail.

Generate aplikasi key:

```bash
php artisan key:generate
```

> Bisa juga dijalankan di dalam container: `./vendor/bin/sail artisan key:generate`.

---

## 5. Jalankan Container Sail

```bash
./vendor/bin/sail up -d
```

Perintah ini membangun image, lalu menjalankan:

- **laravel.test** — aplikasi (port `APP_PORT`, default `80`)
- **mysql** — database (port `FORWARD_DB_PORT`, default `3306`)
- **phpmyadmin** — di port `8080`

Cek status container:

```bash
./vendor/bin/sail ps
```

> Selanjutnya, semua perintah `php artisan` dijalankan lewat Sail:
> `./vendor/bin/sail artisan <perintah>`.

---

## 6. Migrasi + Seeder

```bash
./vendor/bin/sail artisan migrate --seed --no-interaction
```

`--seed` akan menjalankan `DatabaseSeeder` yang membuat:

- User admin: **admin** / admin@gmail.com / **123123123**
- 15 produk batik (`ProductSeeder`)

Jika sudah pernah migrate dan hanya ingin mengisi data:

```bash
./vendor/bin/sail artisan db:seed --no-interaction
```

---

## 7. Build Aset Frontend

```bash
npm run build
```

> Untuk pengembangan, ganti dengan `npm run dev` (atau
> `./vendor/bin/sail npm run dev`).

Jika halaman error **"Unable to locate file in Vite manifest"**, jalankan
`npm run build` dulu.

---

## 8. Storage Link (Opsional tapi Disarankan)

```bash
./vendor/bin/sail artisan storage:link
```

> Diperlukan jika aplikasi menampilkan file yang di-upload dari `storage/`.

---

## 9. Cek Aplikasi

- Halaman utama: `http://localhost`
- Halaman produk: `http://localhost/product`
- Login admin: `http://localhost/login`
- phpMyAdmin: `http://localhost:8080`

Cek log jika ada masalah:

```bash
./vendor/bin/sail logs -f
```

---

## Ringkasan Perintah Cepat

```bash
git clone <url-repo-anda> project-name
cd project-name

composer install --no-interaction
npm install

cp .env.example .env
php artisan key:generate

./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed --no-interaction
npm run build
./vendor/bin/sail artisan storage:link
```

---

## Troubleshooting Umum

| Masalah | Solusi |
| --- | --- |
| `getaddrinfo for mysql failed` | Pastikan `DB_HOST=mysql` di `.env`, lalu `./vendor/bin/sail up -d` |
| Port 80/3306/8080 dipakai | Ubah `APP_PORT` / `FORWARD_DB_PORT` / port phpmyadmin di `compose.yaml` |
| `Duplicate entry ... users_email_unique` | User admin sudah ada; jalankan `./vendor/bin/sail artisan db:seed --class=ProductSeeder` saja |
| Container tidak build | `./vendor/bin/sail build --no-cache` |
| Lupa key aplikasi | `./vendor/bin/sail artisan key:generate` |
