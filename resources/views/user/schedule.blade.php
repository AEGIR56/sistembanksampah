@extends('layouts.user')

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

        <div class="p-4 shadow card border-0">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="pickupFormModal" tabindex="-1" aria-labelledby="pickupFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('pickup.submit') }}" id="pickupForm">
                    @csrf
                    <input type="hidden" name="selected_date" id="selected_date">

                    <div class="modal-header">
                        <h5 class="modal-title" id="pickupFormLabel">Form Penjemputan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Waktu Penjemputan</label>
                            <select name="time_slot" required class="form-select">
                                <option value="morning">Pagi</option>
                                <option value="afternoon">Siang</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Penjemputan</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Sampah & Berat</label>
                            <div id="waste-fields" class="d-flex flex-column gap-2"></div>
                            <button type="button" class="btn btn-link p-0 mt-1" onclick="addWasteField()">+ Tambah
                                Jenis</button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inject data waste_types dari controller -->
    <script type="application/json" id="waste-options">
    {!! json_encode($wasteTypes) !!}
</script>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        const calendarDays = @json($calendarDays);

        function getEventsFromCalendarDays() {
            const today = new Date();
            today.setHours(0, 0, 0, 0); // reset jam agar hanya bandingkan tanggal

            return calendarDays.map(day => {
                const eventDate = new Date(day.date);
                eventDate.setHours(0, 0, 0, 0);

                let color = 'green';
                let title = 'Tersedia';

                // Ubah status jika tersedia tapi tanggal sudah lewat
                if (day.status.toLowerCase() === 'tersedia' && eventDate < today) {
                    color = 'gray';
                    title = 'Expired';
                } else if (day.status === 'full') {
                    color = 'orange';
                    title = 'Penuh';
                } else if (day.status === 'closed') {
                    color = 'red';
                    title = 'Tutup';
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
                        html: '<div class="text-white small fw-semibold">' + arg.event.title + '</div>'
                    };
                },
                dateClick: function(info) {
                    const selected = calendarDays.find(day => day.date === info.dateStr);

                    // Jika tidak ada data di tanggal tsb → bukan tanggal tersedia
                    if (!selected) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanggal Tidak Tersedia',
                            text: 'Tanggal ini tidak tersedia untuk pickup.'
                        });
                        return;
                    }

                    // Cek apakah tanggal yang dipilih sudah lewat
                    const clickedDate = new Date(info.dateStr);
                    clickedDate.setHours(0, 0, 0, 0);

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (selected.status.toLowerCase() === 'tersedia' && clickedDate < today) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanggal Tersedia Sudah Expired',
                            text: 'Silakan pilih tanggal yang tersedia untuk pickup.'
                        });
                        return;
                    }

                    // Jika aman, tampilkan form modal
                    document.getElementById('selected_date').value = info.dateStr;
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();

                    document.getElementById('waste-fields').innerHTML = '';
                    addWasteField();
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

        });

        function hidePickupModal() {
            document.getElementById('pickupFormModal').style.display = 'none';
        }

        const form = document.getElementById('pickupForm');

        form.addEventListener('submit', function(e) {
            const wasteFields = document.querySelectorAll('#waste-fields > div');
            if (wasteFields.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Form Belum Lengkap',
                    text: 'Silakan tambahkan minimal satu jenis sampah untuk dijemput.'
                });
            }
        });

        function addWasteField() {
            const container = document.getElementById('waste-fields');
            const id = 'waste-' + Date.now();
            const options = JSON.parse(document.getElementById('waste-options').textContent);

            let selectHTML = `<select name="waste_type_id[]" class="form-select" required>
                        <option value="">-- Pilih Jenis Sampah --</option>`;
            options.forEach(opt => {
                selectHTML += `<option value="${opt.id}">${opt.type}</option>`;
            });
            selectHTML += `</select>`;

            const field = `
        <div class="d-flex gap-2 align-items-center mb-2" id="${id}">
            <div class="flex-grow-1">${selectHTML}</div>
            <input type="number" name="weight[]" step="0.1" min="0.1" class="form-control" style="max-width: 80px;" placeholder="kg" required>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeWasteField('${id}')">✕</button>
        </div>
    `;
            container.insertAdjacentHTML('beforeend', field);
        }

        function removeWasteField(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }
    </script>
@endpush
