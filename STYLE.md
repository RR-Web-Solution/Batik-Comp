# STYLE.md — Panduan `public/css/style.css`

Dokumen ini menjelaskan setiap aturan di `public/css/style.css`, elemen apa yang
dipengaruhinya, dan di file/view mana saja aturan tersebut dipakai.

> `style.css` adalah **satu-satunya stylesheet custom** proyek ini. Semua layout,
> grid, dan komponen dasar (navbar, modal, table, dropdown) sudah ditangani oleh
> **Bootstrap 5.3** yang dimuat lewat CDN di setiap halaman. `style.css` hanya
> berisi **tema warna + font + beberapa utilitas kecil** di atas Bootstrap.
>
> Pengecualian: `resources/views/welcome.blade.php` tidak memakai `style.css` —
> halaman itu memakai Vite/Tailwind via `@vite`.

---

## 1. Cara Load

Setiap halaman (kecuali `welcome`) memuat file ini pada `<head>`:

```blade
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
```

Halaman yang memuat `style.css`:

| View | Route / Path |
|------|--------------|
| `resources/views/home/index.blade.php` | `/` (halaman utama) |
| `resources/views/product/index.blade.php` | `/products` (katalog produk) |
| `resources/views/admin/index.blade.php` | `/admin` (login admin) |
| `resources/views/admin/dashboard.blade.php` | `/dashboard` |
| `resources/views/admin/product.blade.php` | `/product` (kelola produk) |
| `resources/views/admin/user.blade.php` | `/user` (kelola user) |

---

## 2. Design Tokens (`:root`)

Variabel CSS yang mendefinisikan palet warna dan font. Nilai diubah di **satu
tempat saja** — semua class memakainya lewat `var(--...)`.

| Variabel | Nilai | Dipakai untuk |
|----------|-------|---------------|
| `--primary-color` | `#32170d` | Warna cokelat gelap utama (teks, tombol, border focus) |
| `--primary-container` | `#4b2c20` | Hover tombol |
| `--on-primary` | `#ffffff` | Teks di atas tombol |
| `--bg-color` | `#fbf9f7` | Latar belakang halaman / `body` |
| `--on-background` | `#1b1c1b` | Warna teks utama (`body`) |
| `--text-muted` | `#504440` | Warna teks sekunder/abu |
| `--border-color` | `#d5c3bd` | Warna garis/border semua komponen |
| `--surface-low` | `#f5f3f1` | Latar kartu/footer sedikit lebih gelap |
| `--surface-lowest` | `#ffffff` | Latar paling terang (putih) |
| `--tertiary-fixed` | `#fcdccd` | Latar kotak ikon (icon-box) |
| `--hover-bg` | `#e4e2e0` | Latar saat hover menu admin |
| `--bb-surface` | `= --bg-color` | **Alias** untuk inline-style di `admin/index.blade.php` |
| `--bb-on-surface-variant` | `= --text-muted` | **Alias** untuk inline-style di `admin/index.blade.php` |
| `--font-heading` | `"Source Serif 4", serif` | Font judul/heading |
| `--font-body` | `"Work Sans", sans-serif` | Font isi/paragraf |

### Variabel yang dipakai langsung via inline `style=""` di view

Jangan dihapus — dipakai langsung di dalam atribut HTML (bukan lewat class):

| Variabel | Lokasi pemakaian inline |
|----------|-------------------------|
| `--primary-color` | `admin/product.blade.php:105,181,224` · `admin/user.blade.php:105,181,223` (tombol Simpan / Tambah) |
| `--bg-color` | `admin/product.blade.php:151,194` · `admin/user.blade.php:151,193` (latar modal) |
| `--border-color` | `admin/product.blade.php:151,164,170,175,194,207,213,218` · `admin/user.blade.php` (sama, input & modal) |
| `--bb-surface` | `admin/index.blade.php:94` (header) |
| `--bb-on-surface-variant` | `admin/index.blade.php:111,135` (teks paragraf login & footer) |

---

## 3. Base

```css
body {
    background-color: var(--bg-color);
    color: var(--on-background);
    font-family: var(--font-body);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
```
Latar krem, teks gelap, font Work Sans, dan layout kolom agar **footer bisa
menempel di bawah** (dipadukan `flex-grow-1`/`mt-auto` di view).

```css
h1..h6, .navbar-brand, .display-font, .font-heading, .font-headline {
    font-family: var(--font-heading);
}
```
Semua judul + brand memakai font serif `Source Serif 4`.
- `.font-heading` → `admin/dashboard`, `admin/product`, `admin/user`
- `.font-headline` → `admin/index`, `product/index`

---

## 4. Typography

| Class | Properti | Dipakai di |
|-------|----------|------------|
| `.display-lg` | `32px` / bold | `product/index.blade.php:206` (judul "Our Collections") |
| `.headline-md` | `32px` / semi-bold | `product/index.blade.php:194` (nama brand di navbar) |
| `.headline-sm` | `24px` / semi-bold | `product/index.blade.php:218,221,241` (nama & harga produk) |
| `.body-lg` | `18px` | `product/index.blade.php:207` (tagline) |
| `.label-caps` | `12px`, uppercase, letter-spacing | `home/index.blade.php:349` (copyright) · `admin/index.blade.php:116,121,125` (label form & tombol) · `product/index.blade.php:225` (tombol Buy Now) |

---

## 5. Color Utilities

| Class | Efek | Dipakai di |
|-------|------|------------|
| `.text-primary-custom` | teks cokelat gelap | `home/index`, `product/index`, `admin/dashboard`, `admin/product`, `admin/user` |
| `.text-primary-brand` | sama dengan di atas (digabung) | `admin/index.blade.php:95,110` |
| `.text-muted-custom` | teks abu sekunder | `product/index`, `admin/dashboard`, `admin/product`, `admin/user` |
| `.text-secondary-custom` | sama dengan di atas (digabung) | `home/index.blade.php` (banyak paragraf) |
| `.bg-surface` | latar krem | `admin/index.blade.php:93` (header) |
| `.bg-surface-low` | latar krem gelap | `home/index.blade.php:275,325,331,336,347` · `product/index.blade.php:237` |
| `.bg-surface-lowest` | latar putih | `home/index.blade.php:184,227,250,260,279,296` · `product/index.blade.php:215` |
| `.bg-surface-container-lowest` | sama dengan di atas (digabung) | `admin/index.blade.php:102` |
| `.footer-bg` | latar krem gelap untuk footer | `admin/index.blade.php:134` |
| `.border-secondary-container` | garis cokelat muda | `admin/index.blade.php:93,102,106,117,122,134` |
| `.border-outline-variant` | sama dengan di atas (digabung) | `home/index.blade.php` (semua kartu & header) |
| `.ambient-shadow` | bayangan lembut | `home/index.blade.php:198,219,227,250,260,296` |

> `border-secondary-container` dan `border-outline-variant` adalah **dua nama
> untuk satu warna** (`--border-color`). Mengubah warna cukup di `--border-color`.

---

## 6. Header / Navigation

```css
.header-custom, .navbar-custom { border-bottom: 1px solid var(--border-color); }
.navbar-custom { background-color: var(--bg-color); }
```
- `.header-custom` → border bawah header admin: `admin/dashboard`, `admin/product`, `admin/user`
- `.navbar-custom` → navbar katalog: `product/index.blade.php:187` (perlu latar agar `sticky-top` tidak transparan)

```css
.nav-link-custom { color, font kecil uppercase, tanpa underline }
.nav-link-custom:hover { background var(--hover-bg), warna gelap }
```
Menu navigasi admin (Produk / User / Logout): `admin/dashboard:85,89,93`, `admin/product`, `admin/user`.

---

## 7. Buttons & Forms

```css
.btn-primary-custom, .btn-primary-brand { background gelap, teks putih, uppercase }
:hover → background lebih terang (--primary-container)
```
Dua nama untuk satu gaya tombol:
- `.btn-primary-custom` → `home/index.blade.php:214,339` (Lihat Koleksi, Kirim Pesan) · `product/index.blade.php:225` (Buy Now)
- `.btn-primary-brand` → `admin/index.blade.php:125` (Masuk Ke Admin)

```css
.form-control:focus { border cokelat + ring focus }
```
Berasal dari Bootstrap `.form-control`, gaya custom hanya untuk fokus input:
- `admin/index.blade.php:117,122` (input email & password login)
- `home/index.blade.php:325,331,336` (form kontak)

---

## 8. Components

### `.product-card`
Kartu produk di katalog. Border, radius, bayangan, tinggi penuh, layout kolom.
Hover → bayangan sedikit lebih kuat (tanpa animasi/zoom agar minimal).
- `product/index.blade.php:215` · (nama class juga di `home/index` sebagai sisa HTML, tidak aktif di markup)

### `.icon-box`
Kotak ikon 48×48 dengan latar `--tertiary-fixed` dan ikon cokelat.
- `home/index.blade.php:251,261,304,309,314` (Visi, Misi, ikon kontak)

### `.footer-link`
Tautan footer berwarna abu dengan underline; hover menjadi cokelat.
- `home/index.blade.php:352,353,354` (Kebijakan, Syarat, Kemitraan)
- `product/index.blade.php:247,250,253,256` (Sourcing, Guides, Wholesale, Privacy)

---

## 9. Catatan Penting

1. **Class yang tersisa di view tapi tidak dipakai** — jangan bingung kalau
   `grep` menemukan class tertentu dalam blok komentar `{{-- ... --}}` di dalam
   view. Blok itu adalah **CSS lama yang nonaktif** (masih memakai variabel
   `--bb-*` / `--bs-*` versi dulu) dan tidak memengaruhi tampilan. Contoh:
   `product-img-wrapper`, `badge-flavor`, `bg-surface-high`, `bg-secondary-container`.

2. **Class yang sudah dihapus dari `style.css`** saat penyederhanaan (tidak
   dipakai oleh markup aktif mana pun):
   - `product-img-wrapper`, `product-img`, `product-card:hover .product-img` (zoom)
   - `badge-flavor`, `bg-surface-high`, `bg-secondary-container`
   - `.display-font` tetap dipertahankan di rule font (aman, tidak dipakai)
   - Semua transisi/animasi (`transition`, `transform`) dihapus — tidak ada efek ekstra.

3. **Aturan `.dropdown-toggle::after`** untuk menghilangkan panah dropdown di
   navbar halaman utama didefinisikan sebagai `<style>` inline di
   `home/index.blade.php:174-178`, bukan di `style.css`.

4. **Menambah warna baru** → cukup tambah variabel di `:root` lalu pakai
   `var(--nama)`. Semua halaman otomatis ikut karena memakai file yang sama.

5. Jika perubahan CSS tidak terlihat di browser, pastikan tidak ada cache —
   atau jalankan `npm run dev` / `npm run build` bila ada bagian yang memakai Vite.
