@extends('layouts.staff')

@section('content')
    <style>
        /* ========================1. Global Font & Layout=========================== */
        .fc {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
        }

        /* Responsive calendar height */
        #calendar {
            min-height: 400px;
            max-height: 80vh;
        }

        /* ========================2. Toolbar & Buttons=========================== */
        .fc-toolbar-title {
            color: #008000;
            font-weight: 600;
        }

        .fc-button {
            background-color: #008000 !important;
            border: none !important;
            font-weight: 500;
            text-transform: capitalize;
        }

        .fc-button:hover {
            background-color: #006400 !important;
        }

        /* ========================3. Header (Hari)=========================== */
        /* Header box (nama hari: Sun, Mon, dst) */
        .fc-col-header-cell {
            background: #bbbbbb;
            border: none;
            padding: 20px 20px;
        }

        /* Teks nama hari */
        .fc-col-header-cell-cushion {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            text-transform: capitalize;
            padding: 8px 0;
        }

        /* Hilangkan border bawah header */
        .fc .fc-scrollgrid-section-header td,
        .fc .fc-scrollgrid-section-header th {
            border-bottom: none !important;
            box-shadow: none;
            text-decoration: none;
        }

        /* Responsive ukuran nama hari */
        @media (max-width: 768px) {
            .fc-col-header-cell-cushion {
                font-size: 12px;
            }
        }

        /* ========================4. Hari & Tanggal=========================== */
        /* Nomor tanggal biasa */
        .fc-daygrid-day-number {
            font-size: 16px;
            font-weight: 700;
            color: #212529;
            padding: 6px;
        }

        /* Nomor tanggal hari ini */
        .fc-day-today .fc-daygrid-day-number {
            color: #008000;
            font-size: 18px;
            font-weight: 800;
        }

        /* Zebra strip (hari genap) - turunkan prioritas */
        .fc-daygrid-day:nth-child(even):not(.fc-day-today) .fc-daygrid-day-frame {
            background-color: #f5f5f5;
        }

        /* Highlight background hari ini */
        .fc-day-today .fc-daygrid-day-frame {
            background-color: #d3ffd3 !important;
            z-index: 2;
            position: relative;
        }


        /* ========================5. Event Box=========================== */
        .fc-event {
            border-radius: 6px;
            padding: 2px 6px;
            font-size: 13px;
        }

        /* ========================6. Remove All Grid Borders=========================== */
        .fc-daygrid-day-frame,
        .fc-scrollgrid,
        .fc-scrollgrid td,
        .fc-scrollgrid th {
            border: none !important;
        }
    </style>
    <div class="container py-4">
        <h1 class="fw-bold mb-4">Dashboard Staff</h1>
        <div class="container-fluid ">
            <h1 class="fw-bold mb-4 text-center">Schedule Management</h1>
            <h5 id="customDateTitle" class="mb-3 text-success text-center"></h5>
        </div>

        <div class="p-4 shadow card border-0 mb-4">
            <div id="calendar"></div>
        </div>

        <div class="card shadow border-0 p-3">
            <div class="card-header d-flex justify-content-center align-items-center border-0 mb-3">
                <h5 class="mb-0 fw-bold">Data Laporan Pickup</h5>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
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

        const calendarDays = @json($calendarDays);

        function getEventsFromCalendarDays() {
            const today = new Date();
            today.setHours(0, 0, 0, 0); // reset jam agar hanya bandingkan tanggal

            return calendarDays.map(day => {
                const eventDate = new Date(day.date);
                eventDate.setHours(0, 0, 0, 0);

                let color = 'green';
                let title = 'Bertugas';

                // Ubah status jika tersedia tapi tanggal sudah lewat
                if (day.status.toLowerCase() === 'tersedia' && eventDate < today) {
                    color = 'gray';
                    title = 'Expired';
                } else if (day.status === 'penuh') {
                    color = 'orange';
                    title = 'Penuh';
                } else if (day.status === 'libur') {
                    color = 'red';
                    title = 'Libur';
                }

                return {
                    title: title,
                    start: day.date,
                    color: color
                };
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('pickupFormModal');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'local',
                locale: 'id',
                height: 600,
                selectable: true,
                buttonText: {
                    today: 'Hari Ini'
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                eventDisplay: 'block',
                events: getEventsFromCalendarDays(),
                datesSet: function(view) {
                    updateCustomTitle(view);
                },
                eventContent: function(arg) {
                    return {
                        html: '<div class="text-white small fw-semibold">' + arg.event
                            .title + '</div>'
                    };
                },
            });

            calendar.render();

            function updateCustomTitle() {
                const now = new Date().toLocaleString('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                document.getElementById('customDateTitle').innerText = now;
            }
        });
    </script>
@endpush
