<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Batik Admin - Batik Nusantara</title>
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
                    <img alt="Batik Nusantara Logo" class="rounded object-fit-cover"
                        src="https://lh3.googleusercontent.com/aida/AP1WRLudyyAt8ZB7awYRpuMI8z_Ab8YR0g9GymAfD2P3xCExUbi25yI7a5cGKjLUBeCOMNx1Wh77h02NCOpRefLSZINF1gWeffMZ9heVzLZAo2XsT6ds893HEFBppohD73ilcoU8z7aNmNDGhfEp0PidH5lP0l-2kbxGM1C8MebAMSsZGDp5YRpqyAQERY2LO0zRRr28TgyY_hWTBRSszOHASJi8KJjA1xXlNLgnaIkqBEsbDZEVNsgm79dBqa4"
                        style="width: 32px; height: 32px;" />
                </a>
                <span class="font-heading text-primary-custom fs-3 fw-semibold mb-0">Batik Nusantara</span>
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
    <main class="flex-grow-1 p-3 d-flex flex-column">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="font-heading text-primary-custom fw-bold mb-0">Manajemen Produk</h2>
                <button class="btn text-white" style="background-color: var(--primary-color);" data-bs-toggle="modal"
                    data-bs-target="#addProductModal">
                    <i class="fa-solid fa-plus me-2"></i>Tambah Produk
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="font-heading">Nama</th>
                            <th class="font-heading">Deskripsi</th>
                            <th class="font-heading">Harga</th>
                            <th class="font-heading text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $u)
                            <tr>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->description }}</td>
                                <td>{{ $u->price}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editProductModal-{{ $u->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form id="deleteProductForm-{{ $u->id }}" action="{{ route('product.delete', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title font-heading fw-bold text-primary-custom" id="addProductModalLabel">Tambah Produk
                        Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" action="{{ route('product.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="produkName" class="form-label fw-semibold">Nama</label>
                            <input name="name" type="text" class="form-control" id="produkName"
                                placeholder="Masukkan nama produk lengkap" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="produkDescription" class="form-label fw-semibold">Deskripsi</label>
                            <input name="description" type="text" class="form-control" id="produkDescription"
                                placeholder="Masukkan deskripsi produk" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="produkPrice" class="form-label fw-semibold">Harga</label>
                            <input name="price" type="text" class="form-control" id="produkPrice"
                                placeholder="Masukkan harga produk" required="" style="border-color: var(--border-color);">
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" form="addProductForm" class="btn text-white"
                                style="background-color: var(--primary-color);">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @foreach ($product as $u)
    <div class="modal fade" id="editProductModal-{{ $u->id }}" tabindex="-1" aria-labelledby="editProductModalLabel-{{ $u->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title font-heading fw-bold text-primary-custom" id="editProductModalLabel-{{ $u->id }}">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm-{{ $u->id }}" action="{{ route('product.edit', $u->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editProductName-{{ $u->id }}" class="form-label fw-semibold">Nama</label>
                            <input name="name" type="text" class="form-control" id="editProductName-{{ $u->id }}"
                                value="{{ $u->name }}" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription-{{ $u->id }}" class="form-label fw-semibold">Deskripsi</label>
                            <input name="description" type="text" class="form-control" id="editProductDescription-{{ $u->id }}"
                                value="{{ $u->description }}" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice-{{ $u->id }}" class="form-label fw-semibold">Harga</label>
                            <input name="price" type="text" class="form-control" id="editProductPrice-{{ $u->id }}"
                                value="{{ $u->price }}" required="" style="border-color: var(--border-color);">
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" form="editProductForm-{{ $u->id }}" class="btn text-white"
                                style="background-color: var(--primary-color);">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>
