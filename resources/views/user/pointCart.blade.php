@extends('layouts.user')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">KeranjangKu</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (empty($cart))
            <p class="text-muted">Keranjang Anda kosong.</p>
        @else
            <form id="checkout-form" action="{{ route('user.cart.checkout') }}" method="POST">
                @csrf
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th scope="col"><input type="checkbox" id="select-all"></th>
                                <th scope="col">Item</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Poin/item</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                                @php $subtotal = $item['qty'] * $item['point_cost']; @endphp
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input cart-checkbox"
                                            name="selected_items[]" value="{{ $item['item_id'] }}" checked>
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ $item['qty'] }}</td>
                                    <td class="text-center">{{ $item['point_cost'] }}</td>
                                    <td class="text-center">{{ $subtotal }}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button" class="btn btn-danger btn-delete"
                                                data-item-id="{{ $item['item_id'] }}">Hapus</button>
                                            <button type="button" class="btn btn-sm btn-secondary btn-edit"
                                                data-id="{{ $item['item_id'] }}" data-name="{{ $item['name'] }}"
                                                data-qty="{{ $item['qty'] }}">
                                                Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Summary row --}}
                            <tr class="table-info fw-semibold">
                                <td class="text-center">
                                    <input type="checkbox" id="select-all-summary">
                                </td>
                                <td id="selected-names">-</td>
                                <td class="text-center" id="selected-quantity">0</td>
                                <td></td>
                                <td class="text-center" id="selected-total">0</td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm" id="checkout-btn"
                                        disabled>Checkout</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        @endif
    </div>

    @include('user.editQtyModal')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            const checkoutBtn = document.getElementById('checkout-btn');
            const namesEl = document.getElementById('selected-names');
            const qtyEl = document.getElementById('selected-quantity');
            const totalEl = document.getElementById('selected-total');
            const selectAll = document.getElementById('select-all');
            const selectAllSummary = document.getElementById('select-all-summary');

            function updateSummary() {
                let names = [];
                let qty = 0;
                let total = 0;
                let anyChecked = false;

                checkboxes.forEach(cb => {
                    const row = cb.closest('tr');
                    const nameCell = row.children[1];
                    const qtyCell = row.children[2];
                    const subtotalCell = row.children[4];

                    if (cb.checked) {
                        anyChecked = true;
                        names.push(nameCell.textContent.trim());
                        qty += parseInt(qtyCell.textContent.trim()) || 0;
                        total += parseInt(subtotalCell.textContent.trim()) || 0;
                    }
                });

                namesEl.textContent = names.length ? names.join(', ') : '-';
                qtyEl.textContent = qty;
                totalEl.textContent = total;
                checkoutBtn.disabled = !anyChecked;
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateSummary);
            });

            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateSummary();
            });

            selectAllSummary.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAllSummary.checked);
                updateSummary();
            });

            updateSummary();

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.dataset.id;
                    const itemName = this.dataset.name;
                    const qty = this.dataset.qty;

                    document.getElementById('edit-item-id').value = itemId;
                    document.getElementById('edit-qty').value = qty;

                    const editModal = new bootstrap.Modal(document.getElementById('editQtyModal'));
                    editModal.show();
                });
            });

            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;

                    Swal.fire({
                        title: 'Yakin ingin menghapus item ini?',
                        text: 'Item akan dihapus dari keranjang.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) {
                            // Kirim POST secara manual
                            fetch("{{ route('user.cart.delete') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    },
                                    body: JSON.stringify({
                                        item_id: itemId
                                    })
                                })
                                .then(res => {
                                    if (!res.ok) throw new Error(
                                        "Gagal menghapus item");
                                    return res.json();
                                })
                                .then(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Item dihapus dari keranjang'
                                    }).then(() => location.reload());
                                })
                                .catch(err => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops',
                                        text: err.message
                                    });
                                });
                        }
                    });
                });
            });
        });
    </script>
@endpush
