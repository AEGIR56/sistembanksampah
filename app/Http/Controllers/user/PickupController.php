<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pickup;
use App\Models\CalendarDay;
use App\Models\WasteType;
use App\Http\Controllers\Controller;
use App\Helpers\LogHelper;
use Carbon\Carbon;

class PickupController extends Controller
{
    /**
     * Tampilkan halaman Schedule & Pickup.
     */
    public function index()
    {
        $calendarDays = CalendarDay::where('status', 'tersedia')
            ->whereNotNull('staff_id')
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

        $wasteTypes = WasteType::select('id', 'type')->get();

        return view('user.schedule', compact('calendarDays', 'dates', 'month', 'year', 'wasteTypes'));
    }

    /**
     * Simpan data pickup ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'selected_date' => 'required|date',
            'time_slot' => 'required|string',
            'address' => 'required|string|max:255',
            'waste_type_id' => 'required|array',
            'waste_type_id.*' => 'exists:waste_types,id',
            'weight' => 'required|array',
            'weight.*' => 'numeric|min:0.1',
        ]);

        $user = Auth::user();
        if (!$user) {
            throw new \Exception("Authenticated user not found.");
        }

        $calendarDay = CalendarDay::where('date', $request->selected_date)->first();
        if (!$calendarDay || $calendarDay->status !== 'tersedia' || !$calendarDay->staff_id) {
            return redirect()->back()->withErrors(['pickup_date' => 'Tanggal tidak tersedia untuk pemesanan.']);
        }

        foreach ($request->waste_type_id as $index => $wasteTypeId) {
            Pickup::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'pickup_date' => $request->selected_date,
                'time_slot' => $request->time_slot,
                'address' => $request->address,
                'waste_type_id' => $wasteTypeId,
                'weight' => $request->weight[$index],
                'staff_id' => $calendarDay->staff_id,
            ]);

            LogHelper::record(
                'User membuat permintaan pickup',
                "Tanggal: {$request->selected_date}, Time Slot: {$request->time_slot}, Jenis: {$wasteTypeId}, Berat: {$request->weight[$index]}, Staff: {$calendarDay->staff_id}"
            );
        }

        return redirect()->route('user.schedule')->with('success', 'Pickup request submitted successfully!');
    }

    public function staffPickupList()
    {
        $staffId = auth()->id();
        $pickups = Pickup::where('staff_id', $staffId)->get();

        return view('staff.pickupManagement', compact('pickups'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pickup = Pickup::findOrFail($id);

        if ($pickup->staff_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $oldStatus = $pickup->status;
        $pickup->update(['status' => $request->status ?: null]);

        LogHelper::record(
            'Staff memperbarui status pickup',
            "Pickup ID: {$pickup->id}, Sebelumnya: {$oldStatus}, Sekarang: {$pickup->status}"
        );

        return redirect()->route('staff.pickupManagement')->with('success', 'Pickup status updated successfully!');
    }
}
