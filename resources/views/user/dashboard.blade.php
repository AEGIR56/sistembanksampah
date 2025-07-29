@extends('layouts.user')

@section('content')
    <style>
        @keyframes fadeSlideUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-6px);
            }

            60% {
                transform: translateY(3px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .animated-card {
            animation: fadeSlideUp 0.6s ease forwards;
            opacity: 0;
        }

        .icon-wrapper {
            transition: all 0.3s ease;
        }

        .card:hover .icon-wrapper {
            transform: scale(1.15);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card:hover .icon-wrapper i {
            animation: bounce 0.6s;
        }

        /* .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            } */

        .card:hover {
            /* transform: translateY(-5px); */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        }

        .hover-pointer {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .hover-pointer:hover {
            transform: scale(1.01);
        }
    </style>
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-4">Dashboard</h1>
        {{-- Cards --}}
        <div class="row g-4">
            @php
                $cards = [
                    [
                        'title' => 'Saldo Balance',
                        'value' => $balance_points ?? 0,
                        'suffix' => ' Points',
                        'icon' => 'bi-cash-stack',
                        'bg' => 'primary',
                    ],
                    [
                        'title' => 'Total Deposit Poin',
                        'value' => $total_deposit_points ?? 0,
                        'suffix' => ' Points',
                        'icon' => 'bi-cash-stack',
                        'bg' => 'warning',
                    ],
                    [
                        'title' => 'Total Penukaran Poin',
                        'value' => $exchange_points ?? 0,
                        'suffix' => ' Points',
                        'icon' => 'bi-arrow-left-right',
                        'bg' => 'success',
                    ],
                    [
                        'title' => 'Total Penjemputan',
                        'value' => $total_pickup ?? 0,
                        'suffix' => '',
                        'icon' => 'bi-truck',
                        'bg' => 'danger',
                    ],
                    [
                        'title' => 'Total Berat Sampah',
                        'value' => $total_waste_kg ?? 0,
                        'suffix' => ' Kg',
                        'icon' => 'bi-trash3',
                        'bg' => 'purple',
                    ],
                    [
                        'title' => 'Pencapaian',
                        'value' => $achievement ?? 0,
                        'suffix' => '',
                        'icon' => 'bi-trophy',
                        'bg' => 'info',
                    ],
                ];
            @endphp

            @foreach ($cards as $index => $card)
                <div class="col-sm-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100 animated-card" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="card-body d-flex align-items-center">
                            <div class="d-flex justify-content-center align-items-center me-3 icon-wrapper"
                                style="width: 48px; height: 48px;
                                background-color: rgba(var(--bs-{{ $card['bg'] }}-rgb), 0.1);
                                color: var(--bs-{{ $card['bg'] }});
                                border-radius: 50%;">
                                <i class="bi {{ $card['icon'] }} fs-5"></i>
                            </div>


                            <div>
                                <div class="text-muted small">{{ $card['title'] }}</div>
                                <div class="fw-bold fs-5">
                                    <span class="count-up" data-target="{{ $card['value'] }}">0</span>{{ $card['suffix'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card shadow-sm border-0 p-3 mt-4">
            <div class="card-header d-flex justify-content-center align-items-center border-0 mb-3">
                <h5 class="mb-0 fw-bold"> Daftar Harga Sampah Hari Ini</h5>
            </div>
            <div class="table-responsive rounded">
                <table id="wasteTable" class="p-2 table table-striped rounded yajra-datatable">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Tipe Sampah</th>
                            <th>Poin/Kg</th>
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
            // Inisialisasi DataTables untuk tabel Harga Sampah
            $('#wasteTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.waste-types.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'points_per_kg',
                        name: 'points_per_kg'
                    }
                ]
            });

            // Event filter manual untuk tabel Waste
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#wasteTable tbody tr');
                    rows.forEach(row => {
                        const text = row.cells[1]?.textContent?.toLowerCase() || '';
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            }

            // Event filter manual untuk tabel Pickup
            const searchPickup = document.getElementById('searchPickup');
            if (searchPickup) {
                searchPickup.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#pickupTable tbody tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            }

            // Event filter manual untuk tabel Redeem
            const searchRedeem = document.getElementById('searchRedeem');
            if (searchRedeem) {
                searchRedeem.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#redeemTable tbody tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            }

            // Counter animasi angka berjalan
            const counters = document.querySelectorAll('.count-up');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'), 10);
                const duration = 1000; // Total waktu animasi (ms)
                const stepTime = 20; // Interval update (ms)
                const steps = duration / stepTime;
                const increment = target / steps;

                let current = 0;
                const counterInterval = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(counterInterval);
                    }
                    counter.innerText = new Intl.NumberFormat().format(Math.floor(current));
                }, stepTime);
            });
        });
    </script>
@endpush
