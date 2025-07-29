<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\LogHelper;
use App\Models\CalendarDay;
use App\Models\Pickup;

class StaffPickupController extends Controller
{
    public function index(Request $request)
    {
        $staffId = Auth::id();
        $assignedDates = CalendarDay::where('staff_id', $staffId)->pluck('date')->toArray();

        if ($request->ajax()) {
            $pickups = Pickup::with(['user', 'wasteType'])
                ->whereIn('pickup_date', $assignedDates)
                ->where('staff_id', $staffId)
                ->orderBy('pickup_date');

            return DataTables::of($pickups)
                ->addIndexColumn()
                ->addColumn('user', fn($pickup) => $pickup->user->username ?? '-')
                ->addColumn('waste_type', fn($pickup) => $pickup->wasteType->type ?? '-')
                ->addColumn('time_slot', function ($pickup) {
                    return match ($pickup->time_slot) {
                        'morning' => '<span class="badge bg-primary">Pagi</span>',
                        'afternoon' => '<span class="badge bg-warning text-dark">Sore</span>',
                        default => '<span class="badge bg-secondary">-</span>',
                    };
                })
                ->addColumn('status_column', function ($pickup) {
                    $status = strtolower($pickup->status);
                    $badge = match ($status) {
                        'menunggu' => 'warning',
                        'diproses' => 'info',
                        'pickup selesai', 'selesai' => 'success',
                        'pickup ditolak', 'gagal_admin' => 'danger',
                        default => 'secondary',
                    };

                    // Jika status pickup_ditolak, tampilkan select yang disabled
                    if ($status === 'pickup ditolak') {
                        return '
            <select class="form-select form-select-sm" disabled>
                <option value="menunggu"' . ($status === 'menunggu' ? ' selected' : '') . '>Menunggu</option>
                <option value="diproses"' . ($status === 'diproses' ? ' selected' : '') . '>Diproses</option>
                <option value="pickup_ditolak" selected>Ditolak</option>
            </select>';
                    }

                    // Jika status selain selesai/ditolak, tampilkan select aktif
                    if (!in_array($status, ['pickup selesai'])) {
                        return '
            <select class="form-select form-select-sm" onchange="updateStatus(' . $pickup->id . ', this.value)">
                <option value="menunggu"' . ($status === 'menunggu' ? ' selected' : '') . '>Menunggu</option>
                <option value="diproses"' . ($status === 'diproses' ? ' selected' : '') . '>Diproses</option>
            </select>';
                    }

                    // Status yang tidak bisa diubah lagi
                    return '<span class="badge bg-' . $badge . '">' . ucfirst(str_replace('_', ' ', $pickup->status)) . '</span>';
                })
                ->addColumn('transaksi', function ($pickup) {
                    $status = strtolower($pickup->status);

                    if ($status === 'diproses') {
                        return '<button class="btn btn-sm btn-primary" onclick="openReportModal(' . $pickup->id . ')">Isi Laporan</button>';
                    } elseif (in_array($status, ['pickup selesai'])) {
                        return '<span class="badge bg-success">Selesai Pickup</span>';
                    } elseif (in_array($status, ['selesai'])) {
                        return '<span class="badge bg-success">Selesai</span>';
                    } elseif (in_array($status, ['pickup ditolak'])) {
                        return '<span class="badge bg-danger">Pickup Ditolak</span>';
                    } elseif (in_array($status, ['ditolak_admin'])) {
                        return '<span class="badge bg-danger">Ditolak Admin</span>';
                    } else {
                        return '<span class="badge bg-secondary">Belum Tersedia</span>';
                    }
                })
                ->rawColumns(['status_column', 'transaksi','time_slot'])
                ->make(true);
        }

        // Logging
        LogHelper::record('Melihat daftar pickup yang ditugaskan', 'Staff ID: ' . $staffId);

        // View fallback
        return view('staff.pickup_list');
    }

    public function updateStatus(Request $request, $id)
    {
        $pickup = Pickup::findOrFail($id);

        if ($pickup->staff_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($pickup->status, ['selesai', 'ditolak'])) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa mengubah status ini.']);
        }

        if (!in_array($request->input('status'), ['menunggu', 'diproses'])) {
            return response()->json(['success' => false, 'message' => 'Status tidak valid.']);
        }

        $pickup->status = $request->input('status');
        $pickup->save();

        LogHelper::record(
            'Memperbarui status pickup',
            'Pickup ID: ' . $pickup->id . ', Status baru: ' . $pickup->status
        );

        return response()->json(['success' => true]);
    }

    public function storeReport(Request $request, $id)
    {
        $request->validate([
            'staff_weight' => 'required|numeric|min:0',
            'status_report' => 'required|in:pickup selesai,pickup ditolak',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $pickup = Pickup::findOrFail($id);
        $pickup->staff_weight = $request->staff_weight;
        $pickup->status = $request->status_report;

        // Simpan catatan detail
        $pickup->report_detail = json_encode([
            'checklist' => $request->detail ?? [],
            'note' => $request->note
        ]);

        // Simpan file gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = $file->store('pickup_images', 'public');
                $pickup->images[] = $filename;
            }
        }

        $pickup->save();

        return response()->json(['message' => 'Laporan berhasil disimpan.']);
    }


    public function apiPickupDetail($id)
    {
        $pickup = Pickup::with(['user', 'staff', 'wasteType'])->findOrFail($id);

        return response()->json([
            'id' => $pickup->id,
            'staff_name' => $pickup->staff->username ?? '-',
            'user_name' => $pickup->user->username ?? '-',
            'phone_number' => $pickup->user->phone_number ?? '-', // sesuaikan field
            'address' => $pickup->address ?? '-',
            'pickup_date' => $pickup->pickup_date,
            'time_slot' => $pickup->time_slot,
            'waste_type' => $pickup->wasteType->type ?? '-',
            'weight' => $pickup->weight ?? 0,
        ]);
    }



    public function show($id)
    {
        $pickup = Pickup::with(['user', 'wasteType', 'staff'])->findOrFail($id);

        if ($pickup->staff_id !== Auth::id()) {
            abort(403);
        }

        LogHelper::record(
            'Melihat detail pickup',
            'Pickup ID: ' . $pickup->id
        );

        return response()->json($pickup);
    }
}
