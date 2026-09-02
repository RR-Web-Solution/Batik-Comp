@extends('layouts.admin', ['withDataTables' => true, 'title' => 'Produk'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-heading text-primary-custom fw-bold mb-0">Manajemen Produk</h2>
    <button class="btn text-white" style="background-color: var(--primary-color);" data-bs-toggle="modal"
        data-bs-target="#addProductModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Produk
    </button>
</div>
<div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
    <div class="table-responsive">
        <table class="table table-hover align-middle js-datatable">
            <thead class="table-light">
                <tr>
                    <th class="font-heading no-export">Gambar</th>
                    <th class="font-heading">Nama</th>
                    <th class="font-heading">Kategori</th>
                    <th class="font-heading">Deskripsi</th>
                    <th class="font-heading">Harga</th>
                    <th class="font-heading">Pilihan</th>
                    <th class="font-heading text-center no-export">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product as $u)
                    <tr>
                        <td>
                            @if ($u->image)
                                <img src="{{ asset('uploads/' . $u->image) }}" alt="{{ $u->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $u->name }}</td>
                        <td>
                            @if ($u->category)
                                <span class="badge text-bg-primary">{{ $u->category->name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $u->description }}</td>
                        <td>Rp {{ number_format($u->price, 0, ',', '.') }}</td>
                        <td>
                            @if ($u->is_featured)
                                <span class="badge text-bg-success">Unggulan</span>
                            @else
                                <span class="badge text-bg-secondary">Biasa</span>
                            @endif
                        </td>
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

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"
            style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-heading fw-bold text-primary-custom" id="addProductModalLabel">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" action="{{ route('product.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="produkName" class="form-label fw-semibold">Nama</label>
                        <input name="name" type="text" class="form-control" id="produkName"
                            placeholder="Masukkan nama produk lengap" required=""
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
                    <div class="mb-3">
                        <label for="produkCategory" class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select" id="produkCategory"
                            style="border-color: var(--border-color);">
                            <option value="">— Tanpa Kategori —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="produkFeatured">
                        <label class="form-check-label fw-semibold" for="produkFeatured">Produk Unggulan (tampil di beranda)</label>
                    </div>
                    <div class="mb-3">
                        <label for="produkImage" class="form-label fw-semibold">Gambar</label>
                        <input name="image" type="file" class="form-control" id="produkImage"
                            accept="image/jpeg,image/png,image/webp" style="border-color: var(--border-color);">
                        <div class="form-text">Format: JPG, PNG, WebP</div>
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
                <form id="editProductForm-{{ $u->id }}" action="{{ route('product.edit', $u->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($u->image)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Saat Ini</label>
                            <img src="{{ asset('uploads/' . $u->image) }}" alt="{{ $u->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                        </div>
                    @endif
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
                    <div class="mb-3">
                        <label for="editProductCategory-{{ $u->id }}" class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select" id="editProductCategory-{{ $u->id }}"
                            style="border-color: var(--border-color);">
                            <option value="">— Tanpa Kategori —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected($u->category_id === $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="editProductFeatured-{{ $u->id }}" @checked($u->is_featured)>
                        <label class="form-check-label fw-semibold" for="editProductFeatured-{{ $u->id }}">Produk Unggulan (tampil di beranda)</label>
                    </div>
                    <div class="mb-3">
                        <label for="editProductImage-{{ $u->id }}" class="form-label fw-semibold">Ganti Gambar</label>
                        <input name="image" type="file" class="form-control" id="editProductImage-{{ $u->id }}"
                            accept="image/jpeg,image/png,image/webp" style="border-color: var(--border-color);">
                        <div class="form-text">Format: JPG, PNG, WebP. Kosongkan untuk mempertahankan gambar saat ini.</div>
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
@endsection
