<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Batik Nusantara - Our Collections</title>
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
            <div class="d-flex align-items-center">
                <button aria-label="Shopping Bag" class="btn btn-link text-muted-custom p-2 rounded-circle">
                    <i class="fa-solid fa-bag-shopping fs-5"></i>
                </button>
            </div>
        </div>
    </nav>
    <main class="min-vh-100">
        <!-- Hero Section -->
        <section class="container-xl px-3 px-md-5 pt-5 pb-4 text-center">
            <h1 class="font-headline display-lg text-primary-custom mb-4">Our Collections</h1>
            <p class="body-lg text-muted-custom mx-auto" style="max-width: 600px;">Expertly crafted, sustainably
                sourced.</p>
        </section>
        <!-- Product Grid -->
        <section class="container-xl px-3 px-md-5 pb-5 mb-5">
            <div class="row g-4">
                @foreach ($products as $product)
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
                                    class="btn btn-primary-custom w-100 label-caps py-2 d-flex justify-content-center align-items-center gap-2">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-surface-low py-5">
        <div class="container-xl px-3 px-md-5">
            <div class="row gy-4">
                <div class="col-12 col-md-6 d-flex flex-column gap-2">
                    <span class="font-headline headline-sm text-primary-custom">Batik Nusantara</span>
                    <p class="mb-0">© 2026 Batik Nusantara. Crafted for clarity.</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center">
                    <ul class="nav gap-3">
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="#">Sourcing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="#">Batik Guides</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="#">Wholesale</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-0 footer-link" href="#">Privacy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script crossorigin="anonymous" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>