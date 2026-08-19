<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pesanan Tercatat - {{ $setting->site_name }}</title>
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
                <span class="font-headline headline-md text-primary-custom mb-0">{{ $setting->site_name }}</span>
            </a>
        </div>
    </nav>
    <main class="min-vh-100 d-flex align-items-center py-5">
        <section class="container-xl px-3 px-md-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 p-md-5 ambient-shadow">
                        <div class="text-center mb-4">
                            <div class="icon-box mx-auto mb-3" style="width: 64px; height: 64px; border-radius: 50%;">
                                <i class="fa-solid fa-check fs-3"></i>
                            </div>
                            <h1 class="font-headline headline-md text-primary-custom mb-2">Pesanan Tercatat!</h1>
                            <p class="text-muted-custom mb-0">Terima kasih, {{ $order->customer_name }}. Simpan nomor pesanan Anda untuk melacak progres:</p>
                        </div>

                        <div class="text-center mb-4">
                            <div class="bg-surface-low border border-outline-variant rounded-3 py-3 px-4 d-inline-block">
                                <span class="font-headline headline-sm text-primary-custom">{{ $order->order_number }}</span>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <small class="text-muted d-block">Produk</small>
                                <strong class="text-primary-custom">{{ $order->product->name }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Jumlah</small>
                                <strong class="text-primary-custom">{{ $order->quantity }}</strong>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Estimasi Total</small>
                                <span class="font-headline headline-sm text-primary-custom">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </span>
                            </div>
                            @if ($order->notes)
                                <div class="col-12">
                                    <small class="text-muted d-block">Catatan</small>
                                    <p class="text-muted-custom mb-0">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="alert alert-info small text-start mb-4" role="alert">
                            Pesanan berstatus <strong>menunggu</strong>. Status berubah menjadi <strong>baru</strong>
                            setelah Anda mengirim pesan WhatsApp di bawah ini dan admin mengonfirmasinya.
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ $order->whatsappUrl() }}" target="_blank"
                                class="btn btn-primary-custom py-3 d-flex justify-content-center align-items-center gap-2">
                                <i class="fa-brands fa-whatsapp"></i>Lanjutkan ke WhatsApp
                            </a>
                            <a href="{{ route('order.track', ['order_number' => $order->order_number]) }}"
                                class="btn btn-outline-secondary py-3 d-flex justify-content-center align-items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass"></i>Lacak Pesanan Ini
                            </a>
                            <a href="{{ route('product.index') }}"
                                class="btn btn-link text-muted-custom text-decoration-none">Kembali ke Katalog</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script crossorigin="anonymous" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
