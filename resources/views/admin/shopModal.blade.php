<!-- Modal Tambah Item -->
<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.pointShopManagement.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Formulir Tambah Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Item</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="point_cost" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar (max 3)</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail/Edit Item -->
<div class="modal fade" id="itemDetailModal" tabindex="-1" aria-labelledby="itemDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <div style="aspect-ratio: 1 / 1; width: 100%; max-width: 200px;" class="mx-auto">
                            <img id="detailImage" src=""
                                class="img-fluid border rounded shadow w-100 h-100 object-fit-cover" alt="Item Image">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Detail Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td><span id="detailName"></span></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td><span id="detailStock"></span></td>
                                </tr>
                                <tr>
                                    <th>Poin</th>
                                    <td><span id="detailPoint"></span></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Form Edit -->
                        <form id="editForm" action="{{ route('admin.pointShopManagement.store') }}" method="POST"
                            class="d-none mt-4">
                            @csrf
                            <input type="hidden" name="id" id="editItemId" />
                            <div class="mb-3">
                                <label class="form-label">Nama Baru</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok Baru</label>
                                <input type="number" name="stock" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Poin Baru</label>
                                <input type="number" name="point_cost" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="toggleEditForm(false)">Batal Edit</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Aksi Tombol -->
            <div class="modal-footer">
                <button class="btn btn-warning text-white" onclick="toggleEditForm(true)">Edit</button>
                <button class="btn btn-danger" onclick="confirmDelete()">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Item Ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Tindakan ini tidak bisa dibatalkan.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <!-- Pastikan ini ada sebelum </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Global state item
        let selectedItem = null;

        function showItemDetail(item) {
            selectedItem = item;

            // Set data detail
            document.getElementById('detailImage').src = item.image_url;
            document.getElementById('detailName').innerText = item.name;
            document.getElementById('detailStock').innerText = item.stock;
            document.getElementById('detailPoint').innerText = item.point_cost;

            // Isi form edit
            document.getElementById('editItemId').value = item.id;
            document.querySelector('#editForm input[name="name"]').value = item.name;
            document.querySelector('#editForm input[name="stock"]').value = item.stock;
            document.querySelector('#editForm input[name="point_cost"]').value = item.point_cost;

            toggleEditForm(false); // Reset modal ke mode detail

            new bootstrap.Modal(document.getElementById('itemDetailModal')).show();
        }

        function toggleEditForm(show) {
            const form = document.getElementById('editForm');
            const actionButtons = document.getElementById('actionButtons');

            // Toggle form tampil
            form.classList.toggle('d-none', !show);

            // Tombol di footer
            const btnEdit = actionButtons.querySelector('.btn-warning');
            const btnDelete = actionButtons.querySelector('.btn-danger');
            const btnClose = actionButtons.querySelector('[data-bs-dismiss="modal"]');

            btnEdit.classList.toggle('d-none', show);
            btnDelete.classList.toggle('d-none', show);
            btnClose.classList.toggle('d-none', show);
        }

        // Reset form saat modal ditutup
        document.getElementById('itemDetailModal').addEventListener('hidden.bs.modal', function() {
            toggleEditForm(false);
        });

        function closeItemModal() {
            document.getElementById('itemDetailModal').classList.remove('show');
        }

        // Konfirmasi hapus
        function confirmDelete() {
            Swal.fire({
                title: 'Yakin ingin menghapus item ini?',
                text: "Data akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
@endpush
