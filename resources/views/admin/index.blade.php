<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Bean &amp; Brew - Login Admin</title>
    <!-- Bootstrap 5.3 CSS -->
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&amp;family=Work+Sans:ital,wght@0,100..900;1,100..900&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <style>
        :root {
            --bb-primary: #32170d;
            --bb-primary-container: #4b2c20;
            --bb-surface: #fbf9f7;
            --bb-on-surface: #1b1c1b;
            --bb-on-surface-variant: #504440;
            --bb-secondary-container: #ebddd2;
            --bb-surface-bright: #fbf9f7;
            --bb-on-primary: #ffffff;
            --bb-surface-container-low: #f5f3f1;

            --font-headline: "Source Serif 4", serif;
            --font-body: "Work Sans", sans-serif;
        }

        body {
            background-color: var(--bb-surface);
            color: var(--bb-on-surface);
            font-family: var(--font-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .font-headline {
            font-family: var(--font-headline);
        }

        .text-primary-brand {
            color: var(--bb-primary);
        }

        .border-secondary-container {
            border-color: var(--bb-secondary-container) !important;
        }

        .bg-surface-container-lowest {
            background-color: #ffffff;
        }

        .form-control:focus {
            border-color: var(--bb-primary);
            box-shadow: 0 0 0 0.25rem rgba(50, 23, 13, 0.25);
        }

        .btn-primary-brand {
            background-color: var(--bb-primary);
            color: var(--bb-on-primary);
            border: none;
        }

        .btn-primary-brand:hover {
            background-color: var(--bb-primary-container);
            color: var(--bb-on-primary);
        }

        .footer-bg {
            background-color: var(--bb-surface-container-low);
        }

        .label-caps {
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            font-weight: 600;
        }
    </style> --}}
</head>

<body>
    <!-- Minimal Header -->
    <header
        class="w-100 sticky-top border-bottom border-secondary-container bg-surface d-flex justify-content-center align-items-center py-2 px-3 z-3"
        style="background-color: var(--bb-surface);">
        <div class="font-headline fs-2 fw-semibold text-primary-brand">
            Bean &amp; Brew
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="flex-grow-1 d-flex align-items-center justify-content-center p-3 p-md-5">
        <!-- Login Card -->
        <div class="bg-surface-container-lowest border border-secondary-container rounded p-4 p-md-5 w-100 shadow-sm d-flex flex-column align-items-center"
            style="max-width: 450px;">
            <!-- Logo -->
            <img alt="Bean &amp; Brew Logo"
                class="mb-4 rounded shadow-sm border border-secondary-container object-fit-cover"
                src="https://lh3.googleusercontent.com/aida/AP1WRLudyyAt8ZB7awYRpuMI8z_Ab8YR0g9GymAfD2P3xCExUbi25yI7a5cGKjLUBeCOMNx1Wh77h02NCOpRefLSZINF1gWeffMZ9heVzLZAo2XsT6ds893HEFBppohD73ilcoU8z7aNmNDGhfEp0PidH5lP0l-2kbxGM1C8MebAMSsZGDp5YRpqyAQERY2LO0zRRr28TgyY_hWTBRSszOHASJi8KJjA1xXlNLgnaIkqBEsbDZEVNsgm79dBqa4"
                style="width: 96px; height: 96px;" />
            <!-- Welcome Text -->
            <h1 class="font-headline fs-3 text-primary-brand mb-2 text-center fw-semibold">Akses Admin</h1>
            <p class="text-center mb-5" style="color: var(--bb-on-surface-variant);">Silakan masuk untuk mengelola
                portal roastery Anda.</p>
            <!-- Login Form -->
            <form action="{{ route('login.action') }}" class="w-100 d-flex flex-column gap-4" method="POST">
                <div>
                    <label class="form-label label-caps text-uppercase mb-1" for="admin_email">Email Admin</label>
                    <input class="form-control bg-transparent border-secondary-container" id="admin_email"
                        name="email" placeholder="nama@beanandbrew.com" required="" type="email" />
                </div>
                <div>
                    <label class="form-label label-caps text-uppercase mb-1" for="admin_password">Kata Sandi</label>
                    <input class="form-control bg-transparent border-secondary-container" id="admin_password"
                        name="password" placeholder="••••••••" required="" type="password" />
                </div>
                <button class="btn btn-primary-brand w-100 py-2 mt-2 label-caps text-uppercase shadow-sm"
                    type="submit">
                    Masuk Ke Admin
                </button>
            </form>
        </div>
    </main>
    <!-- Minimal Footer -->
    <footer
        class="w-100 py-4 footer-bg border-top border-secondary-container d-flex justify-content-center align-items-center px-3 px-md-5">
        <p class="mb-0 text-center" style="color: var(--bb-on-surface-variant);">
            © 2026 Bean &amp; Brew Roastery. Crafted for clarity.
        </p>
    </footer>
    <!-- Bootstrap 5.3 JS Bundle -->
    <script crossorigin="anonymous" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
