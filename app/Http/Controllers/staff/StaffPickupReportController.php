<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pickup;
use App\Models\ReportPickup;
use App\Helpers\LogHelper;

class StaffPickupReportController extends Controller
{
    public function store(Request $request, $id)
    {
        $pickup = Pickup::findOrFail($id);

        if ($pickup->staff_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($pickup->status, ['selesai', 'ditolak'])) {
            return response()->json(['message' => 'Data tidak dapat diubah karena sudah selesai atau ditolak.'], 403);
        }

        \Log::info($request->all());

        $request->validate([
            'staff_weight' => 'required|numeric|min:0',
            'status_report' => 'required|in:pickup selesai,pickup ditolak',
            'issues' => 'array',
            'images.*' => 'image|max:2048',
            'note' => 'nullable|string',
        ]);

        $gambarPaths = [null, null, null];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                if ($index < 3) {
                    $path = $file->store('report_images', 'public');
                    $gambarPaths[$index] = $path;
                }
            }
        }

        $report = new ReportPickup();
        $report->pickup_id = $pickup->id;
        $report->staff_id = Auth::id();
        $report->berat_staff = $request->staff_weight;
        $report->alasan_laporan = $request->has('issues') ? implode(', ', $request->issues) : '-';
        $report->gambar_1 = $gambarPaths[0];
        $report->gambar_2 = $gambarPaths[1];
        $report->gambar_3 = $gambarPaths[2];
        $report->catatan = $request->note;
        $report->status_laporan = $request->status_report;
        $report->save();

        $pickup->status = $request->status_report;
        $pickup->save();

        LogHelper::record(
            'Mengisi laporan pickup',
            'Pickup ID: '.$pickup->id.', Status laporan: '.$report->status_laporan.', Berat staf: '.$report->berat_staff
        );

        return response()->json(['success' => true, 'message' => 'Laporan berhasil disimpan.']);
    }
}
