<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CalendarDay;
use App\Models\Pickup;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class StaffDashboardController extends Controller
{
    public function index()
    {
        $staffId = Auth::id();
        $pickups = Pickup::where('staff_id', $staffId)->orderBy('pickup_date')->get();

        $calendarDays = CalendarDay::with('staff')
            ->where('staff_id', Auth::id())
            ->get(['date', 'status', 'staff_id'])
            ->toArray();

        $today = Carbon::now();
        $year = $today->year;
        $month = $today->month;

        $firstDay = Carbon::create($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;

        $dates = [];
        for ($i = 0; $i < $firstDay->dayOfWeek; $i++) {
            $dates[] = [
                'date' => null,
                'day' => null,
                'status' => 'empty'
            ];
        }

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $dates[] = [
                'date' => $date->toDateString(),
                'day' => $date->format('l'),
                'status' => rand(0, 1) ? 'available' : 'unavailable'
            ];
        }

        return view('staff.dashboard', compact('pickups', 'calendarDays', 'dates', 'month', 'year'));
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
            ->addColumn('status', fn($p) => ucfirst(str_replace('_', ' ', $p->status ?? 'menunggu')))
            ->rawColumns(['time_slot_label'])
            ->make(true);
    }
}

