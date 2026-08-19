<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login - Batik Nusantara</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&amp;family=Work+Sans:wght@400;600&amp;display=swap"
        rel="stylesheet" />
    <!-- Custom Styles for Artisanal Batik Theme -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- TopAppBar -->
    <header class="w-100 header-custom">
        <div class="container-fluid px-3 py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}">
                    <img alt="Batik Nusantara Logo" class="rounded object-fit-cover"
                        src="{{ asset('images/logo.jpg') }}"
                        style="width: 32px; height: 32px;" />
                </a>
                <span class="font-heading text-primary-custom fs-3 fw-semibold mb-0">Batik Nusantara</span>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="flex-grow-1 p-3 d-flex align-items-center justify-content-center">
        <div class="card border-0 ambient-shadow w-100" style="max-width: 400px; background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img alt="Batik Nusantara Logo" class="rounded-circle object-fit-cover mb-3"
                        src="{{ asset('images/logo.jpg') }}"
                        style="width: 72px; height: 72px;" />
                    <h2 class="font-heading text-primary-custom fw-bold mb-0">Login Admin</h2>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.action') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input name="email" type="email" class="form-control" id="email"
                            placeholder="admin@gmail.com" required="" style="border-color: var(--border-color);" value="{{ old('email') }}">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input name="password" type="password" class="form-control" id="password"
                            placeholder="••••••••" required="" style="border-color: var(--border-color);">
                    </div>
                    <button type="submit" class="btn w-100 text-white" style="background-color: var(--primary-color);">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a class="text-secondary-custom" href="{{ route('home') }}" style="text-decoration: none;">&larr; Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>