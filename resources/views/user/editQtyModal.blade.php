<!-- Modal Edit Jumlah -->
<div class="modal fade" id="editQtyModal" tabindex="-1" aria-labelledby="editQtyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editQtyForm" method="POST" action="{{ route('user.cart.update') }}">
            @csrf
            <input type="hidden" name="item_id" id="edit-item-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQtyModalLabel">Edit Jumlah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-qty" class="form-label">Jumlah</label>
                        <input type="number" name="quantity" id="edit-qty" class="form-control" min="1"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
