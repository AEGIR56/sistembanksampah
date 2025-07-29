<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pickup;
use App\Models\ReportPickup;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper;

class AdminApprovalController extends Controller
{
    public function approve(Request $request, $id)
    {
        $reportPickup = ReportPickup::with(['pickup.user', 'pickup.wasteType'])->findOrFail($id);
        $pickup = $reportPickup->pickup;

        if (!$pickup) {
            return back()->with('error', 'Data pickup tidak ditemukan.');
        }

        DB::transaction(function () use ($pickup, $reportPickup, $request) {
            // Update status pickup
            $pickup->update([
                'status' => 'selesai',
                'admin_id' => Auth::id(),
                'approved_at' => now(),
                'approval_note' => $request->input('note') ?? 'Disetujui',
            ]);

            // Update status_laporan & alasan
            $reportPickup->update([
                'status_laporan' => 'selesai',
                'alasan_laporan' => $request->input('note') ?? 'Disetujui',
            ]);

            // Ambil report yang disetujui (hanya yang status selesai)
            $approvedReport = ReportPickup::where('pickup_id', $pickup->id)
                ->where('status_laporan', 'selesai')
                ->latest()
                ->first();

            if ($approvedReport && $pickup->wasteType) {
                $berat = floatval($approvedReport->berat_staff);
                $poinPerKg = floatval($pickup->wasteType->points_per_kg);
                $points = floor($berat * $poinPerKg);

                UserPoint::create([
                    'user_id' => $pickup->user_id,
                    'pickup_id' => $pickup->id,
                    'points' => $points,
                ]);
            }
        });

        LogHelper::record('Menyetujui pickup', 'ReportPickup ID: ' . $reportPickup->id);

        return back()->with('success', 'Pickup disetujui dan poin telah diberikan.');
    }



    public function reject(Request $request, $id)
    {
        $reportPickup = ReportPickup::findOrFail($id);

        $note = $request->input('note') ?? 'Ditolak oleh admin';

        $reportPickup->update([
            'status_laporan' => 'ditolak_admin',
            'alasan_laporan' => $note,
        ]);

        if ($reportPickup->pickup) {
            $reportPickup->pickup->update([
                'status' => 'ditolak_admin',
                'admin_id' => Auth::id(),
                'approved_at' => now(),
                'approval_note' => $note,
            ]);
        }

        LogHelper::record('Menolak pickup', 'ReportPickup ID: ' . $reportPickup->id);

        return back()->with('info', 'Pickup ditolak oleh admin.');
    }


}
