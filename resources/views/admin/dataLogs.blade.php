@extends('layouts.admin')

@section('content')
    <style>
        #logTable thead th {
            vertical-align: middle;
        }

        #logTable td {
            vertical-align: middle;
        }
    </style>

    <div class="container py-4">
        <h1 class="fw-bold mb-4 text-center">Data Log Pengguna</h1>

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs mb-3" id="logTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-success" id="login-tab" data-bs-toggle="tab"
                    data-bs-target="#login" type="button" role="tab">
                    Login & Recovery
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-success" id="schedule-tab" data-bs-toggle="tab"
                    data-bs-target="#schedule" type="button" role="tab">
                    Schedule & Pickup
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-success" id="point-tab" data-bs-toggle="tab"
                    data-bs-target="#point" type="button" role="tab">
                    Point
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-success" id="other-tab" data-bs-toggle="tab"
                    data-bs-target="#other" type="button" role="tab">
                    Lain-lain
                </button>
            </li>
        </ul>


        <div class="tab-content">
            {{-- 1. Login Log --}}
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                @include('partials.log-table', ['logs' => $loginLogs, 'tableId' => 'logTableLogin'])
            </div>

            {{-- 2. Schedule Log --}}
            <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                @include('partials.log-table', ['logs' => $scheduleLogs, 'tableId' => 'logTableSchedule'])
            </div>

            {{-- 3. Point Log --}}
            <div class="tab-pane fade" id="point" role="tabpanel" aria-labelledby="point-tab">
                @include('partials.log-table', ['logs' => $pointLogs, 'tableId' => 'logTablePoint'])
            </div>

            {{-- 4. Other Log --}}
            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                @include('partials.log-table', ['logs' => $otherLogs, 'tableId' => 'logTableOther'])
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <!-- jQuery harus sebelum DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi awal hanya jika belum ada
            if (!$.fn.DataTable.isDataTable('#logTableLogin')) {
                $('#logTableLogin').DataTable({
                    pageLength: 10,
                    lengthMenu: [10, 30, 50, 100],
                });
            }

            // Inisialisasi tab dinamis
            const tableMap = {
                '#schedule': '#logTableSchedule',
                '#point': '#logTablePoint',
                '#other': '#logTableOther',
            };

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = e.target.getAttribute('data-bs-target');
                const tableId = tableMap[target];

                if (tableId && !$.fn.DataTable.isDataTable(tableId)) {
                    $(tableId).DataTable({
                        pageLength: 10,
                        lengthMenu: [10, 30, 50, 100],
                    });
                }
            });
        });
    </script>
@endpush
