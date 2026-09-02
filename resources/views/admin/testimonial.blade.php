@extends('layouts.admin', ['withDataTables' => true, 'title' => 'Testimonial'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-heading text-primary-custom fw-bold mb-0">Manajemen Testimonial</h2>
    <button class="btn text-white" style="background-color: var(--primary-color);" data-bs-toggle="modal"
        data-bs-target="#addTestimonialModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Testimonial
    </button>
</div>
<div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
    <div class="table-responsive">
        <table class="table table-hover align-middle js-datatable">
            <thead class="table-light">
                <tr>
                    <th class="font-heading">Urutan</th>
                    <th class="font-heading">Nama</th>
                    <th class="font-heading">Jabatan</th>
                    <th class="font-heading">Rating</th>
                    <th class="font-heading">Pesan</th>
                    <th class="font-heading">Status</th>
                    <th class="font-heading text-center no-export">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testimonial as $t)
                    <tr>
                        <td>{{ $t->sort_order }}</td>
                        <td class="fw-semibold">{{ $t->customer_name }}</td>
                        <td>{{ $t->customer_title }}</td>
                        <td>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $t->rating)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @else
                                    <i class="fa-regular fa-star text-warning"></i>
                                @endif
                            @endfor
                        </td>
                        <td>{{ Str::limit($t->content, 50) }}</td>
                        <td>
                            <span class="badge {{ $t->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $t->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editTestimonialModal-{{ $t->id }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form id="deleteTestimonialForm-{{ $t->id }}" action="{{ route('testimonial.delete', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus testimonial ini?')">
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

<!-- Add Testimonial Modal -->
<div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-labelledby="addTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"
            style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-heading fw-bold text-primary-custom" id="addTestimonialModalLabel">Tambah Testimonial Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTestimonialForm" action="{{ route('testimonial.create') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="customerName" class="form-label fw-semibold">Nama Pelanggan</label>
                        <input name="customer_name" type="text" class="form-control" id="customerName"
                            placeholder="Masukkan nama pelanggan" required
                            style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="customerTitle" class="form-label fw-semibold">Jabatan</label>
                        <input name="customer_title" type="text" class="form-control" id="customerTitle"
                            placeholder="Contoh: Pecinta Batik" style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="testimonialRating" class="form-label fw-semibold">Rating</label>
                        <select name="rating" class="form-select" id="testimonialRating" style="border-color: var(--border-color);">
                            <option value="5">5 - Sangat Bagus</option>
                            <option value="4">4 - Bagus</option>
                            <option value="3">3 - Cukup</option>
                            <option value="2">2 - Kurang</option>
                            <option value="1">1 - Sangat Kurang</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="testimonialContent" class="form-label fw-semibold">Pesan</label>
                        <textarea name="content" class="form-control" id="testimonialContent" rows="3"
                            placeholder="Tulis testimonial pelanggan" required style="border-color: var(--border-color);"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="testimonialSortOrder" class="form-label fw-semibold">Urutan</label>
                        <input name="sort_order" type="number" class="form-control" id="testimonialSortOrder"
                            placeholder="0" value="0" style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="testimonialActive" checked>
                        <label class="form-check-label fw-semibold" for="testimonialActive">Aktif</label>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" form="addTestimonialForm" class="btn text-white"
                            style="background-color: var(--primary-color);">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Testimonial Modals -->
@foreach ($testimonial as $t)
<div class="modal fade" id="editTestimonialModal-{{ $t->id }}" tabindex="-1" aria-labelledby="editTestimonialModalLabel-{{ $t->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"
            style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-heading fw-bold text-primary-custom" id="editTestimonialModalLabel-{{ $t->id }}">Edit Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTestimonialForm-{{ $t->id }}" action="{{ route('testimonial.edit', $t->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editCustomerName-{{ $t->id }}" class="form-label fw-semibold">Nama Pelanggan</label>
                        <input name="customer_name" type="text" class="form-control" id="editCustomerName-{{ $t->id }}"
                            value="{{ $t->customer_name }}" required style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="editCustomerTitle-{{ $t->id }}" class="form-label fw-semibold">Jabatan</label>
                        <input name="customer_title" type="text" class="form-control" id="editCustomerTitle-{{ $t->id }}"
                            value="{{ $t->customer_title }}" style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="editTestimonialRating-{{ $t->id }}" class="form-label fw-semibold">Rating</label>
                        <select name="rating" class="form-select" id="editTestimonialRating-{{ $t->id }}" style="border-color: var(--border-color);">
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" @selected($t->rating === $i)>{{ $i }} - @switch($i) @case(5) Sangat Bagus @break @case(4) Bagus @break @case(3) Cukup @break @case(2) Kurang @break @case(1) Sangat Kurang @break @endswitch</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTestimonialContent-{{ $t->id }}" class="form-label fw-semibold">Pesan</label>
                        <textarea name="content" class="form-control" id="editTestimonialContent-{{ $t->id }}" rows="3"
                            required style="border-color: var(--border-color);">{{ $t->content }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editTestimonialSortOrder-{{ $t->id }}" class="form-label fw-semibold">Urutan</label>
                        <input name="sort_order" type="number" class="form-control" id="editTestimonialSortOrder-{{ $t->id }}"
                            value="{{ $t->sort_order }}" style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editTestimonialActive-{{ $t->id }}" @checked($t->is_active)>
                        <label class="form-check-label fw-semibold" for="editTestimonialActive-{{ $t->id }}">Aktif</label>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" form="editTestimonialForm-{{ $t->id }}" class="btn text-white"
                            style="background-color: var(--primary-color);">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
