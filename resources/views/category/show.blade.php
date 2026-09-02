@extends('layouts.public')

@section('title', $category->name . ' - ' . ($setting->site_name ?? 'Batik Nusantara'))

@section('navbar')
<nav class="navbar navbar-custom sticky-top py-2">
    <div class="container-xl px-3 px-md-5">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home', ['locale' => App::getLocale()]) }}">
            <img alt="Batik Nusantara Logo" class="d-inline-block align-text-top" height="32"
                src="{{ asset('images/logo.jpg') }}"
                width="auto" />
            <span class="font-headline headline-md text-primary-custom mb-0">{{ $setting->site_name }}</span>
        </a>
        <div class="d-flex align-items-center gap-2">
            <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('order.track', ['locale' => App::getLocale()]) }}">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>{{ __('messages.lacak') }}</span>
            </a>
            <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('product.index', ['locale' => App::getLocale()]) }}">
                <i class="fa-solid fa-box"></i>
                <span>{{ __('messages.produk') }}</span>
            </a>
        </div>
    </div>
</nav>
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
<!-- Category Hero -->
<section class="container-xl px-3 px-md-5 pt-5 pb-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home', ['locale' => App::getLocale()]) }}">{{ __('messages.beranda') }}</a></li>
            <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('product.index', ['locale' => App::getLocale()]) }}">{{ __('messages.produk') }}</a></li>
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
        <h2 class="font-headline headline-sm text-primary-custom mb-3">{{ __('messages.daftar_harga') }} {{ $category->name }}</h2>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="font-heading">{{ __('messages.produk') }}</th>
                        <th class="font-heading text-end">{{ __('messages.harga') }}</th>
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
                            <td colspan="2" class="text-center py-4 text-muted">{{ __('messages.produk_kategori_kosong') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- Product Grid -->
<section class="container-xl px-3 px-md-5 pb-5 mb-5">
    <h2 class="font-headline headline-sm text-primary-custom mb-4">{{ __('messages.pilih_produk') }}</h2>
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
                            {{ __('messages.pesan_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5 mb-0">{{ __('messages.produk_kategori_kosong') }}</p>
            </div>
        @endforelse
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
                        <a class="nav-link p-0 footer-link" href="{{ route('product.index', ['locale' => App::getLocale()]) }}">{{ __('messages.produk') }}</a>
                    </li>
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
