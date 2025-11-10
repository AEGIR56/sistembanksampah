@extends('layouts.user')

@section('content')
    <style>
        /* Basic modal style */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Fade & centered dialog */
        .modal-dialog {
            margin: 1.75rem auto;
            max-width: 500px;
        }

        .modal.show {
            display: block;
        }

        .hover-scale {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .hover-scale:hover {
            transform: scale(1.03);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .badge {
            font-size: 0.95rem;
            border-radius: 0.5rem;
        }

        .card-title {
            line-height: 1.3;
        }

        #itemDetailModal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease-in-out;
        }

        #itemDetailModal .modal-content {
            background: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            animation: fadeInUp 0.3s ease-out;
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>

    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"
                        class="text-success text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Toko</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Toko Penukaran Poin</h1>
            <a href="{{ route('user.cart') }}" class="btn btn-outline-success btn-lg position-relative">
                <i class="bi bi-cart me-2"> </i>KeranjangKu
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    id="cart-badge" style="display: none;">0</span>
            </a>
        </div>

        <h4 class="mb-4">Poin Anda: <strong>{{ number_format($totalPoints, 0, 0) }}</strong></h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card p-3 shadow border-0 mb-4">
            <div class="row g-3">
                @forelse($items as $item)
                    @php $img = $item->images->first(); @endphp
                    <div class="col-md-3" >
                        <div class="card border-0 h-100 shadow-sm cursor-pointer hover-scale">
                            <div style="aspect-ratio: 1 / 1; overflow: hidden;">
                                <img src="{{ $img ? asset('storage/' . $img->image_path) : asset('images/default.jpg') }}"
                                    class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $item->name }}">
                            </div>

                            <div class="card-body position-relative">
                                <!-- Stok Badge -->
                                <span
                                    class="badge py-2 px-3 rounded-pill bg-success position-absolute top-0 end-0 m-2 shadow-sm">
                                    {{ number_format($item->stock, 0, ',', '.') }} Stok
                                </span>

                                <!-- Nama Item -->
                                <h6 class="card-title fw-semibold text-dark mb-2" style="min-height: 36px;">
                                    {{ $item->name ?? 'Item' }}
                                </h6>

                                <!-- Poin -->
                                <div class="mb-3 d-flex align-items-center text-muted small">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    <span class="fw-semibold">
                                        {{ number_format($item->point_cost, 0, ',', '.') }} Poin
                                    </span>
                                </div>

                                <!-- Tombol -->
                                <div class="d-grid">
                                    <button class="btn btn-success btn-sm"
                                        onclick='event.stopPropagation(); showItemDetail(
                                            @json($item->id),
                                            @json($item->name),
                                            @json($img ? asset('storage/' . $img->image_path) : asset('images/default.jpg')),
                                            @json($item->stock),
                                            @json($item->point_cost)
                                        )'>
                                        <i class="bi bi-exclamation-circle"></i> Lihat Detail Produk
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Belum ada item tersedia.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="card-footer border-0">
                <div class="align-items-center">
                    <!-- Pagination -->
                    @if ($items->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            <nav>
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($items->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link text-success">«</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link text-success"
                                                href="{{ $items->previousPageUrl() }}" rel="prev">«</a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($items->links()->elements[0] as $page => $url)
                                        @if ($page == $items->currentPage())
                                            <li class="page-item active">
                                                <span
                                                    class="page-link bg-success text-white border-success">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link text-success"
                                                    href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($items->hasMorePages())
                                        <li class="page-item"><a class="page-link text-success"
                                                href="{{ $items->nextPageUrl() }}" rel="next">»</a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link">»</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('user.listModal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
    <script>
        const listItems = @json($items); // ← isi dari controller

        function showItemDetail(id, name, img, stock, pointCost) {
            document.getElementById('detailItemId').value = id;
            document.getElementById('detailName').innerText = name;
            document.getElementById('detailStock').innerText = stock;
            document.getElementById('detailPrice').value = pointCost;
            document.getElementById('detailQty').value = 1;
            document.getElementById('detailImage').src = img || '/images/default.png';

            updateSubtotal();
            document.getElementById('itemDetailModal').style.display = 'block';
        }


        function closeModal() {
            document.getElementById('itemDetailModal').style.display = 'none';
        }

        function increaseQty() {
            const qtyInput = document.getElementById('detailQty');
            const stock = parseInt(document.getElementById('detailStock').innerText);
            let qty = parseInt(qtyInput.value);
            if (qty < stock) {
                qtyInput.value = qty + 1;
                updateSubtotal();
            }
        }

        function decreaseQty() {
            const qtyInput = document.getElementById('detailQty');
            let qty = parseInt(qtyInput.value);
            if (qty > 1) {
                qtyInput.value = qty - 1;
                updateSubtotal();
            }
        }

        function updateSubtotal() {
            const qty = parseInt(document.getElementById('detailQty').value);
            const price = parseInt(document.getElementById('detailPrice').value);
            document.getElementById('detailSubtotal').innerText = (qty * price).toLocaleString('id-ID') + ' Poin';
        }

        function addToCartFromModal() {
            const itemId = document.getElementById('detailItemId').value;
            const qty = parseInt(document.getElementById('detailQty').value) || 1;

            fetch('/user/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        item_id: itemId,
                        quantity: qty
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Gagal menambahkan item');
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Item berhasil ditambahkan ke keranjang'
                    });
                    closeModal();
                    updateCartBadge();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message
                    });
                });
        }

        function updateCartBadge() {
            fetch('/user/cart/count')
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('cart-badge');
                    badge.textContent = data.count;

                    if (data.count > 0) {
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                });
        }


        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
        });
    </script>
@endpush
