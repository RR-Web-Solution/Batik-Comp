@extends('layouts.public')

@section('title', __('messages.produk') . ' - ' . ($setting->site_name ?? 'Batik Nusantara'))

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
                            href="{{ route('product.index', ['locale' => 'id']) }}">Bahasa Indonesia</a></li>
                    <li><a class="dropdown-item text-primary-custom fw-semibold {{ App::getLocale() === 'en' ? 'active' : '' }}"
                            href="{{ route('product.index', ['locale' => 'en']) }}">English</a></li>
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
                            href="{{ route('home', ['locale' => App::getLocale()]) }}">{{ __('messages.produk') }}</a></li>
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
@if ($errors->any())
    <div class="container-xl px-3 px-md-5 pt-4">
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<!-- Hero Section -->
<section class="container-xl px-3 px-md-5 pt-5 pb-4 text-center">
    <h1 class="font-headline display-lg text-primary-custom mb-4">{{ __('messages.koleksi_kami') }}</h1>
    <p class="body-lg text-muted-custom mx-auto mb-0" style="max-width: 600px;">{{ __('messages.koleksi_subtitle') }}</p>
</section>
<!-- Product Grid -->
<section class="container-xl px-3 px-md-5 pb-5 mb-5">
    <div class="row g-4">
        @foreach ($products as $product)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card product-card bg-surface-lowest">
                    <a href="{{ route('product.show', ['locale' => App::getLocale(), 'id' => $product->id]) }}" class="text-decoration-none">
                        @if ($product->image)
                            <img src="{{ asset('uploads/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fa-solid fa-image fa-3x text-white-50"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body d-flex flex-column p-4">
                        @if ($product->category)
                            <a class="badge text-bg-primary align-self-start text-decoration-none mb-2"
                                href="{{ route('category.show', ['locale' => App::getLocale(), 'slug' => $product->category->slug]) }}">
                                {{ $product->category->name }}
                            </a>
                        @endif
                        <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                            <a href="{{ route('product.show', ['locale' => App::getLocale(), 'id' => $product->id]) }}" class="text-decoration-none">
                                <h2 class="font-headline headline-sm text-primary-custom mb-0">
                                    {{ $product->name }}
                                </h2>
                            </a>
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
                            {{ __('messages.pesan_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
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
