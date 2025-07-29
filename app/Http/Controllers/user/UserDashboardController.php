<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Pickup;
use App\Models\ReportPickup;
use App\Models\UserPoint;
use App\Models\RedeemTransaction;
use App\Models\PointShopTransaction;
use App\Models\WasteType;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // total penukaran poin
        $exchange_points = PointShopTransaction::where('user_id', $userId)->sum('point_used');

        // total pickup
        $total_pickup = Pickup::where('user_id', $userId)->count();

        $total_waste_kg = ReportPickup::whereHas('pickup', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status_laporan', 'selesai')
            ->sum('berat_staff');

        $achievement = '-';

        //  Total Deposit dari pickup yang statusnya selesai
        $total_deposit_points = DB::table('report_pickups')
            ->join('pickups', 'report_pickups.pickup_id', '=', 'pickups.id')
            ->join('waste_types', 'pickups.waste_type_id', '=', 'waste_types.id')
            ->where('pickups.user_id', $userId)
            ->where('report_pickups.status_laporan', 'selesai')
            ->selectRaw('SUM(report_pickups.berat_staff * waste_types.points_per_kg) as total_points')
            ->value('total_points') ?? 0;

        // saldo poin user
        $balance_points = max(0, (int) $total_deposit_points - (int) $exchange_points);

        $waste_types = WasteType::select('type', 'points_per_kg')->orderBy('type')->get();

        // 🔷 history pickup
        $pickup_history = DB::table('report_pickups')
            ->join('pickups', 'report_pickups.pickup_id', '=', 'pickups.id')
            ->join('waste_types', 'pickups.waste_type_id', '=', 'waste_types.id')
            ->where('pickups.user_id', $userId)
            ->select(
                'report_pickups.id',
                'report_pickups.created_at as date',
                'waste_types.type as waste_type',
                'report_pickups.berat_staff as qty',
                DB::raw('(report_pickups.berat_staff * waste_types.points_per_kg) as nominal')
            )
            ->orderByDesc('report_pickups.created_at')
            ->get();

        // 🔷 history point redeem
        $redeem_history = DB::table('point_shop_transactions')
            ->join('shop_items', 'point_shop_transactions.shop_item_id', '=', 'shop_items.id')
            ->where('point_shop_transactions.user_id', $userId)
            ->select(
                'point_shop_transactions.id',
                'point_shop_transactions.created_at as date',
                'shop_items.name as item_name',
                'point_shop_transactions.quantity',
                'point_shop_transactions.point_used'
            )
            ->orderByDesc('point_shop_transactions.created_at')
            ->get();


        return view('user.dashboard', compact(
            'balance_points',
            'exchange_points',
            'total_pickup',
            'total_waste_kg',
            'total_deposit_points',
            'achievement',
            'waste_types',
            'pickup_history',
            'redeem_history'
        ));

    }
    public function getData(Request $request)
    {
        $wasteTypes = WasteType::query();
        return DataTables::of($wasteTypes)
            ->addIndexColumn()
            ->editColumn('points_per_kg', function ($row) {
                return number_format($row->points_per_kg, ); // ← pakai ini
            })
            ->make(true);
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function schedule()
    {
        return view('user.schedule');
    }

    public function transaction()
    {
        $userId = Auth::id();

        // saldo poin user
        $balance_points = UserPoint::where('user_id', $userId)->sum('points');

        // total penukaran poin
        $exchange_points = PointShopTransaction::where('user_id', $userId)->sum('point_used');

        // total pickup
        $total_pickup = Pickup::where('user_id', $userId)->count();

        // total berat sampah
        $total_waste_kg = DB::table('report_pickups')
            ->join('pickups', 'report_pickups.pickup_id', '=', 'pickups.id')
            ->where('pickups.user_id', $userId)
            ->where('report_pickups.status_laporan', 'selesai')
            ->sum('report_pickups.berat_staff');


        $achievement = '-';

        //  Total Deposit dari pickup yang statusnya selesai
        $total_deposit_points = DB::table('pickups')
            ->join('waste_types', 'pickups.waste_type_id', '=', 'waste_types.id')
            ->where('pickups.user_id', $userId)
            ->where('pickups.status', 'selesai')
            ->selectRaw('SUM(pickups.weight * waste_types.points_per_kg) as total_points')
            ->value('total_points') ?? 0;

        $waste_types = WasteType::select('type', 'points_per_kg')->orderBy('type')->get();

        // 🔷 history pickup
        $pickup_history = DB::table('report_pickups')
            ->join('pickups', 'report_pickups.pickup_id', '=', 'pickups.id')
            ->join('waste_types', 'pickups.waste_type_id', '=', 'waste_types.id')
            ->where('pickups.user_id', $userId)
            ->where('report_pickups.status_laporan', 'selesai') // ← filter status laporan
            ->select(
                'report_pickups.id',
                'report_pickups.created_at as date',
                'waste_types.type as waste_type',
                'report_pickups.berat_staff as qty',
                DB::raw('(report_pickups.berat_staff * waste_types.points_per_kg) as nominal')
            )
            ->orderByDesc('report_pickups.created_at')
            ->get();

        // 🔷 history point redeem
        $redeem_history = DB::table('point_shop_transactions')
            ->join('shop_items', 'point_shop_transactions.shop_item_id', '=', 'shop_items.id')
            ->where('point_shop_transactions.user_id', $userId)
            ->select(
                'point_shop_transactions.id',
                'point_shop_transactions.created_at as date',
                'shop_items.name as item_name',
                'point_shop_transactions.quantity',
                'point_shop_transactions.point_used'
            )
            ->orderByDesc('point_shop_transactions.created_at')
            ->limit(20)
            ->get();


        return view('user.transaction', compact(
            'balance_points',
            'exchange_points',
            'total_pickup',
            'total_waste_kg',
            'total_deposit_points',
            'achievement',
            'waste_types',
            'pickup_history',
            'redeem_history'
        ));
    }

    public function pickupData(Request $request)
    {
        $userId = auth()->id();

        $data = DB::table('report_pickups')
            ->join('pickups', 'report_pickups.pickup_id', '=', 'pickups.id')
            ->join('waste_types', 'pickups.waste_type_id', '=', 'waste_types.id')
            ->where('pickups.user_id', $userId)
            ->where('report_pickups.status_laporan', 'selesai') 
            ->select(
                'report_pickups.id',
                'report_pickups.created_at as date',
                'waste_types.type as waste_type',
                'report_pickups.berat_staff as qty',
                DB::raw('(report_pickups.berat_staff * waste_types.points_per_kg) as nominal')
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('qty', fn($row) => number_format($row->qty, 2))
            ->editColumn('nominal', fn($row) => number_format($row->nominal))
            ->make(true);
    }


    public function redeemData(Request $request)
    {
        $userId = auth()->id();

        $data = DB::table('point_shop_transactions')
            ->join('shop_items', 'point_shop_transactions.shop_item_id', '=', 'shop_items.id')
            ->where('point_shop_transactions.user_id', $userId)
            ->select(
                'point_shop_transactions.id',
                'point_shop_transactions.created_at as date',
                'shop_items.name as item_name',
                'point_shop_transactions.quantity',
                'point_shop_transactions.point_used'
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('point_used', fn($row) => number_format($row->point_used))
            ->make(true);
    }


    public function pointExchange()
    {
        return view('user.pointexchange');
    }
}
