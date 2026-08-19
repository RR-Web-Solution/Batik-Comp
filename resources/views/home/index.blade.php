<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Batik Nusantara - Company Profile</title>
    <!-- Bootstrap 5.3 CSS -->
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" rel="stylesheet" />
    <!-- Font Awesome -->
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@400;600;700&amp;family=Work+Sans:wght@400;600&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .dropdown-toggle::after {
            display: none !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="padding-top: 64px;">
    <!-- Navbar -->
    <header class="bg-surface-lowest border-bottom border-outline-variant fixed-top">
        <div class="container-xl d-flex justify-content-between align-items-center" style="height: 64px;">
            <a class="navbar-brand d-flex align-items-center gap-2 text-primary-custom fw-bold fs-4 m-0 text-decoration-none"
                href="{{ route('home') }}">
                <img alt="Batik Nusantara Logo"
                        src="{{ asset('images/logo.jpg') }}"
                    style="height: 32px; width: auto; object-fit: contain;" />
                <span class="font-headline headline-md text-primary-custom mb-0">Batik Nusantara</span>
            </a>
            <div class="dropdown">
                <button aria-expanded="false"
                    class="btn btn-link text-primary-custom p-2 border-0 fs-5 dropdown-toggle text-decoration-none"
                    data-bs-toggle="dropdown" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end ambient-shadow border-outline-variant">
                    <li><a class="dropdown-item text-primary-custom fw-semibold"
                            href="{{ route('product.index') }}">Produk</a></li>
                    <li><a class="dropdown-item text-primary-custom fw-semibold"
                            href="{{ url('/admin') }}"><i class="fa-solid fa-right-to-bracket me-2"></i>Login Admin</a></li>
                </ul>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="d-flex flex-column gap-5 mb-5">
        <!-- Hero Section -->
        <section class="container-xl mt-4 px-5">
            <div class="row align-items-center g-4 flex-column-reverse flex-md-row">
                <div class="col-12 col-md-6 text-center text-md-start">
                    <h1 class="display-4 fw-bold text-primary-custom mb-3">Seni Membatik yang Sempurna</h1>
                    <p class="fs-5 text-secondary-custom mb-4">Mendedikasikan diri untuk menghadirkan pengalaman batik
                        terbaik dari kain pilihan hingga ke tangan Anda. Nikmati keindahan dalam setiap corak.</p>
                    <a class="btn btn-primary-custom py-2 px-4" href="{{ route('product.index') }}">
                        Lihat Koleksi Kami
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <img alt="Proses Membatik" class="img-fluid rounded-4 ambient-shadow w-100 object-fit-cover"
                        src="{{ asset('images/hero.jpg') }}"
                        style="aspect-ratio: 4/3;" />
                </div>
            </div>
        </section>
        <!-- About Section -->
        <section class="container-xl" id="tentang">
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-lg-5 text-center">
                        <img alt="Batik Nusantara Logo" class="img-fluid"
                    src="{{ asset('images/logo.jpg') }}"
                            style="max-width: 250px;" />
                    </div>
                    <div class="col-12 col-lg-7">
                        <h2 class="fw-bold text-primary-custom mb-3">Tentang Perusahaan</h2>
                        <p class="text-secondary-custom mb-0">Batik Nusantara berawal dari kecintaan sederhana terhadap
                            warisan budaya Indonesia. Berdiri sejak tahun 2018, kami telah berkembang dari sebuah
                            rumah produksi kecil menjadi rumah batik artisanal yang dipercaya oleh para pecinta batik.
                            Warisan kami dibangun di atas dedikasi terhadap kualitas, hubungan langsung dengan para
                            pengrajin, dan komitmen untuk mengeksplorasi potensi penuh dari setiap motif batik.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Categories -->
        <section class="container-xl" id="kategori">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary-custom mb-2">Koleksi Kategori</h2>
                <p class="text-secondary-custom mb-0">Pilih kategori favorit Anda untuk melihat koleksi batik pilihan.</p>
            </div>
            <div class="row g-4">
                @foreach ($categories as $category)
                    <div class="col-12 col-md-6 col-lg-3">
                        <a class="text-decoration-none d-block h-100" href="{{ route('category.show', $category->slug) }}">
                            <div
                                class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                                <div class="icon-box"><i class="fa-solid fa-layer-group fs-4"></i></div>
                                <div>
                                    <h3 class="font-headline headline-sm text-primary-custom mb-1">{{ $category->name }}</h3>
                                    <p class="text-secondary-custom mb-2">{{ $category->description }}</p>
                                    <span class="label-caps text-primary-custom">{{ $category->products_count }} Produk</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- Featured Products -->
        <section class="container-xl" id="produk-pilihan">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary-custom mb-2">Produk Pilihan</h2>
                <p class="text-secondary-custom mb-0">Beberapa batik terbaik kami yang paling banyak diminati.</p>
            </div>
            <div class="row g-4">
                @foreach ($featuredProducts as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card product-card bg-surface-lowest">
                            @if ($product->image)
                                <img src="{{ asset('uploads/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fa-solid fa-image fa-3x text-white-50"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                    <h2 class="font-headline headline-sm text-primary-custom mb-0">
                                        {{ $product->name }}
                                    </h2>
                                    <span class="font-headline headline-sm text-muted-custom text-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="card-text text-muted-custom mb-4 flex-grow-1">{{ $product->description }}</p>
                                <button
                                    class="btn btn-primary-custom w-100 label-caps py-2 d-flex justify-content-center align-items-center gap-2"
                                    data-bs-toggle="modal" data-bs-target="#orderModal"
                                    data-product-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    Pesan
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- Vision & Mission -->
        <section class="container-xl">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div
                        class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                        <div class="icon-box"><i class="fa-solid fa-eye fs-4"></i></div>
                        <h3 class="fs-4 fw-bold text-primary-custom mb-0">Visi</h3>
                        <p class="text-secondary-custom mb-0">Menjadi rumah batik artisanal terkemuka yang diakui atas
                            kualitas luar biasa, praktik berkelanjutan, dan kemampuan untuk menyatukan komunitas melalui
                            kecintaan pada batik.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div
                        class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                        <div class="icon-box"><i class="fa-solid fa-bullseye fs-4"></i></div>
                        <h3 class="fs-4 fw-bold text-primary-custom mb-0">Misi</h3>
                        <ul class="text-secondary-custom mb-0 ps-3">
                            <li class="mb-2">Mendapatkan kain batik terbaik melalui perdagangan langsung dan adil.</li>
                            <li class="mb-2">Membuat setiap helai dengan presisi untuk menonjolkan corak dan
                                motif yang unik.</li>
                            <li>Mengedukasi dan menginspirasi pelanggan tentang seni dan budaya apresiasi batik.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Founder Bio -->
        <section class="container-xl">
            <div class="bg-surface-low border border-outline-variant rounded-4 p-4 p-md-5">
                <div class="row g-4 align-items-center flex-column flex-md-row">
                    <div class="col-12 col-md-4 text-center">
                        <img alt="Founder"
                            class="img-fluid rounded-circle border border-outline-variant p-1 bg-surface-lowest"
                            src="{{ asset('images/founder.jpg') }}"
                            style="width: 200px; height: 200px; object-fit: cover;" />
                    </div>
                    <div class="col-12 col-md-8 text-center text-md-start">
                        <h2 class="fw-bold text-primary-custom mb-1">Rendy</h2>
                        <h4 class="text-secondary-custom fs-6 fw-normal mb-3">Pendiri &amp; Maestro Batik</h4>
                        <p class="text-secondary-custom mb-0">Dengan pengalaman lebih dari satu dekade di industri batik,
                            Rendy percaya bahwa membatik adalah perpaduan antara seni dan ketelitian. Dedikasinya
                            terhadap kesempurnaan telah membawa Batik Nusantara memenangkan berbagai penghargaan lokal.
                            Bagi Rendy, setiap helai batik menceritakan kisah perjalanan motif dari tangan pengrajin
                            hingga ke tangan Anda.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-xl" id="kontak">
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow">
                <div class="row g-5">
                    <div class="col-12 col-lg-5">
                        <h2 class="fw-bold text-primary-custom mb-3">Hubungi Kami</h2>
                        <p class="text-secondary-custom mb-4">Punya pertanyaan tentang batik kami atau ingin bekerja
                            sama? Jangan ragu untuk menghubungi kami.</p>
                        <div class="d-flex flex-column gap-3">
                            @php
                                $whatsappRaw = preg_replace('/[^0-9]/', '', $setting->whatsapp_number ?? '');
                                $whatsappDisplay = preg_replace('/^62(\d{3})(\d{4})(\d+)$/', '+62 $1 $2 $3', $whatsappRaw);
                            @endphp
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box" style="width: 40px; height: 40px;"><i
                                        class="fa-solid fa-location-dot"></i></div>
                                <span class="text-secondary-custom">{{ $setting->address }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box" style="width: 40px; height: 40px;"><i
                                        class="fa-solid fa-envelope"></i></div>
                                <span class="text-secondary-custom">{{ $setting->email }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box" style="width: 40px; height: 40px;"><i
                                        class="fa-brands fa-whatsapp"></i></div>
                                <a class="text-secondary-custom text-decoration-none"
                                    href="https://wa.me/{{ $whatsappRaw }}" target="_blank">{{ $whatsappDisplay }}</a>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box" style="width: 40px; height: 40px;"><i
                                        class="fa-solid fa-clock"></i></div>
                                <span class="text-secondary-custom">{{ $setting->opening_hours }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <form>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary-custom" for="name">Nama
                                    Lengkap</label>
                                <input class="form-control border-outline-variant bg-surface-low" id="name"
                                    placeholder="Masukkan nama Anda" type="text" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary-custom" for="email">Alamat
                                    Email</label>
                                <input class="form-control border-outline-variant bg-surface-low" id="email"
                                    placeholder="nama@email.com" type="email" />
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-primary-custom" for="message">Pesan</label>
                                <textarea class="form-control border-outline-variant bg-surface-low" id="message"
                                    placeholder="Tulis pesan Anda di sini..." rows="4"></textarea>
                            </div>
                            <button class="btn btn-primary-custom py-2 px-4" type="button">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title font-heading fw-bold text-primary-custom" id="orderModalLabel">Pesan Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="orderProductId" value="">
                        <div class="bg-surface-low rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                            <span class="font-heading fw-bold text-primary-custom" id="orderProductNameDisplay"></span>
                            <span class="text-muted-custom fw-semibold" id="orderPriceDisplay"></span>
                        </div>
                        <div class="mb-3">
                            <label for="orderQuantity" class="form-label fw-semibold">Jumlah</label>
                            <input name="quantity" type="number" class="form-control" id="orderQuantity"
                                value="1" min="1" max="10000" required
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="orderName" class="form-label fw-semibold">Nama Lengkap</label>
                            <input name="customer_name" type="text" class="form-control" id="orderName"
                                placeholder="Masukkan nama Anda" required value="{{ old('customer_name') }}"
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="orderPhone" class="form-label fw-semibold">No. WhatsApp</label>
                            <input name="customer_phone" type="text" class="form-control" id="orderPhone"
                                placeholder="08xxxxxxxxxx" required value="{{ old('customer_phone') }}"
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="orderNotes" class="form-label fw-semibold">Catatan <span class="text-muted fw-normal">(opsional)</span></label>
                            <textarea name="notes" class="form-control" id="orderNotes" rows="2"
                                placeholder="Tulis catatan pesanan Anda, misal motif/warna yang diinginkan"
                                style="border-color: var(--border-color);">{{ old('notes') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-surface-low rounded-3 p-3">
                            <span class="fw-semibold">Estimasi Total</span>
                            <span class="font-headline headline-sm text-primary-custom" id="orderTotalDisplay">Rp 0</span>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white label-caps"
                            style="background-color: var(--primary-color);">
                            <i class="fa-brands fa-whatsapp me-2"></i>Pesan Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-surface-low border-top border-outline-variant mt-auto">
        <div class="container-xl py-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
            <div class="text-primary-custom fw-semibold label-caps text-center text-md-start">© 2026 Batik Nusantara.
                Hak Cipta Dilindungi.</div>
            <nav class="d-flex flex-wrap justify-content-center gap-4">
                <a class="footer-link fs-6" href="#">Kebijakan Privasi</a>
                <a class="footer-link fs-6" href="#">Syarat &amp; Ketentuan</a>
                <a class="footer-link fs-6" href="#">Kemitraan</a>
            </nav>
        </div>
    </footer>
    <script>
        let currentOrderPrice = 0;

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function updateOrderTotal() {
            const qty = document.getElementById('orderQuantity').value;
            document.getElementById('orderTotalDisplay').textContent = formatRupiah(currentOrderPrice * qty);
        }

        document.querySelectorAll('button[data-bs-target="#orderModal"]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                currentOrderPrice = Number(this.dataset.price);
                document.getElementById('orderProductId').value = this.dataset.productId;
                document.getElementById('orderProductNameDisplay').textContent = this.dataset.name;
                document.getElementById('orderPriceDisplay').textContent = formatRupiah(currentOrderPrice);
                document.getElementById('orderQuantity').value = 1;
                updateOrderTotal();
            });
        });

        document.getElementById('orderQuantity').addEventListener('input', updateOrderTotal);
    </script>
</body>

</html>