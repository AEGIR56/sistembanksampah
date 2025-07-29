@extends('layouts.staff')

@section('content')
    <style>
        .modal-dialog-scrollable .modal-content {
            max-height: 90vh;
            overflow: hidden;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
    <div class="container py-4">
        <h1 class="fw-bold mb-4">Daftar Pickup</h1>

        <div class="card shadow border-0 p-3">
            <div class="table-responsive rounded">
                <table id="pickup-table" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Jenis</th>
                            <th>Berat /Kg</th>
                            <th>Status Pickup</th>
                            <th>Transaksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('staff.reportmodal')
@endsection
@push('scripts')
    <!-- jQuery (pastikan dimuat sebelum DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables & Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pickup-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('staff.pickups.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user.username'
                    },
                    {
                        data: 'pickup_date',
                        name: 'pickup_date'
                    },
                    {
                        data: 'time_slot',
                        name: 'time_slot'
                    },
                    {
                        data: 'waste_type',
                        name: 'wasteType.type'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
                    },
                    {
                        data: 'status_column',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'transaksi',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        function updateStatus(id, status) {
            fetch(`/staff/pickups/${id}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status
                    })
                })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(text);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status pickup berhasil diperbarui.',
                            confirmButtonColor: '#198754',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // ✅ Reload setelah perubahan status
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Status tidak dapat diperbarui.',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal menghubungi server.',
                        confirmButtonColor: '#dc3545'
                    });
                });
        }

        function openReportModal(id) {
            fetch(`/staff/api/pickups/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('reportModalLabel').innerText = `Laporan Pickup #${data.id}`;
                    document.getElementById('pickup_id').value = data.id;
                    document.getElementById('staff_name').value = data.staff_name ?? '-';
                    document.getElementById('user_name').value = data.user_name ?? '-';
                    document.getElementById('phone_number').value = data.phone_number ?? '-';
                    document.getElementById('address').value = data.address ?? '-';
                    document.getElementById('pickup_date').value = data.pickup_date ?? '-';
                    document.getElementById('pickup_time').value = data.time_slot ?? '-'; // FIXED
                    document.getElementById('trash_type').value = data.waste_type ?? '-'; // FIXED
                    document.getElementById('user_weight').value = data.weight ?? '-'; // FIXED

                    const modal = new bootstrap.Modal(document.getElementById('reportModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Gagal', 'Gagal memuat data pickup.', 'error');
                });
        }


        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('reportModal').style.display = 'none';
            }
        });

        document.getElementById('reportModal').addEventListener('click', function(e) {
            if (e.target.id === 'reportModal') {
                e.target.style.display = 'none';
            }
        });
    </script>
@endpush
