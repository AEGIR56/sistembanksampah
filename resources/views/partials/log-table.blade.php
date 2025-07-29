{{-- partials/log-table.blade.php --}}
<div class="card border-0 p-3 shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle datatable" id="{{ $tableId }}">
            <thead class="table-success text-start">
                <tr>
                    <th>No.</th>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Aksi</th>
                    <th>Target</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                    <tr>
                        <td>{{ is_a($logs, \Illuminate\Pagination\LengthAwarePaginator::class) ? $logs->firstItem() + $index : $index + 1 }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>{{ $log->user->username ?? '-' }}</td>
                        <td><span class="badge bg-secondary">{{ $log->role ?? '-' }}</span></td>
                        <td><span class="text-success fw-bold">{{ $log->action ?? '-' }}</span></td>
                        <td>{{ $log->target ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada log.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
