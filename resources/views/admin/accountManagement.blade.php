@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold mb-4">Management Akun</h1>
            <a href="{{ route('admin.accounts.create') }}" class="btn btn-success">
                <i class="bi bi-plus"></i> Tambah Akun
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card shadow border-0 p-3">
            <div class="table-responsive rounded">
                <table id="accounts-table" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-success">
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
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
                $('#accounts-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.accounts.data') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'phone_number',
                            name: 'phone_number'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    @endpush
