<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-success">
            <div class="bg-success text-white modal-header">
                <h5 class="modal-title" id="reportModalLabel">Laporan Pickup</h5>
                <input type="hidden" name="pickup_id" id="pickup_id">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="reportForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Staff:</label>
                        <input type="text" id="staff_name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Nama User:</label>
                        <input type="text" id="user_name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>No. Telepon:</label>
                        <input type="text" id="phone_number" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Alamat:</label>
                        <textarea id="address" class="form-control" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Pickup:</label>
                        <input type="text" id="pickup_date" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Waktu Pickup:</label>
                        <input type="text" id="pickup_time" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Sampah:</label>
                        <input type="text" id="trash_type" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Berat oleh User (kg):</label>
                        <input type="text" id="user_weight" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Berat oleh Staff (kg):</label>
                        <input type="number" name="staff_weight" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Detail Laporan:</label><br>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="detail[]" value="Berat tidak sesuai"
                                id="detail1">
                            <label class="form-check-label" for="detail1">Berat tidak sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="detail[]" value="Alamat tidak sesuai"
                                id="detail2">
                            <label class="form-check-label" for="detail2">Alamat tidak sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="detail[]"
                                value="User tidak dapat dihubungi" id="detail3">
                            <label class="form-check-label" for="detail3">User tidak dapat dihubungi</label>
                        </div>
                        <textarea name="note" class="form-control mt-3" placeholder="Tambahkan catatan lain..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Upload Gambar (maks 3):</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Status Laporan:</label>
                        <select name="status_report" class="form-select" required>
                            <option value="pickup selesai">Pickup Selesai</option>
                            <option value="pickup ditolak">Pickup Ditolak</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="confirmReportSubmission()">Simpan</button>
            </div>
        </div>
    </div>
</div>


{{-- <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="reportModalLabel">Isi Laporan Pickup</h5>
                <input type="hidden" name="pickup_id" id="pickup_id">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form id="reportForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama Staff:</label>
                        <input type="text" id="staff_name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Nama User:</label>
                        <input type="text" id="user_name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>No. Telepon:</label>
                        <input type="text" id="phone_number" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Alamat:</label>
                        <textarea id="address" class="form-control" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Pickup:</label>
                        <input type="text" id="pickup_date" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Waktu Pickup:</label>
                        <input type="text" id="pickup_time" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Sampah:</label>
                        <input type="text" id="trash_type" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Berat oleh User (kg):</label>
                        <input type="text" id="user_weight" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Berat oleh Staff (kg):</label>
                        <input type="number" name="staff_weight" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Detail Laporan:</label><br>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="detail[]"
                                value="Berat tidak sesuai" id="detail1">
                            <label class="form-check-label" for="detail1">Berat tidak sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="detail[]"
                                value="Alamat tidak sesuai" id="detail2">
                            <label class="form-check-label" for="detail2">Alamat tidak sesuai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="detail[]"
                                value="User tidak dapat dihubungi" id="detail3">
                            <label class="form-check-label" for="detail3">User tidak dapat dihubungi</label>
                        </div>
                        <textarea name="note" class="form-control mt-2" placeholder="Catatan lain..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Upload Gambar (maks 3):</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Status Laporan:</label>
                        <select name="status_report" class="form-select" required>
                            <option value="">-- Pilih Status Pickup --</option>
                            <option value="pickup selesai">Pickup Selesai</option>
                            <option value="pickup ditolak">Pickup Ditolak</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success"
                        onclick="confirmReportSubmission()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<script>
    function confirmReportSubmission() {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah laporan sudah benar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#198754',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('reportForm');
                const formData = new FormData(form);
                const pickupId = document.getElementById('pickup_id').value;

                fetch(`/staff/pickups/${pickupId}/report`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    })
                    .then(async (res) => {
                        const data = await res.json();

                        if (!res.ok) {
                            // Jika status bukan 200
                            let errorMsg = data.message || 'Terjadi kesalahan.';

                            // Jika ada error detail (misal validasi)
                            if (data.errors) {
                                errorMsg += '\n\n' + Object.values(data.errors).map(e => `- ${e}`).join(
                                    '\n');
                            }

                            throw new Error(errorMsg);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Laporan berhasil disimpan.',
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.message || 'Terjadi kesalahan saat menyimpan laporan.',
                            confirmButtonColor: '#dc3545'
                        });
                    });
            }
        });
    }
</script>
