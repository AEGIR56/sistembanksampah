@extends('layouts.user')

@section('content')
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.dashboard') }}" class="text-success text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Riwayat Transaksi
                </li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold mb-4">Riwayat Transaksi</h1>
        </div>

        <div class="card shadow border-0 p-3 mb-4">
            <div class="card-header d-flex justify-content-center align-items-center border-0 mb-3">
                <h5 class="mb-0 fw-bold">Tracking Data Laporan Sampah</h5>
            </div>
            <div class="table-responsive rounded">
                <table id="pickupTrackingTable" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pickup</th>
                            <th>Jadwal Pickup</th>
                            <th>Jenis Sampah</th>
                            <th>Berat (Kg)</th>
                            <th>Alamat</th>
                            <th>Disetujui Pada</th>
                            <th>Catatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Pickup History -->
        <div class="card shadow border-0 p-3 mb-4">
            <div class="card-header d-flex justify-content-center align-items-center border-0 mb-3">
                <h5 class="mb-0 fw-bold">Hasil Laporan Data Sampah</h5>
            </div>
            <div class="table-responsive rounded">
                <table id="pickupTable" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Sampah</th>
                            <th>Berat (Kg)</th>
                            <th>Nominal (Pts)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="card shadow border-0 p-3">
            <div class="card-header d-flex justify-content-center align-items-center border-0 mb-3">
                <h5 class="mb-0 fw-bold">Riwayat Penukaran Poin</h5>
            </div>
            <div class="table-responsive rounded">
                <table id="redeemTable" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-warning">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Item</th>
                            <th>Jumlah</th>
                            <th>Nominal (Pts)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#pickupTrackingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.pickup-tracking.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'pickup_time_badge',
                        name: 'pickup_time_badge',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        data: 'waste_type',
                        name: 'waste_type'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'approved_at',
                        name: 'approved_at'
                    },
                    {
                        data: 'approval_note',
                        name: 'approval_note'
                    },
                    {
                        data: 'status_badge',
                        name: 'status_badge',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
                            return data;
                        }
                    }
                ]
            });

            $('#pickupTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.transactions.pickup') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'waste_type',
                        name: 'waste_type'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
                    },
                ]
            });

            $('#redeemTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.transactions.redeem') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'point_used',
                        name: 'point_used'
                    },
                ]
            });
        });
    </script>
@endpush
