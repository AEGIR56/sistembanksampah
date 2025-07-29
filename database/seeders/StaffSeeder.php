<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'staff_andi',
                'email' => 'andi@example.com',
                'password' => bcrypt('password'), // atau Hash::make
                'role' => 'staff',
                'phone_number' => '081234567890',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'staff_budi',
                'email' => 'budi@example.com',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'phone_number' => '081987654321',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
