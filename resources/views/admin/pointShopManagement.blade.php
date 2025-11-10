@extends('layouts.admin')

@section('content')
    <style>
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
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Toko Penukaran Poin</h1>
            <button class="btn btn-success" onclick="openModal()">
                <i class="bi bi-plus-lg me-1"></i> Tambah Item
            </button>
        </div>
        <div class="card p-3 shadow border-0 mb-4">
            <div class="row g-3">
                @forelse($items as $item)
                    @php $img = $item->images->first(); @endphp
                    <div class="col-md-3">
                        <div class="card border-0 h-100 shadow-sm cursor-pointer hover-scale"
                            onclick='openItemModal(
                    {{ $item->id }},
                    @json($item->name),
                    {{ $item->stock }},
                    {{ $item->point_cost }},
                    @json($img ? asset('storage/' . $img->image_path) : asset('images/default.jpg')),
                    @json(route('admin.pointShopManagement.destroy', $item->id))
                )'>

                            <div style="aspect-ratio: 1 / 1; overflow: hidden;">
                                <img src="{{ $img ? asset('storage/' . $img->image_path) : asset('images/default.jpg') }}"
                                    class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $item->name }}">
                            </div>

                            <div class="card-body position-relative">
                                {{-- Badge Stok di kanan atas --}}
                                <span class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2 fs-6 shadow-sm">
                                    {{ number_format($item->stock, 0, ',', '.') }} Stok
                                </span>

                                {{-- Nama Item --}}
                                <h6 class="card-title fw-bold text-success" style="min-height: 40px;">
                                    {{ $item->name ?? 'Item' }}
                                </h6>

                                {{-- Poin --}}
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    <span class="text-dark fw-semibold">
                                        {{ number_format($item->point_cost, 0, ',', '.') }} Poin
                                    </span>
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

        @include('admin.shopModal')
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
            function openItemModal(id, name, stock, point, imageUrl, deleteUrl) {
                document.getElementById('detailName').textContent = name;
                document.getElementById('detailStock').textContent = stock;
                document.getElementById('detailPoint').textContent = point;
                document.getElementById('detailImage').src = imageUrl;

                document.getElementById('editItemId').value = id;
                document.getElementById('editForm').action = "{{ route('admin.pointShopManagement.store') }}";
                document.getElementById('deleteForm').action = deleteUrl;

                toggleEditForm(false);
                const modal = new bootstrap.Modal(document.getElementById('itemDetailModal'));
                modal.show();
            }

            function toggleEditForm(show) {
                document.getElementById('editForm').classList.toggle('d-none', !show);
            }

            function confirmDelete() {
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show();
            }

            function openModal() {
                const modal = new bootstrap.Modal(document.getElementById('modal-form'));
                modal.show();
            }
        </script>
    @endpush
