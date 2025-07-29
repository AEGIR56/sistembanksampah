@extends('layouts.admin')

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

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
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
                        'title' => 'Total Deposit',
                        'value' => $deposit_points ?? 0,
                        'suffix' => ' Points',
                        'icon' => 'bi-calendar-check',
                        'bg' => 'success',
                    ],
                    [
                        'title' => 'Total Penukaran Poin',
                        'value' => $exchange_points ?? 0,
                        'suffix' => ' Points',
                        'icon' => 'bi-arrow-left-right',
                        'bg' => 'warning',
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
                        'title' => 'Total Member',
                        'value' => $total_members ?? 0,
                        'suffix' => '',
                        'icon' => 'bi-people',
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

        <div class="row g-4 mt-4">
            {{-- Card Pickup Approval --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100 hover-pointer {{ $pickups->isEmpty() ? 'disabled opacity-50' : '' }}"
                    @if (!$pickups->isEmpty()) data-bs-toggle="modal" data-bs-target="#pickupModal" @endif>
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex justify-content-center align-items-center me-3"
                            style="width: 48px; height: 48px; background-color: rgba(var(--bs-warning-rgb), 0.1); color: var(--bs-warning); border-radius: 50%;">
                            <i class="bi bi-truck fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Pickup Menunggu</div>
                            <div class="fw-bold fs-5">
                                @if ($pickups->isEmpty())
                                    Tidak Ada
                                @else
                                    {{ $pickups->count() }} Pickup
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Password Reset --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100 {{ $password_requests->isNotEmpty() ? 'hover-pointer' : 'opacity-50' }}"
                    @if ($password_requests->isNotEmpty()) data-bs-toggle="modal" data-bs-target="#resetModal" @endif>
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex justify-content-center align-items-center me-3"
                            style="width: 48px; height: 48px; background-color: rgba(var(--bs-danger-rgb), 0.1); color: var(--bs-danger); border-radius: 50%;">
                            <i class="bi bi-key fs-5"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Reset Password</div>
                            <div class="fw-bold fs-5">
                                {{ $password_requests->count() ?? 0 }} Permintaan
                            </div>
                            @if ($password_requests->isEmpty())
                                <small class="text-muted fst-italic">Tidak ada permintaan</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pickup -->
        <div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pickup Menunggu Persetujuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($pickups->isEmpty())
                            <p class="text-muted">Tidak ada pickup yang menunggu approval.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>User</th>
                                            <th>Tanggal</th>
                                            <th>Berat Staff</th>
                                            <th>Jenis</th>
                                            <th>Status</th>
                                            <th>Poin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pickups as $pickup)
                                            <tr>
                                                <td>{{ $pickup->pickup->user->username ?? '-' }}</td>
                                                <td>{{ $pickup->pickup_date }}</td>
                                                <td>{{ $pickup->report->berat_staff ?? '-' }} kg</td>
                                                <td>{{ $pickup->wasteType->type ?? '-' }}</td>
                                                <td>{{ ucfirst($pickup->status) }}</td>
                                                <td class="text-center">
                                                    {{ $pickup->report ? floor($pickup->report->berat_staff * ($pickup->wasteType->points_per_kg ?? 0)) : 0 }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.pickup.reject', $pickup->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="text" name="note" placeholder="Alasan" required
                                                            class="form-control form-control-sm mb-2">
                                                        <button class="btn btn-sm btn-danger">Tolak</button>
                                                    </form>
                                                    <form action="{{ route('admin.pickup.approve', $pickup->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-success">Setujui</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Reset Password -->
        <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Permintaan Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($password_requests->isEmpty())
                            <p class="text-muted">Tidak ada permintaan reset password.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($password_requests as $i => $request)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $request->user->username }}</td>
                                                <td>{{ $request->user->email }}</td>
                                                <td>{{ $request->created_at->format('d-m-Y H:i') }}</td>
                                                <td>
                                                    <form action="{{ route('admin.password.reset', $request->id) }}"
                                                        method="POST" class="d-flex gap-2">
                                                        @csrf
                                                        <input type="password" name="new_password"
                                                            placeholder="Password Baru" required
                                                            class="form-control form-control-sm">
                                                        <button class="btn btn-sm btn-primary">Reset</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- Approval Section --}}
        <hr class="my-5">
        <h5 class="fw-bold mb-3">Pickup Menunggu Persetujuan Admin</h5>

        @if ($pickups->isEmpty())
            <p class="text-muted">Tidak ada pickup yang menunggu approval.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Berat User</th>
                            <th>Berat Staff</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Poin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pickups as $pickup)
                            <tr>
                                <td>{{ $pickup->pickup->user->username ?? '-' }}</td>
                                <td>{{ $pickup->pickup->pickup_date }}</td>
                                <td>{{ $pickup->pickup->weight ?? '-' }} kg</td>
                                <td>{{ $pickup->berat_staff ?? '-' }} kg</td>
                                <td>{{ $pickup->pickup->wasteType->type ?? '-' }}</td>
                                <td>{{ ucfirst($pickup->pickup->status) }}</td>
                                <td class="text-center">
                                    {{ $pickup->berat_staff && $pickup->pickup->wasteType
                                        ? floor($pickup->berat_staff * $pickup->pickup->wasteType->points_per_kg)
                                        : 0 }}
                                </td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.pickup.reject', $pickup->id) }}" method="POST"
                                        class="d-inline-flex align-items-center mb-1" style="gap: 4px;">
                                        @csrf
                                        <input type="text" name="note" placeholder="Alasan" required
                                            class="form-control form-control-sm" style="width: 140px;">
                                        <button class="btn btn-sm btn-danger" type="submit">Tolak</button>
                                    </form>

                                    <form action="{{ route('admin.pickup.approve', $pickup->id) }}" method="POST"
                                        class="d-inline-flex align-items-center" style="gap: 4px;">
                                        @csrf
                                        <input type="text" name="note" placeholder="Catatan"
                                            class="form-control form-control-sm" style="width: 140px;">
                                        <button class="btn btn-sm btn-success" type="submit">Setujui</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    @endsection
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const counters = document.querySelectorAll('.count-up');
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const duration = 1000;
                    const stepTime = 20;
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
