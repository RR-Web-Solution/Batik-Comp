<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Roastery Admin - Bean &amp; Brew</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&amp;family=Work+Sans:wght@400;600&amp;display=swap"
        rel="stylesheet" />
    <!-- Custom Styles for Artisanal Brew Theme -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <style>
        :root {
            --primary-color: #32170d;
            --bg-color: #fbf9f7;
            --text-color: #1b1c1b;
            --text-muted: #504440;
            --border-color: #d5c3bd;
            --font-heading: "Source Serif 4", serif;
            --font-body: "Work Sans", sans-serif;
            --hover-bg: #e4e2e0;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: var(--font-body);
            height: 100vh;
        }

        .font-heading {
            font-family: var(--font-heading);
        }

        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .text-muted-custom {
            color: var(--text-muted) !important;
        }

        .header-custom {
            border-bottom: 1px solid var(--border-color);
        }

        .nav-link-custom {
            color: var(--text-muted);
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        .nav-link-custom:hover {
            background-color: var(--hover-bg);
            color: var(--text-color);
        }
    </style> --}}
</head>

<body class="d-flex flex-column">
    <!-- TopAppBar -->
    <header class="w-100 header-custom">
        <div class="container-fluid px-3 py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('dashboard') }}">
                    <img alt="Bean &amp; Brew Logo" class="rounded object-fit-cover"
                    src="https://lh3.googleusercontent.com/aida/AP1WRLudyyAt8ZB7awYRpuMI8z_Ab8YR0g9GymAfD2P3xCExUbi25yI7a5cGKjLUBeCOMNx1Wh77h02NCOpRefLSZINF1gWeffMZ9heVzLZAo2XsT6ds893HEFBppohD73ilcoU8z7aNmNDGhfEp0PidH5lP0l-2kbxGM1C8MebAMSsZGDp5YRpqyAQERY2LO0zRRr28TgyY_hWTBRSszOHASJi8KJjA1xXlNLgnaIkqBEsbDZEVNsgm79dBqa4"
                    style="width: 32px; height: 32px;" />
                </a>
                <span class="font-heading text-primary-custom fs-3 fw-semibold mb-0">Bean &amp; Brew</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('product') }}">
                    <i class="fa-solid fa-box"></i>
                    <span>Produk</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('user') }}">
                    <i class="fa-solid fa-users"></i>
                    <span>User</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="flex-grow-1 p-3 d-flex flex-column align-items-center justify-content-center">
        <div class="text-center">
            <h1 class="font-heading text-primary-custom fw-bold mb-3">Selamat Datang, Admin</h1>
            <p class="text-muted-custom fs-5 mb-0 mx-auto" style="max-width: 400px;">
                Silakan gunakan menu navigasi untuk mengelola sistem.
            </p>
        </div>
    </main>
    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
