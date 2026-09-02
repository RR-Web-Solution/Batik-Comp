@extends('layouts.public')

@section('title', __('messages.lacak_pesanan') . ' - ' . ($setting->site_name ?? 'Batik Nusantara'))

@section('head')
    <style>
        .dropdown-toggle::after { display: none !important; }
        main { padding-top: 80px; }
        .track-center { padding-top: min(25vh, 120px); }
    </style>
@endsection

@section('main_class', 'min-vh-100 d-flex flex-column track-center')

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
                            href="{{ route('order.track', ['locale' => 'id', 'order_number' => request('order_number')]) }}">Bahasa Indonesia</a></li>
                    <li><a class="dropdown-item text-primary-custom fw-semibold {{ App::getLocale() === 'en' ? 'active' : '' }}"
                            href="{{ route('order.track', ['locale' => 'en', 'order_number' => request('order_number')]) }}">English</a></li>
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
            <div class="text-center mb-4">
                <h1 class="font-headline display-lg text-primary-custom mb-2">{{ __('messages.lacak_pesanan') }}</h1>
                <p class="body-lg text-muted-custom mb-0">{{ __('messages.track_subtitle') }}</p>
            </div>

            <form method="GET" action="{{ route('order.track', ['locale' => App::getLocale()]) }}" class="bg-surface-lowest border border-outline-variant rounded-4 p-3 ambient-shadow">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-surface-low border-outline-variant"><i class="fa-solid fa-barcode"></i></span>
                    <input type="text" name="order_number" class="form-control border-outline-variant"
                        placeholder="{{ __('messages.contoh') }}: ORD-260819-1234" value="{{ request('order_number') }}" required>
                    <button class="btn btn-primary-custom px-4" type="submit">{{ __('messages.lacak') }}</button>
                </div>
            </form>

            @if ($searched)
                @if (! $order)
                    <div class="alert alert-warning shadow-sm mt-4 text-center mb-0" role="alert">
                        {{ __('messages.pesanan_tidak_ditemukan') }}
                    </div>
                @elseif ($order->status === 'menunggu')
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow mt-4 text-center mb-0">
                        <div class="icon-box mx-auto mb-3" style="width: 64px; height: 64px; border-radius: 50%;">
                            <i class="fa-solid fa-hourglass-half fs-3"></i>
                        </div>
                        <h4 class="font-heading text-primary-custom fw-bold">{{ $order->order_number }}</h4>
                        <p class="text-muted-custom mb-3">{{ __('messages.belum_dikonfirmasi') }}</p>
                        <div class="alert alert-info small text-start mx-auto mb-3" role="alert" style="max-width: 460px;">
                            {{ __('messages.silakan_kirim_wa') }}
                        </div>
                        <a href="{{ $order->whatsappUrl() }}" target="_blank"
                            class="btn btn-primary-custom px-4 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fa-brands fa-whatsapp"></i>{{ __('messages.kirim_wa_sekarang') }}
                        </a>
                    </div>
                @elseif ($order->status === 'ditolak')
                    @php
                        $inquiryMessage = __('messages.wa_halo') . " {$setting->site_name}!\n\n"
                            . __('messages.wa_menanyakan') . "\n"
                            . __('messages.wa_no_order') . '   : '.$order->order_number."\n"
                            . __('messages.wa_nama_produk') . ' : '.$order->product->name."\n"
                            . __('messages.wa_jumlah') . '      : '.$order->quantity." pcs\n"
                            . __('messages.wa_total') . '       : Rp '.number_format($order->total, 0, ',', '.')."\n\n"
                            . __('messages.wa_terima_kasih');
                    @endphp
                    <div class="alert alert-danger shadow-sm mt-4 text-center mb-0" role="alert">
                        {{ __('messages.pesanan_ditolak_maaf') }} <strong>{{ $order->order_number }}</strong> {{ __('messages.pesanan_ditolak_suffix') }}
                        {{ __('messages.hubungi_wa_info') }}
                        <br>
                        <a href="https://wa.me/{{ $setting->whatsapp_number }}?text={{ rawurlencode($inquiryMessage) }}"
                            class="btn btn-outline-danger mt-3" target="_blank">
                            <i class="fa-brands fa-whatsapp"></i>{{ __('messages.tanyakan_order') }}
                        </a>
                    </div>
                @else
                    @php
                        $steps = ['baru', 'diproses', 'selesai'];
                        $labels = [__('messages.pesanan_diterima'), __('messages.sedang_dibuat'), __('messages.selesai')];
                        $icons = ['fa-inbox', 'fa-pen-ruler', 'fa-check-circle'];
                        $current = array_search($order->status, $steps);
                    @endphp
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow mt-4 mb-0">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-5">
                            <div>
                                <h4 class="font-heading text-primary-custom fw-bold mb-1">{{ $order->order_number }}</h4>
                                <p class="text-muted-custom mb-0">
                                    {{ $order->product->name }} · {{ $order->quantity }} pcs
                                </p>
                            </div>
                            <span class="font-headline headline-sm text-primary-custom">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="stepper">
                            @foreach ($steps as $i => $step)
                                <div class="step {{ $i < $current ? 'done' : '' }} {{ $i === $current ? 'current' : '' }}">
                                    <div class="step-dot"><i class="fa-solid {{ $icons[$i] }}"></i></div>
                                    <p class="step-label">{{ $labels[$i] }}</p>
                                </div>
                                @if (! $loop->last)
                                    <div class="step-line {{ $i < $current ? 'done' : '' }}"></div>
                                @endif
                            @endforeach
                        </div>

                        <p class="text-center text-muted-custom small mb-0 mt-4">
                            {{ __('messages.masuk') }} {{ $order->created_at->diffForHumans() }}.
                            <br>
                            {{ __('messages.jam_operasional') }}: {{ $setting->opening_hours }}
                        </p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection
