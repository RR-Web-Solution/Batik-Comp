@extends('layouts.public')

@section('title', 'Batik Nusantara - Company Profile')

@section('head')
    <style>
        .dropdown-toggle::after { display: none !important; }
        main { padding-top: 80px; }
    </style>
@endsection

@section('body_attrs', '')

@section('navbar')
<header class="bg-surface-lowest border-bottom border-outline-variant fixed-top">
    <div class="container-xl d-flex justify-content-between align-items-center" style="height: 64px;">
        <a class="navbar-brand d-flex align-items-center gap-2 text-primary-custom fw-bold fs-4 m-0 text-decoration-none"
            href="{{ route('home', ['locale' => App::getLocale()]) }}">
            <img alt="Batik Nusantara Logo"
                    src="{{ asset('images/logo.jpg') }}"
                style="height: 32px; width: auto; object-fit: contain;" />
            <span class="font-headline headline-md text-primary-custom mb-0">Batik Nusantara</span>
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
                            href="{{ route('home', ['locale' => 'id']) }}">Bahasa Indonesia</a></li>
                    <li><a class="dropdown-item text-primary-custom fw-semibold {{ App::getLocale() === 'en' ? 'active' : '' }}"
                            href="{{ route('home', ['locale' => 'en']) }}">English</a></li>
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
                            href="{{ route('product.index', ['locale' => App::getLocale()]) }}">{{ __('messages.produk') }}</a></li>
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

@section('main_class', 'd-flex flex-column gap-5 mb-5')

@section('content')
<!-- Hero Section -->
<section class="container-xl mt-4 px-5">
    <div class="row align-items-center g-4 flex-column-reverse flex-md-row">
        <div class="col-12 col-md-6 text-center text-md-start">
            <h1 class="display-4 fw-bold text-primary-custom mb-3">{{ __('messages.hero_title') }}</h1>
            <p class="fs-5 text-secondary-custom mb-4">{{ __('messages.hero_subtitle') }}</p>
            <a class="btn btn-primary-custom py-2 px-4" href="{{ route('product.index', ['locale' => App::getLocale()]) }}">
                {{ __('messages.hero_cta') }}
            </a>
        </div>
        <div class="col-12 col-md-6">
            <img alt="{{ __('messages.alt_proses_membatik') }}" class="img-fluid rounded-4 ambient-shadow w-100 object-fit-cover"
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
                <h2 class="fw-bold text-primary-custom mb-3">{{ __('messages.tentang_perusahaan') }}</h2>
                <p class="text-secondary-custom mb-0">{{ __('messages.tentang_text') }}</p>
            </div>
        </div>
    </div>
</section>
<!-- Categories -->
<section class="container-xl" id="kategori">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary-custom mb-2">{{ __('messages.koleksi_kategori') }}</h2>
        <p class="text-secondary-custom mb-0">{{ __('messages.kategori_subtitle') }}</p>
    </div>
    <div class="row g-4">
        @foreach ($categories as $category)
            <div class="col-12 col-md-6 col-lg-3">
                <a class="text-decoration-none d-block h-100" href="{{ route('category.show', ['locale' => App::getLocale(), 'slug' => $category->slug]) }}">
                    <div
                        class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                        <div class="icon-box"><i class="fa-solid fa-layer-group fs-4"></i></div>
                        <div>
                            <h3 class="font-headline headline-sm text-primary-custom mb-1">{{ $category->name }}</h3>
                            <p class="text-secondary-custom mb-2">{{ $category->description }}</p>
                            <span class="label-caps text-primary-custom">{{ __('messages.produk_count', ['count' => $category->products_count]) }}</span>
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
        <h2 class="fw-bold text-primary-custom mb-2">{{ __('messages.produk_pilihan') }}</h2>
        <p class="text-secondary-custom mb-0">{{ __('messages.produk_pilihan_subtitle') }}</p>
    </div>
    <div class="row g-4">
        @foreach ($featuredProducts as $product)
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
                            {{ __('messages.pesan_sekarang') }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
<!-- Testimonials -->
@if ($testimonials->count())
    <section class="container-xl" id="testimoni">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary-custom mb-2">{{ __('messages.testimoni_title') }}</h2>
            <p class="text-secondary-custom mb-0">{{ __('messages.testimoni_subtitle') }}</p>
        </div>
        <div class="row g-4">
            @foreach ($testimonials as $t)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                        <div class="d-flex gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $t->rating)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @else
                                    <i class="fa-regular fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-secondary-custom mb-0 flex-grow-1">"{{ $t->content }}"</p>
                        <div class="border-top border-outline-variant pt-3">
                            <div class="fw-semibold text-primary-custom">{{ $t->customer_name }}</div>
                            @if ($t->customer_title)
                                <div class="text-muted-custom small">{{ $t->customer_title }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
<!-- Vision & Mission -->
<section class="container-xl">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div
                class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                <div class="icon-box"><i class="fa-solid fa-eye fs-4"></i></div>
                <h3 class="fs-4 fw-bold text-primary-custom mb-0">{{ __('messages.visi') }}</h3>
                <p class="text-secondary-custom mb-0">{{ __('messages.visi_text') }}</p>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div
                class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100 d-flex flex-column gap-3">
                <div class="icon-box"><i class="fa-solid fa-bullseye fs-4"></i></div>
                <h3 class="fs-4 fw-bold text-primary-custom mb-0">{{ __('messages.misi') }}</h3>
                <ul class="text-secondary-custom mb-0 ps-3">
                    <li class="mb-2">{{ __('messages.misi_1') }}</li>
                    <li class="mb-2">{{ __('messages.misi_2') }}</li>
                    <li>{{ __('messages.misi_3') }}</li>
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
                <h4 class="text-secondary-custom fs-6 fw-normal mb-3">{{ __('messages.pendiri') }}</h4>
                <p class="text-secondary-custom mb-0">{{ __('messages.pendiri_text') }}</p>
            </div>
        </div>
    </div>
</section>
<section class="container-xl" id="kontak">
    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow">
        <div class="row g-5">
            <div class="col-12 col-lg-5">
                <h2 class="fw-bold text-primary-custom mb-3">{{ __('messages.hubungi_kami') }}</h2>
                <p class="text-secondary-custom mb-4">{{ __('messages.contact_subtitle') }}</p>
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
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('contact.store', ['locale' => App::getLocale()]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-primary-custom" for="name">{{ __('messages.nama_lengkap') }}</label>
                        <input class="form-control border-outline-variant bg-surface-low" id="name" name="name"
                            placeholder="{{ __('messages.nama_placeholder') }}" type="text" value="{{ old('name') }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-primary-custom" for="email">{{ __('messages.email') }}</label>
                        <input class="form-control border-outline-variant bg-surface-low" id="email" name="email"
                            placeholder="{{ __('messages.email_placeholder') }}" type="email" value="{{ old('email') }}" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-primary-custom" for="message">{{ __('messages.pesan') }}</label>
                        <textarea class="form-control border-outline-variant bg-surface-low" id="message" name="message"
                            placeholder="{{ __('messages.pesan_placeholder') }}" rows="4" required>{{ old('message') }}</textarea>
                    </div>
                    <button class="btn btn-primary-custom py-2 px-4" type="submit">{{ __('messages.kirim_pesan') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer')
<footer class="bg-surface-low border-top border-outline-variant mt-auto">
    <div class="container-xl py-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
        <div class="text-primary-custom fw-semibold label-caps text-center text-md-start">© 2026 Batik Nusantara.
            {{ __('messages.hak_cipta') }}</div>
        <nav class="d-flex flex-wrap justify-content-center gap-4">
            <a class="footer-link fs-6" href="#">{{ __('messages.kebijakan_privasi') }}</a>
            <a class="footer-link fs-6" href="#">{{ __('messages.syarat_ketentuan') }}</a>
            <a class="footer-link fs-6" href="#">{{ __('messages.kemitraan') }}</a>
        </nav>
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
