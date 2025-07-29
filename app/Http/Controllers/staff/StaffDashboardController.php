<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pickup;
use Yajra\DataTables\DataTables;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staffId = Auth::id();
        $pickups = Pickup::where('staff_id', $staffId)->orderBy('pickup_date')->get();

        return view('staff.dashboard', compact('pickups'));
    }
    public function getData(Request $request)
    {
        $staffId = auth()->id(); // atau sesuaikan
        $pickups = Pickup::with('user')
            ->where('staff_id', $staffId)
            ->orderByDesc('pickup_date');

        return DataTables::of($pickups)
            ->addIndexColumn()
            ->addColumn('user', fn($p) => $p->user->username ?? '-')
            ->addColumn('time_slot_label', function ($p) {
                return match ($p->time_slot) {
                    'morning' => '<span class="badge bg-primary">Pagi</span>',
                    'afternoon' => '<span class="badge bg-warning text-dark">Sore</span>',
                    default => '<span class="badge bg-secondary">-</span>',
                };
            })
            ->addColumn('status', fn($p) => ucfirst(str_replace('_', ' ', $p->status)))
            ->rawColumns(['time_slot_label'])
            ->make(true);
    }
}

