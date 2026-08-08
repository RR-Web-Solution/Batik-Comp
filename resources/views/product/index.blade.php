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
    {{-- <style>
        :root {
            --bb-primary: #32170d;
            --bb-primary-container: #4b2c20;
            --bb-on-primary: #ffffff;
            --bb-background: #fbf9f7;
            --bb-surface: #fbf9f7;
            --bb-surface-container-low: #f5f3f1;
            --bb-surface-container-lowest: #ffffff;
            --bb-on-background: #1b1c1b;
            --bb-on-surface-variant: #504440;
            --bb-secondary-container: #ebddd2;
            --bb-outline-variant: #d5c3bd;

            --font-headline: "Source Serif 4", serif;
            --font-body: "Work Sans", sans-serif;
        }

        body {
            background-color: var(--bb-background);
            color: var(--bb-on-background);
            font-family: var(--font-body);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Typography Utilities */
        .font-headline {
            font-family: var(--font-headline);
        }

        .text-primary-custom {
            color: var(--bb-primary);
        }

        .text-muted-custom {
            color: var(--bb-on-surface-variant);
        }

        .bg-surface {
            background-color: var(--bb-surface);
        }

        .bg-surface-low {
            background-color: var(--bb-surface-container-low);
        }

        .bg-surface-lowest {
            background-color: var(--bb-surface-container-lowest);
        }

        .display-lg {
            font-size: 32px;
            font-weight: 700;
            line-height: 40px;
        }

        @media (min-width: 768px) {
            .display-lg {
                font-size: 48px;
                line-height: 56px;
                letter-spacing: -0.02em;
            }
        }

        .headline-md {
            font-size: 32px;
            font-weight: 600;
            line-height: 40px;
        }

        .headline-sm {
            font-size: 24px;
            font-weight: 600;
            line-height: 32px;
        }

        .label-caps {
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .body-lg {
            font-size: 18px;
            font-weight: 400;
            line-height: 28px;
        }

        /* Components */
        .navbar-custom {
            border-bottom: 1px solid var(--bb-secondary-container);
            background-color: var(--bb-surface);
        }

        .product-card {
            border: 1px solid var(--bb-outline-variant);
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px -2px rgba(43, 26, 17, 0.05);
            transition: box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            box-shadow: 0 4px 20px -2px rgba(43, 26, 17, 0.15);
        }

        .product-img-wrapper {
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background-color: var(--bb-surface-container-low);
            position: relative;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease-out;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .badge-flavor {
            background-color: var(--bb-secondary-container);
            color: var(--bb-primary);
            padding: 0.25rem 0.75rem;
            border-radius: 50rem;
        }

        .btn-primary-custom {
            background-color: var(--bb-primary);
            color: var(--bb-on-primary);
            border: none;
            transition: background-color 0.2s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--bb-primary-container);
            color: var(--bb-on-primary);
        }

        footer {
            border-top: 1px solid var(--bb-secondary-container);
        }

        .footer-link {
            color: var(--bb-on-surface-variant);
            text-decoration: underline;
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: var(--bb-primary);
        }
    </style> --}}
</head>

<body>
    <!-- TopAppBar -->
    <nav class="navbar navbar-custom sticky-top py-2">
        <div class="container-xl px-3 px-md-5">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
                <i class="fa-solid fa-mug-hot text-primary-custom fs-4"></i>
                <img alt="Batik Nusantara Logo" class="d-inline-block align-text-top" height="32"
                    src="https://lh3.googleusercontent.com/aida/AP1WRLudyyAt8ZB7awYRpuMI8z_Ab8YR0g9GymAfD2P3xCExUbi25yI7a5cGKjLUBeCOMNx1Wh77h02NCOpRefLSZINF1gWeffMZ9heVzLZAo2XsT6ds893HEFBppohD73ilcoU8z7aNmNDGhfEp0PidH5lP0l-2kbxGM1C8MebAMSsZGDp5YRpqyAQERY2LO0zRRr28TgyY_hWTBRSszOHASJi8KJjA1xXlNLgnaIkqBEsbDZEVNsgm79dBqa4"
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
