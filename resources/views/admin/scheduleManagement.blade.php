@extends('layouts.admin')

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
        <div class="container-fluid ">
            <h1 class="fw-bold mb-4 text-center">Schedule Management</h1>
            <h5 id="customDateTitle" class="mb-3 text-success text-center"></h5>
        </div>
        <!-- FullCalendar CDN -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/main.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>

        <!-- Calendar -->
        <div class="p-4 shadow card border-0">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <form id="editForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="date" id="edit-date">

                    <div class="mb-3">
                        <label for="edit-status" class="form-label">Status</label>
                        <select name="status" id="edit-status" class="form-select">
                            <option value="">-- Pilih Status --</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="penuh">Penuh</option>
                            <option value="libur">Libur</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-staff" class="form-label">Staff Penanggung Jawab</label>
                        <select name="staff_id" id="edit-staff" class="form-select">
                            <option value="">-- Pilih Penanggung Jawab --</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger me-auto" onclick="deleteSchedule()">Hapus</button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
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
                dateClick: function(info) {
                    const clickedDate = new Date(info.dateStr);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Reset jam supaya bandingkan tanggal saja

                    if (clickedDate < today) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanggal sudah berlalu',
                            text: 'Kamu tidak bisa menjadwalkan di hari yang sudah lewat.',
                        });
                        return;
                    }

                    showModal(info.dateStr);
                },

                events: @json($events),
                datesSet: function(view) {
                    updateCustomTitle(view);
                }
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

            window.showModal = function(dateStr) {
                document.getElementById('edit-date').value = dateStr;
                const bsModal = new bootstrap.Modal(document.getElementById('editModal'));
                bsModal.show();
            }

            window.deleteSchedule = function() {
                const date = document.getElementById('edit-date').value;
                Swal.fire({
                    title: `Hapus data ${date}?`,
                    text: "Data ini akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route('admin.calendar.delete') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    date
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire('Berhasil!', 'Data berhasil dihapus.', 'success')
                                    .then(() => location.reload());
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus.', 'error');
                            });
                    }
                });
            }

            document.getElementById('editForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('{{ route('admin.calendar.update') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire('Berhasil!', 'Jadwal berhasil disimpan.', 'success')
                            .then(() => {
                                bootstrap.Modal.getInstance(document.getElementById('editModal'))
                                    .hide();
                                location.reload();
                            });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan.', 'error');
                    });
            });

        });
    </script>
@endpush
