<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    User::create(['name' => 'admin', 'email' => 'admin@test.com', 'password' => Hash::make('admin123'), 'role' => 'admin']);
    User::create(['name' => 'staff', 'email' => 'staff@test.com', 'password' => Hash::make('staff123'), 'role' => 'staff']);
    User::create(['name' => 'user', 'email' => 'user@test.com', 'password' => Hash::make('user123'), 'role' => 'user']);
    }
}
