@extends('layouts.staff')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold mb-4">Dashboard Staff</h1>

        <div class="card shadow border-0 p-3">
            <div class="table-responsive rounded">
                <table id="dashboardTable" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Alamat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <!-- jQuery dan DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dashboardTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('staff.dashboard.data') }}',
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
                        data: 'time_slot_label',
                        name: 'time_slot'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });
        });
    </script>
@endpush
