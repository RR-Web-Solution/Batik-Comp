@extends('layouts.public')

@section('title', $product->name . ' - ' . ($setting->site_name ?? 'Batik Nusantara'))

@section('head')
    <style>
        .dropdown-toggle::after { display: none !important; }
        main { padding-top: 80px; }
    </style>
@endsection

@section('navbar')
<header class="bg-surface-lowest border-bottom border-outline-variant fixed-top">
    <div class="container-xl d-flex justify-content-between align-items-center" style="height: 64px;">
        <a class="navbar-brand d-flex align-items-center gap-2 text-primary-custom fw-bold fs-4 m-0 text-decoration-none"
            href="{{ route('home', ['locale' => App::getLocale()]) }}">
            <img alt="Batik Nusantara Logo"
                    src="{{ asset('images/logo.jpg') }}"
                style="height: 32px; width: auto; object-fit: contain;" />
            <span class="font-headline headline-md text-primary-custom mb-0">{{ $setting->site_name }}</span>
        </a>
        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button aria-expanded="false"
                    class="btn btn-link text-primary-custom p-2 border-0 fs-5 dropdown-toggle text-decoration-none"
                    data-bs-toggle="dropdown" type="button">
                    <i class="fa-solid fa-globe"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end ambient-shadow border-outline-variant">
                    <li><a class="dropdown-item text-primary-custom fw-semibold {{ App::getLocale() === 'id' ? 'active' : '' }}"
                            href="{{ route('product.show', ['locale' => 'id', 'id' => $product->id]) }}">Bahasa Indonesia</a></li>
                    <li><a class="dropdown-item text-primary-custom fw-semibold {{ App::getLocale() === 'en' ? 'active' : '' }}"
                            href="{{ route('product.show', ['locale' => 'en', 'id' => $product->id]) }}">English</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button aria-expanded="false"
                    class="btn btn-link text-primary-custom p-2 border-0 fs-5 dropdown-toggle text-decoration-none"
                    data-bs-toggle="dropdown" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end ambient-shadow border-outline-variant">
                    <li><a class="dropdown-item text-primary-custom fw-semibold"
                            href="{{ route('order.track', ['locale' => App::getLocale()]) }}">{{ __('messages.lacak') }}</a></li>
                    <li><a class="dropdown-item text-primary-custom fw-semibold"
                            href="{{ url('/admin') }}"><i class="fa-solid fa-right-to-bracket me-2"></i>{{ __('messages.login_admin') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
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
@endsection

@section('footer')
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
@endsection

@section('scripts')
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
@endsection
