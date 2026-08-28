<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $product->name }} - {{ $setting->site_name }}</title>
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
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home', ['locale' => App::getLocale()]) }}">
                <img alt="Batik Nusantara Logo" class="d-inline-block align-text-top" height="32"
                    src="{{ asset('images/logo.jpg') }}"
                    width="auto" />
                <span class="font-headline headline-md text-primary-custom mb-0">{{ $setting->site_name }}</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('product.index', ['locale' => App::getLocale()]) }}">
                    <i class="fa-solid fa-grid-2"></i>
                    <span>{{ __('messages.produk') }}</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('order.track', ['locale' => App::getLocale()]) }}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>{{ __('messages.lacak') }}</span>
                </a>
            </div>
        </div>
    </nav>
    <main class="min-vh-100">
        <!-- Breadcrumb -->
        <section class="container-xl px-3 px-md-5 pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => App::getLocale()]) }}" class="text-decoration-none">{{ __('messages.beranda') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.index', ['locale' => App::getLocale()]) }}" class="text-decoration-none">{{ __('messages.produk') }}</a></li>
                    @if ($product->category)
                        <li class="breadcrumb-item"><a href="{{ route('category.show', ['locale' => App::getLocale(), 'slug' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </section>
        <!-- Product Detail -->
        <section class="container-xl px-3 px-md-5 py-4 mb-5">
            <div class="row g-5">
                <div class="col-12 col-lg-6">
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 overflow-hidden ambient-shadow">
                        @if ($product->image)
                            <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->name }}" class="w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-secondary" style="aspect-ratio: 1/1;">
                                <i class="fa-solid fa-image fa-5x text-white-50"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex flex-column gap-4">
                    @if ($product->category)
                        <a class="badge text-bg-primary align-self-start text-decoration-none" href="{{ route('category.show', ['locale' => App::getLocale(), 'slug' => $product->category->slug]) }}">
                            {{ $product->category->name }}
                        </a>
                    @endif
                    <h1 class="font-headline display-lg text-primary-custom mb-0">{{ $product->name }}</h1>
                    <p class="font-headline headline-md text-muted-custom mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="bg-surface-low border border-outline-variant rounded-3 p-4">
                        <h3 class="fs-6 fw-bold text-primary-custom mb-2">{{ __('messages.deskripsi_produk') }}</h3>
                        <p class="text-secondary-custom mb-0">{{ $product->description ?: __('messages.deskripsi_kosong') }}</p>
                    </div>
                    <button
                        class="btn btn-primary-custom py-3 px-4 label-caps d-flex justify-content-center align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#orderModal"
                        data-product-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}">
                        <i class="fa-brands fa-whatsapp fs-5"></i>
                        {{ __('messages.pesan_sekarang') }}
                    </button>
                </div>
            </div>
        </section>
        <!-- Related Products -->
        @if ($relatedProducts->count())
            <section class="container-xl px-3 px-md-5 pb-5 mb-5">
                <h2 class="font-headline headline-md text-primary-custom mb-4">{{ __('messages.produk_sejenis') }}</h2>
                <div class="row g-4">
                    @foreach ($relatedProducts as $related)
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="{{ route('product.show', ['locale' => App::getLocale(), 'id' => $related->id]) }}" class="text-decoration-none">
                                <div class="card product-card bg-surface-lowest h-100">
                                    @if ($related->image)
                                        <img src="{{ asset('uploads/' . $related->image) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                                            <i class="fa-solid fa-image fa-3x text-white-50"></i>
                                        </div>
                                    @endif
                                    <div class="card-body p-3">
                                        <h3 class="font-headline headline-sm text-primary-custom mb-1">{{ $related->name }}</h3>
                                        <p class="text-muted-custom mb-0">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
    <!-- Footer -->
    <footer class="bg-surface-low py-5">
        <div class="container-xl px-3 px-md-5">
            <div class="row gy-4">
                <div class="col-12 col-md-6 d-flex flex-column gap-2">
                    <span class="font-headline headline-sm text-primary-custom">{{ $setting->site_name }}</span>
                    <p class="mb-0">© 2026 {{ $setting->site_name }}. {{ __('messages.hak_cipta') }}</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center">
                    <ul class="nav gap-3">
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="{{ route('order.track', ['locale' => App::getLocale()]) }}">{{ __('messages.lacak_pesanan') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="{{ route('home', ['locale' => App::getLocale()]) }}#kontak">{{ __('messages.kontak') }}</a>
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
                    <h5 class="modal-title font-heading fw-bold text-primary-custom" id="orderModalLabel">{{ __('messages.pesan_produk') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('order.store', ['locale' => App::getLocale()]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="orderProductId" value="">
                        <div class="bg-surface-low rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                            <span class="font-heading fw-bold text-primary-custom" id="orderProductNameDisplay"></span>
                            <span class="text-muted-custom fw-semibold" id="orderPriceDisplay"></span>
                        </div>
                        <div class="mb-3">
                            <label for="orderQuantity" class="form-label fw-semibold">{{ __('messages.jumlah') }}</label>
                            <input name="quantity" type="number" class="form-control" id="orderQuantity"
                                value="1" min="1" max="10000" required
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="orderName" class="form-label fw-semibold">{{ __('messages.nama_lengkap') }}</label>
                            <input name="customer_name" type="text" class="form-control" id="orderName"
                                placeholder="{{ __('messages.nama_placeholder') }}" required value="{{ old('customer_name') }}"
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="orderPhone" class="form-label fw-semibold">{{ __('messages.no_whatsapp') }}</label>
                            <input name="customer_phone" type="text" class="form-control" id="orderPhone"
                                placeholder="08xxxxxxxxxx" required value="{{ old('customer_phone') }}"
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="orderNotes" class="form-label fw-semibold">{{ __('messages.catatan') }} <span class="text-muted fw-normal">({{ __('messages.catatan_opsional') }})</span></label>
                            <textarea name="notes" class="form-control" id="orderNotes" rows="2"
                                placeholder="{{ __('messages.catatan_placeholder') }}"
                                style="border-color: var(--border-color);">{{ old('notes') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-surface-low rounded-3 p-3">
                            <span class="fw-semibold">{{ __('messages.estimasi_total') }}</span>
                            <span class="font-headline headline-sm text-primary-custom" id="orderTotalDisplay">Rp 0</span>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('messages.batal') }}</button>
                        <button type="submit" class="btn text-white label-caps"
                            style="background-color: var(--primary-color);">
                            <i class="fa-brands fa-whatsapp me-2"></i>{{ __('messages.pesan_produk_btn') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script crossorigin="anonymous" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
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
