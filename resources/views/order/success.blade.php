@extends('layouts.public')

@section('title', __('messages.pesanan_tercatat') . ' - ' . ($setting->site_name ?? 'Batik Nusantara'))

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
                            href="{{ route('order.success', ['locale' => 'id', 'orderNumber' => $order->order_number]) }}">Bahasa Indonesia</a></li>
                    <li><a class="dropdown-item text-primary-custom fw-semibold {{ App::getLocale() === 'en' ? 'active' : '' }}"
                            href="{{ route('order.success', ['locale' => 'en', 'orderNumber' => $order->order_number]) }}">English</a></li>
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
                            href="{{ url('/admin') }}"><i class="fa-solid fa-right-to-bracket me-2"></i>{{ __('messages.login_admin') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="container-xl px-3 px-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow">
                <div class="text-center mb-4">
                    <div class="icon-box mx-auto mb-3" style="width: 64px; height: 64px; border-radius: 50%;">
                        <i class="fa-solid fa-check fs-3"></i>
                    </div>
                    <h1 class="font-headline headline-md text-primary-custom mb-2">{{ __('messages.pesanan_tercatat_excl') }}</h1>
                    <p class="text-muted-custom mb-0">{!! __('messages.terima_kasih_pesanan', ['name' => $order->customer_name]) !!}</p>
                </div>

                <div class="text-center mb-4">
                    <div class="bg-surface-low border border-outline-variant rounded-3 py-3 px-4 d-inline-block">
                        <span class="font-headline headline-sm text-primary-custom">{{ $order->order_number }}</span>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <small class="text-muted d-block">{{ __('messages.produk') }}</small>
                        <strong class="text-primary-custom">{{ $order->product->name }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">{{ __('messages.jumlah') }}</small>
                        <strong class="text-primary-custom">{{ $order->quantity }}</strong>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block">{{ __('messages.estimasi_total') }}</small>
                        <span class="font-headline headline-sm text-primary-custom">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                    @if ($order->notes)
                        <div class="col-12">
                            <small class="text-muted d-block">{{ __('messages.catatan') }}</small>
                            <p class="text-muted-custom mb-0">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="alert alert-info small text-start mb-4" role="alert">
                    {!! __('messages.status_menunggu_info', ['status1' => __('messages.menunggu_konfirmasi'), 'status2' => __('messages.baru')]) !!}
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ $order->whatsappUrl() }}" target="_blank"
                        class="btn btn-primary-custom py-3 d-flex justify-content-center align-items-center gap-2">
                        <i class="fa-brands fa-whatsapp"></i>{{ __('messages.lanjutkan_wa') }}
                    </a>
                    <a href="{{ route('order.track', ['locale' => App::getLocale(), 'order_number' => $order->order_number]) }}"
                        class="btn btn-outline-secondary py-3 d-flex justify-content-center align-items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>{{ __('messages.lacak_pesanan_ini') }}
                    </a>
                    <a href="{{ route('product.index', ['locale' => App::getLocale()]) }}"
                        class="btn btn-link text-muted-custom text-decoration-none">{{ __('messages.kembali_katalog') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
