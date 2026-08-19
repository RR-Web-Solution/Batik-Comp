<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Order {{ $order->order_number }} - Batik Nusantara</title>
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

<body class="d-flex flex-column">
    <!-- TopAppBar -->
    <header class="w-100 header-custom">
        <div class="container-fluid px-3 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('dashboard') }}">
                    <img alt="Batik Nusantara Logo" class="rounded object-fit-cover"
                        src="{{ asset('images/logo.jpg') }}"
                        style="width: 32px; height: 32px;" />
                </a>
                <span class="font-heading text-primary-custom fs-3 fw-semibold mb-0">Batik Nusantara</span>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('product') }}">
                    <i class="fa-solid fa-box"></i><span>Produk</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('category') }}">
                    <i class="fa-solid fa-folder"></i><span>Kategori</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('order') }}">
                    <i class="fa-solid fa-receipt"></i><span>Order</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('user') }}">
                    <i class="fa-solid fa-users"></i><span>User</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('setting') }}">
                    <i class="fa-solid fa-gear"></i><span>Pengaturan</span>
                </a>
                <a class="nav-link-custom d-flex align-items-center gap-2 p-2 rounded" href="{{ route('logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span>
                </a>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="flex-grow-1 p-3 d-flex flex-column">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('order') }}">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h2 class="font-heading text-primary-custom fw-bold mb-0">{{ $order->order_number }}</h2>
                    <span class="badge {{ $order->statusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                </div>
                <p class="text-muted-custom small mb-0">Masuk {{ $order->created_at->diffForHumans() }}</p>
            </div>

            <div class="row g-3">
                {{-- Produk --}}
                <div class="col-12 col-lg-4">
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100">
                        <h3 class="font-heading text-primary-custom fw-bold mb-3">
                            <i class="fa-solid fa-box me-2"></i>Produk
                        </h3>
                        @if ($order->product->image)
                            <img src="{{ asset('uploads/' . $order->product->image) }}" class="img-fluid rounded-3 mb-3"
                                alt="{{ $order->product->name }}" style="height: 160px; width: 100%; object-fit: cover;">
                        @endif
                        <p class="fw-semibold mb-1">{{ $order->product->name }}</p>
                        <p class="text-muted small mb-3">Rp {{ number_format($order->product->price, 0, ',', '.') }}</p>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Jumlah</span>
                            <span class="fw-semibold">{{ $order->quantity }}</span>
                        </div>
                        @if ($order->notes)
                            <div class="mt-3">
                                <p class="text-muted small mb-1">Catatan</p>
                                <p class="bg-surface-low rounded-3 p-3 small mb-0">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Customer --}}
                <div class="col-12 col-lg-4">
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100">
                        <h3 class="font-heading text-primary-custom fw-bold mb-3">
                            <i class="fa-solid fa-user me-2"></i>Customer
                        </h3>
                        <p class="fw-semibold mb-1">{{ $order->customer_name }}</p>
                        <p class="text-muted small mb-3">{{ $order->customer_phone }}</p>
                        @if ($order->customerWhatsAppUrl())
                            <a href="{{ $order->customerWhatsAppUrl() }}" target="_blank"
                                class="btn btn-success btn-sm d-inline-flex align-items-center gap-2">
                                <i class="fa-brands fa-whatsapp"></i>Chat Customer
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Total & status --}}
                <div class="col-12 col-lg-4">
                    <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100">
                        <h3 class="font-heading text-primary-custom fw-bold mb-3">
                            <i class="fa-solid fa-sack-dollar me-2"></i>Total &amp; Status
                        </h3>
                        <p class="font-heading fs-4 fw-bold text-primary-custom mb-4">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </p>
                        <p class="fw-semibold small text-muted mb-2">Ubah status:</p>
                        <form action="{{ route('order.update', $order->id) }}" method="POST" class="d-flex flex-wrap gap-2">
                            @csrf
                            @method('PATCH')
                            @foreach ($statuses as $s)
                                <button type="submit" name="status" value="{{ $s }}"
                                    class="btn btn-sm {{ $order->status === $s ? 'text-white' : 'btn-outline-secondary' }}"
                                    style="{{ $order->status === $s ? 'background-color: var(--primary-color);' : '' }}">
                                    {{ ucfirst($s) }}
                                </button>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
