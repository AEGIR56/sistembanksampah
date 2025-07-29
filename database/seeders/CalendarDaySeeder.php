<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalendarDay;
use App\Models\User;
use Illuminate\Support\Carbon;

class CalendarDaySeeder extends Seeder
{
    public function run()
    {
        // Ambil 1 staff (pastikan ada user dengan role 'staff')
        $staff = User::where('role', 'staff')->first();


    }
}
