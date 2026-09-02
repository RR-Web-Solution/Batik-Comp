<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
            style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-heading fw-bold text-primary-custom" id="orderModalLabel">{{ __('messages.pesan_produk') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('order.store', ['locale' => App::getLocale()]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="orderProductId" value="">
                    <div class="bg-surface-low rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                        <span class="font-heading fw-bold text-primary-custom" id="orderProductNameDisplay"></span>
                        <span class="text-muted-custom fw-semibold" id="orderPriceDisplay"></span>
                    </div>
                    <div class="mb-3">
                        <label for="orderQuantity" class="form-label fw-semibold">{{ __('messages.jumlah') }}</label>
                        <input name="quantity" type="number" class="form-control" id="orderQuantity"
                            value="1" min="1" max="10000" required
                            style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="orderName" class="form-label fw-semibold">{{ __('messages.nama_lengkap') }}</label>
                        <input name="customer_name" type="text" class="form-control" id="orderName"
                            placeholder="{{ __('messages.nama_placeholder') }}" required value="{{ old('customer_name') }}"
                            style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="orderPhone" class="form-label fw-semibold">{{ __('messages.no_whatsapp') }}</label>
                        <input name="customer_phone" type="text" class="form-control" id="orderPhone"
                            placeholder="08xxxxxxxxxx" required value="{{ old('customer_phone') }}"
                            style="border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="orderNotes" class="form-label fw-semibold">{{ __('messages.catatan') }} <span class="text-muted fw-normal">({{ __('messages.catatan_opsional') }})</span></label>
                        <textarea name="notes" class="form-control" id="orderNotes" rows="2"
                            placeholder="{{ __('messages.catatan_placeholder') }}"
                            style="border-color: var(--border-color);">{{ old('notes') }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center bg-surface-low rounded-3 p-3">
                        <span class="fw-semibold">{{ __('messages.estimasi_total') }}</span>
                        <span class="font-headline headline-sm text-primary-custom" id="orderTotalDisplay">Rp 0</span>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('messages.batal') }}</button>
                    <button type="submit" class="btn text-white label-caps"
                        style="background-color: var(--primary-color);">
                        <i class="fa-brands fa-whatsapp me-2"></i>{{ __('messages.pesan_produk_btn') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
