@extends('layouts.user')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold mb-4">Riwayat Transaksi</h1>
        </div>
        <!-- Pickup History -->
        <div class="card shadow border-0 p-3 mb-4">
            <div class="table-responsive rounded">
                <table id="pickupTable" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Sampah</th>
                            <th>Jumlah (Kg)</th>
                            <th>Nominal (Pts)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="card shadow border-0 p-3">
            <div class="table-responsive rounded">
                <table id="redeemTable" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-success">
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
