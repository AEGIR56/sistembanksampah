<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ReportPickup;
use App\Models\User;
use App\Models\DataLog;
use App\Models\UserPoint;
use App\Models\Pickup;
use App\Models\WasteType;
use App\Models\PointShopTransaction;
use App\Models\PasswordResetRequest;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Balance Point
        $balance_points = UserPoint::sum('points');

        // Deposit Point
        $deposit_points = DB::table('report_pickups')
            ->join('pickups', 'report_pickups.pickup_id', '=', 'pickups.id')
            ->join('waste_types', 'pickups.waste_type_id', '=', 'waste_types.id')
            ->where('report_pickups.status_laporan', 'selesai')
            ->selectRaw('SUM(report_pickups.berat_staff * waste_types.points_per_kg) as total_points')
            ->value('total_points') ?? 0;

        // Exchange Point
        $exchange_points = PointShopTransaction::sum('point_used');

        // Members
        $total_members = User::where('role', 'user')->count();

        // Total Pickup (hanya status selesai)
        $total_pickup = Pickup::where('status', 'selesai')->count();

        // Total Waste Kg (hanya status selesai & pickup ditolak)
        $total_waste_kg = DB::table('report_pickups')
            ->where('status_laporan', 'selesai')
            ->sum('berat_staff');

        // Waste Prices (harga per jenis sampah)
        $waste_prices = WasteType::all();

        // Deposit History (10 terbaru)
        $deposit_history = PointShopTransaction::with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Exchange History (10 terbaru)
        $exchange_history = Pickup::whereRaw('LOWER(status) = ?', ['selesai'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $pickups = ReportPickup::with('pickup.user', 'pickup.wasteType')
            ->where('status_laporan', 'pickup selesai')
            ->get();

        // Reset Password Requests (pending)
        $password_requests = PasswordResetRequest::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'balance_points',
            'deposit_points',
            'exchange_points',
            'total_members',
            'total_pickup',
            'total_waste_kg',
            'waste_prices',
            'deposit_history',
            'exchange_history',
            'password_requests',
            'pickups',
        ));
    }


    public function accountManagement()
    {
        return view('admin.accountManagement');
    }

    public function dataLogs()
    {
        $logs = \App\Models\Log::with('user');

        $loginLogs = (clone $logs)
            ->whereIn('action', ['Login', 'Register', 'Password Recovery'])
            ->latest()->paginate(20, ['*'], 'login_logs');

        $scheduleLogs = (clone $logs)
            ->whereIn('action', ['Schedule', 'Pickup', 'Report', 'Approval'])
            ->latest()->paginate(20, ['*'], 'schedule_logs');

        $pointLogs = (clone $logs)
            ->whereIn('action', ['Point Shop', 'Point Exchange'])
            ->latest()->paginate(20, ['*'], 'point_logs');

        $otherLogs = (clone $logs)
            ->whereNotIn('action', [
                'Login',
                'Register',
                'Password Recovery',
                'Schedule',
                'Pickup',
                'Report',
                'Approval',
                'Point Shop',
                'Point Exchange',
            ])
            ->latest()->paginate(20, ['*'], 'other_logs');

        return view('admin.dataLogs', compact(
            'loginLogs',
            'scheduleLogs',
            'pointLogs',
            'otherLogs'
        ));
    }


    public function scheduleManagement()
    {
        return view('admin.scheduleManagement');
    }

    public function pointShopManagement()
    {
        return view('admin.pointShopManagement');
    }
}
