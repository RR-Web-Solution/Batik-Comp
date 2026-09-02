@extends('layouts.admin', ['withDataTables' => true, 'title' => 'Kategori'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-heading text-primary-custom fw-bold mb-0">Manajemen Kategori</h2>
    <button class="btn text-white" style="background-color: var(--primary-color);" data-bs-toggle="modal"
        data-bs-target="#addCategoryModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Kategori
    </button>
</div>
<div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
    <div class="table-responsive">
        <table class="table table-hover align-middle js-datatable">
            <thead class="table-light">
                <tr>
                    <th class="font-heading">Urutan</th>
                    <th class="font-heading no-export">Gambar</th>
                    <th class="font-heading">Nama</th>
                    <th class="font-heading">Deskripsi</th>
                    <th class="font-heading">Produk</th>
                    <th class="font-heading">Status</th>
                    <th class="font-heading text-center no-export">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category as $c)
                    <tr>
                        <td>{{ $c->sort_order }}</td>
                        <td>
                            @if ($c->image)
                                <img src="{{ asset('uploads/' . $c->image) }}" alt="{{ $c->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $c->name }}</td>
                        <td>{{ $c->description }}</td>
                        <td>
                            <span class="badge text-bg-primary">{{ $c->products_count }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $c->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $c->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $c->id }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form id="deleteCategoryForm-{{ $c->id }}" action="{{ route('category.delete', $c->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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

<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"
            style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-heading fw-bold text-primary-custom" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="{{ route('category.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="kategoriName" class="form-label fw-semibold">Nama</label>
                        <input name="name" type="text" class="form-control" id="kategoriName"
                            placeholder="Masukkan nama kategori" required=""
                            style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="kategoriDescription" class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" id="kategoriDescription" rows="2"
                            placeholder="Masukkan deskripsi kategori" style="border-color: var(--border-color);"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kategoriSortOrder" class="form-label fw-semibold">Urutan</label>
                        <input name="sort_order" type="number" class="form-control" id="kategoriSortOrder"
                            placeholder="0" value="0" style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="kategoriActive" checked>
                        <label class="form-check-label fw-semibold" for="kategoriActive">Aktif</label>
                    </div>
                    <div class="mb-3">
                        <label for="kategoriImage" class="form-label fw-semibold">Gambar</label>
                        <input name="image" type="file" class="form-control" id="kategoriImage"
                            accept="image/jpeg,image/png,image/webp" style="border-color: var(--border-color);">
                        <div class="form-text">Format: JPG, PNG, WebP</div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" form="addCategoryForm" class="btn text-white"
                            style="background-color: var(--primary-color);">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($category as $c)
<div class="modal fade" id="editCategoryModal-{{ $c->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel-{{ $c->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"
            style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-heading fw-bold text-primary-custom" id="editCategoryModalLabel-{{ $c->id }}">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm-{{ $c->id }}" action="{{ route('category.edit', $c->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($c->image)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Saat Ini</label>
                            <img src="{{ asset('uploads/' . $c->image) }}" alt="{{ $c->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="editCategoryName-{{ $c->id }}" class="form-label fw-semibold">Nama</label>
                        <input name="name" type="text" class="form-control" id="editCategoryName-{{ $c->id }}"
                            value="{{ $c->name }}" required=""
                            style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="editCategoryDescription-{{ $c->id }}" class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" id="editCategoryDescription-{{ $c->id }}" rows="2"
                            style="border-color: var(--border-color);">{{ $c->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editCategorySortOrder-{{ $c->id }}" class="form-label fw-semibold">Urutan</label>
                        <input name="sort_order" type="number" class="form-control" id="editCategorySortOrder-{{ $c->id }}"
                            value="{{ $c->sort_order }}" style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editCategoryActive-{{ $c->id }}" @checked($c->is_active)>
                        <label class="form-check-label fw-semibold" for="editCategoryActive-{{ $c->id }}">Aktif</label>
                    </div>
                    <div class="mb-3">
                        <label for="editCategoryImage-{{ $c->id }}" class="form-label fw-semibold">Ganti Gambar</label>
                        <input name="image" type="file" class="form-control" id="editCategoryImage-{{ $c->id }}"
                            accept="image/jpeg,image/png,image/webp" style="border-color: var(--border-color);">
                        <div class="form-text">Format: JPG, PNG, WebP. Kosongkan untuk mempertahankan gambar saat ini.</div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" form="editCategoryForm-{{ $c->id }}" class="btn text-white"
                            style="background-color: var(--primary-color);">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
