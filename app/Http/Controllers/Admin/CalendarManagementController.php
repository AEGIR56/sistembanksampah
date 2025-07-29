<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalendarDay;
use App\Models\User;
use App\Models\Pickup;
use App\Helpers\LogHelper;

class CalendarManagementController extends Controller
{
    public function index()
    {
        $calendarDays = CalendarDay::all();
        $staffs = User::where('role', 'staff')->get();

        $today = now()->startOfDay();

        $events = $calendarDays->map(function ($day) use ($today) {
            $date = \Carbon\Carbon::parse($day->date)->startOfDay();

            // Jika hari sudah lewat dan status masih 'tersedia', ubah jadi 'expired'
            if ($date->lt($today) && $day->status === 'tersedia') {
                $day->status = 'expired';
            }

            return [
                'title' => ucfirst($day->status),
                'start' => $day->date,
                'color' => match ($day->status) {
                    'penuh' => 'red',
                    'libur' => 'gray',
                    'expired' => 'gray',
                    default => 'green'
                },
            ];
        });


        $pickups = Pickup::with(['user', 'report', 'wasteType'])
            ->where('status', 'pickup selesai')
            ->get();

        return view('admin.scheduleManagement', compact(
            'calendarDays',
            'staffs',
            'events',
            'pickups'
        ));
    }

    public function destroy(Request $request)
    {
        $date = $request->input('date');

        $calendar = CalendarDay::where('date', $date)->first();
        if ($calendar) {
            $calendar->delete();

            LogHelper::record('Menghapus tanggal kalender', 'Tanggal: ' . $date);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'not_found'], 404);
    }

    public function update(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:tersedia,penuh,libur',
            'staff_id' => 'nullable|exists:users,id'
        ]);

        $day = CalendarDay::updateOrCreate(
            ['date' => $request->date],
            ['status' => $request->status, 'staff_id' => $request->staff_id]
        );

        LogHelper::record('Memperbarui kalender', 'Tanggal: ' . $request->date . ', Status: ' . $request->status . ', Staff ID: ' . $request->staff_id);

        return response()->json(['success' => true, 'data' => $day]);
    }
}
