<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>User - Batik Nusantara</title>
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
    <!-- DataTables: core + buttons + responsive -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.min.css">
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="font-heading text-primary-custom fw-bold mb-0">Manajemen User</h2>
                <button class="btn text-white" style="background-color: var(--primary-color);" data-bs-toggle="modal"
                    data-bs-target="#addUserModal">
                    <i class="fa-solid fa-plus me-2"></i>Tambah User
                </button>
            </div>
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
                <div class="table-responsive">
                    <table class="table table-hover align-middle js-datatable">
                        <thead class="table-light">
                            <tr>
                                <th class="font-heading">Nama</th>
                                <th class="font-heading">Email</th>
                                <th class="font-heading">Password</th>
                                <th class="font-heading text-center no-export">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $u)
                                <tr>
                                    <td class="fw-semibold">{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>••••••••</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $u->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form id="deleteUserForm-{{ $u->id }}" action="{{ route('user.delete', $u->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
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
        </div>
    </main>
    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title font-heading fw-bold text-primary-custom" id="addUserModalLabel">Tambah User
                        Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" action="{{ route('user.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="userName" class="form-label fw-semibold">Nama</label>
                            <input name="name" type="text" class="form-control" id="userName"
                                placeholder="Masukkan nama lengkap" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label fw-semibold">Email</label>
                            <input name="email" type="email" class="form-control" id="userEmail"
                                placeholder="admin@example.com" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label fw-semibold">Password</label>
                            <input name="password" type="password" class="form-control" id="userPassword"
                                placeholder="••••••••" required="" style="border-color: var(--border-color);">
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" form="addUserForm" class="btn text-white"
                                style="background-color: var(--primary-color);">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($user as $u)
    <div class="modal fade" id="editUserModal-{{ $u->id }}" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $u->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title font-heading fw-bold text-primary-custom" id="editUserModalLabel-{{ $u->id }}">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm-{{ $u->id }}" action="{{ route('user.edit', $u->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editUserName-{{ $u->id }}" class="form-label fw-semibold">Nama</label>
                            <input name="name" type="text" class="form-control" id="editUserName-{{ $u->id }}"
                                value="{{ $u->name }}" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail-{{ $u->id }}" class="form-label fw-semibold">Email</label>
                            <input name="email" type="email" class="form-control" id="editUserEmail-{{ $u->id }}"
                                value="{{ $u->email }}" required=""
                                style="border-color: var(--border-color);">
                        </div>
                        <div class="mb-3">
                            <label for="editUserPassword-{{ $u->id }}" class="form-label fw-semibold">Password</label>
                            <input name="password" type="password" class="form-control" id="editUserPassword-{{ $u->id }}"
                                placeholder="••••••••" style="border-color: var(--border-color);">
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" form="editUserForm-{{ $u->id }}" class="btn text-white"
                                style="background-color: var(--primary-color);">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- jQuery → DataTables core → Buttons(+html5+print) → JSZip & pdfmake → Responsive --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>

    <script>
        if (window.jQuery && $.fn.DataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                pageLength: 10,
                responsive: true,
                dom: '<"dt-toolbar"lBf>rt<"dt-footer"ip>',
                columnDefs: [
                    { orderable: false, targets: [0, -1] },
                    { responsivePriority: 1, targets: -1 },
                    { responsivePriority: 2, targets: 0 },
                ],
                buttons: [
                    { extend: 'copy', text: '<i class="fa-solid fa-copy"></i> Salin', exportOptions: { columns: ':not(.no-export)' } },
                    { extend: 'csv', text: '<i class="fa-solid fa-file-csv"></i> CSV', exportOptions: { columns: ':not(.no-export)' } },
                    { extend: 'excel', text: '<i class="fa-solid fa-file-excel"></i> Excel', exportOptions: { columns: ':not(.no-export)' } },
                    { extend: 'pdf', text: '<i class="fa-solid fa-file-pdf"></i> PDF', exportOptions: { columns: ':not(.no-export)' }, orientation: 'landscape' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', exportOptions: { columns: ':not(.no-export)' } },
                ],
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ baris',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ baris',
                    infoEmpty: 'Tidak ada data, Menampilkan 0 baris',
                    infoFiltered: '(disaring dari _MAX_ baris)',
                    zeroRecords: 'Tidak ditemukan hasil yang cocok',
                    emptyTable: 'Belum ada data',
                    paginate: { first: '«', previous: '‹', next: '›', last: '»' },
                },
            });

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('table.js-datatable').forEach(function (t) {
                    $(t).DataTable();
                });
            });
        }
    </script>
</body>

</html>
