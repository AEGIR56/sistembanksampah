<div id="itemDetailModal" class="modal fade show" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="detailName">Nama Item</h5>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <!-- Thumbnail -->
                <div class="text-center mb-3">
                    <div class="mx-auto"
                        style="aspect-ratio: 1 / 1; width: 100%; max-width: 300px; overflow: hidden; border-radius: 0.5rem;">
                        <img id="detailImage" src="" alt="Item Image"
                            class="img-fluid w-100 h-100 object-fit-cover">
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">Stok:</span>
                    <strong id="detailStock">0</strong>
                </div>

                <!-- Qty -->
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Jumlah:</span>
                    <div class="input-group" style="width: 130px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">−</button>
                        <input type="number" class="form-control text-center" id="detailQty" value="1"
                            min="1" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <!-- Subtotal -->
                <div class="mb-3 d-flex justify-content-between">
                    <span class="text-muted">Subtotal:</span>
                    <strong id="detailSubtotal">0 Poin</strong>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <input type="hidden" id="detailItemId">
                <input type="hidden" id="detailPrice">

                <button class="btn btn-success me-auto" onclick="addToCartFromModal()">
                    @include('icons.shopping-cart') Tambah ke Keranjang
                </button>
                <button class="btn btn-secondary" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>
