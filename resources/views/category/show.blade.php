<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $category->name }} - Batik Nusantara</title>
    <!-- Bootstrap 5.3 CSS -->
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" rel="stylesheet" />
    <!-- Font Awesome -->
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@100..900&amp;family=Work+Sans:wght@100..900&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- TopAppBar -->
    <nav class="navbar navbar-custom sticky-top py-2">
        <div class="container-xl px-3 px-md-5">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
                <img alt="Batik Nusantara Logo" class="d-inline-block align-text-top" height="32"
                    src="{{ asset('images/logo.jpg') }}"
                    width="auto" />
                <span class="font-headline headline-md text-primary-custom mb-0">Batik Nusantara</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('order.track') }}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Lacak</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('product.index') }}">
                    <i class="fa-solid fa-box"></i>
                    <span>Produk</span>
                </a>
            </div>
        </div>
    </nav>
    <main class="min-vh-100">
        @if ($errors->any())
            <div class="container-xl px-3 px-md-5 pt-4">
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <!-- Category Hero -->
        <section class="container-xl px-3 px-md-5 pt-5 pb-4">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('product.index') }}">Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <h1 class="font-headline display-lg text-primary-custom mb-3">{{ $category->name }}</h1>
                    <p class="body-lg text-muted-custom mb-0" style="max-width: 640px;">{{ $category->description }}</p>
                </div>
                <div class="col-12 col-lg-4 text-center">
                    @if ($category->image)
                        <img src="{{ asset('uploads/' . $category->image) }}" class="img-fluid rounded-4 ambient-shadow"
                            alt="{{ $category->name }}" style="max-height: 220px; object-fit: cover;">
                    @else
                        <div class="icon-box mx-auto" style="width: 96px; height: 96px; border-radius: 1rem;">
                            <i class="fa-solid fa-layer-group fs-1"></i>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- Price Table -->
        <section class="container-xl px-3 px-md-5 pb-4">
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
                <h2 class="font-headline headline-sm text-primary-custom mb-3">Daftar Harga {{ $category->name }}</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="font-heading">Produk</th>
                                <th class="font-heading text-end">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $product->name }}
                                        @if ($product->description)
                                            <div class="small text-muted fw-normal">{{ Str::limit($product->description, 60) }}</div>
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold text-primary-custom">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-muted">Belum ada produk di kategori ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- Product Grid -->
        <section class="container-xl px-3 px-md-5 pb-5 mb-5">
            <h2 class="font-headline headline-sm text-primary-custom mb-4">Pilih Produk</h2>
            <div class="row g-4">
                @forelse ($products as $product)
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
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5 mb-0">Belum ada produk di kategori ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-surface-low py-5">
        <div class="container-xl px-3 px-md-5">
            <div class="row gy-4">
                <div class="col-12 col-md-6 d-flex flex-column gap-2">
                    <span class="font-headline headline-sm text-primary-custom">Batik Nusantara</span>
                    <p class="mb-0">© 2026 Batik Nusantara. Hak Cipta Dilindungi.</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center">
                    <ul class="nav gap-3">
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="{{ route('product.index') }}">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="{{ route('order.track') }}">Lacak Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="{{ route('home') }}#kontak">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
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
    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script crossorigin="anonymous" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
