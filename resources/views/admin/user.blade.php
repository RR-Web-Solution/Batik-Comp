@extends('layouts.admin', ['withDataTables' => true, 'title' => 'User'])

@section('content')
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

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"
            style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-heading fw-bold text-primary-custom" id="addUserModalLabel">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="{{ route('user.create') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="userName" class="form-label fw-semibold">Nama</label>
                        <input name="name" type="text" class="form-control" id="userName"
                            placeholder="Masukkan nama lengap" required=""
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
@endsection
