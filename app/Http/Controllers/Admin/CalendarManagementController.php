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
        // Ambil semua hari dan relasi staff
        $calendarDays = CalendarDay::with('staff')->get();

        // Ambil semua staff
        $staffs = User::where('role', 'staff')->get();

        // Warna acak untuk tiap staff
        $availableColors = [
            '#F87171',
            '#FBBF24',
            '#34D399',
            '#60A5FA',
            '#A78BFA',
            '#F472B6',
            '#F97316',
            '#2DD4BF',
            '#4ADE80',
            '#C084FC',
            '#FB923C',
            '#A3E635',
        ];

        $staffColors = [];
        foreach ($staffs as $index => $staff) {
            $staffColors[$staff->id] = $availableColors[$index % count($availableColors)];
        }

        $today = now()->startOfDay();

        // Bangun event kalender
        $events = $calendarDays->map(function ($day) use ($today, $staffColors) {
            $date = \Carbon\Carbon::parse($day->date)->startOfDay();

            // Tandai expired
            if ($date->lt($today) && $day->status === 'tersedia') {
                $day->status = 'expired';
            }

            $status = ucfirst($day->status);

            $title = $day->staff
                ? "Staff: {$day->staff->username} - {$status}"
                : "{$status} - Tidak Ada Staff";

            return [
                'title' => $title,
                'start' => $day->date,
                'color' => $day->staff
                    ? $staffColors[$day->staff->id] ?? '#999'
                    : match ($day->status) {
                        'penuh', 'expired', 'libur' => 'gray',
                        default => 'green',
                    },
                'extendedProps' => [
                    'status' => $day->status,
                    'staff_email' => $day->staff->email ?? '-',
                ],
            ];
        });


        // Pickup yang sudah selesai
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
