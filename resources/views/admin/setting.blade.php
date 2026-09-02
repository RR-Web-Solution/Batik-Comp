@extends('layouts.admin', ['withDataTables' => false, 'title' => 'Pengaturan'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="font-heading text-primary-custom fw-bold mb-0">Pengaturan Website</h2>
</div>

<form action="{{ route('setting.update', $setting->id ?? 0) }}" method="POST" class="row g-3">
    @csrf
    @method('PUT')

    <div class="col-12 col-lg-6">
        <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow h-100">
            <h3 class="font-heading text-primary-custom fw-bold mb-3">
                <i class="fa-solid fa-tag me-2"></i>Identitas Toko
            </h3>
            <div class="mb-3">
                <label for="settingSiteName" class="form-label fw-semibold">Nama Toko</label>
                <input name="site_name" type="text" class="form-control" id="settingSiteName"
                    value="{{ old('site_name', $setting->site_name ?? '') }}" required=""
                    style="border-color: var(--border-color);">
            </div>
            <div class="mb-3">
                <label for="settingTagline" class="form-label fw-semibold">Tagline</label>
                <input name="tagline" type="text" class="form-control" id="settingTagline"
                    value="{{ old('tagline', $setting->tagline ?? '') }}" placeholder="Rumah batik artisanal..."
                    style="border-color: var(--border-color);">
            </div>
            <div class="mb-3">
                <label for="settingAbout" class="form-label fw-semibold">Tentang Kami</label>
                <textarea name="about_text" class="form-control" id="settingAbout" rows="4"
                    placeholder="Cerita singkat tentang bisnis Anda"
                    style="border-color: var(--border-color);">{{ old('about_text', $setting->about_text ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="d-flex flex-column gap-3 h-100">
            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
                <h3 class="font-heading text-primary-custom fw-bold mb-3">
                    <i class="fa-solid fa-phone me-2"></i>Kontak &amp; Lokasi
                </h3>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label for="settingWhatsapp" class="form-label fw-semibold">No. WhatsApp (format 62…)</label>
                        <input name="whatsapp_number" type="text" class="form-control" id="settingWhatsapp"
                            value="{{ old('whatsapp_number', $setting->whatsapp_number ?? '') }}" required=""
                            placeholder="628xxxxxxxxx" style="border-color: var(--border-color);">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="settingEmail" class="form-label fw-semibold">Email</label>
                        <input name="email" type="email" class="form-control" id="settingEmail"
                            value="{{ old('email', $setting->email ?? '') }}" placeholder="hello@batiknusantara.id"
                            style="border-color: var(--border-color);">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="settingHours" class="form-label fw-semibold">Jam Buka</label>
                        <input name="opening_hours" type="text" class="form-control" id="settingHours"
                            value="{{ old('opening_hours', $setting->opening_hours ?? '') }}"
                            placeholder="Senin - Sabtu, 09.00 - 17.00 WIB" style="border-color: var(--border-color);">
                    </div>
                    <div class="col-12">
                        <label for="settingAddress" class="form-label fw-semibold">Alamat</label>
                        <textarea name="address" class="form-control" id="settingAddress" rows="2"
                            placeholder="Jl. Batik Nusantara No. 8, Jakarta Selatan"
                            style="border-color: var(--border-color);">{{ old('address', $setting->address ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-surface-lowest border border-outline-variant rounded-4 p-4 ambient-shadow">
                <h3 class="font-heading text-primary-custom fw-bold mb-3">
                    <i class="fa-solid fa-share-nodes me-2"></i>Sosial Media
                </h3>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label for="settingInstagram" class="form-label fw-semibold">Username Instagram</label>
                        <input name="instagram_usn" type="text" class="form-control" id="settingInstagram"
                            value="{{ old('instagram_usn', $setting->instagram_usn ?? '') }}"
                            placeholder="batiknusantara" style="border-color: var(--border-color);">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="settingFacebook" class="form-label fw-semibold">Username Facebook</label>
                        <input name="facebook_usn" type="text" class="form-control" id="settingFacebook"
                            value="{{ old('facebook_usn', $setting->facebook_usn ?? '') }}"
                            placeholder="batiknusantara" style="border-color: var(--border-color);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn text-white label-caps px-4"
            style="background-color: var(--primary-color);">
            <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Pengaturan
        </button>
    </div>
</form>
@endsection
