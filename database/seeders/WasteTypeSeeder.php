<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WasteTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('waste_types')->insert([
            ['type' => 'Koran bekas dengan gambar', 'points_per_kg' => 12250],
            ['type' => 'Kertas HVS bekas A4/F4', 'points_per_kg' => 9500],
            ['type' => 'Kertas HVS satu sisi', 'points_per_kg' => 8250],
            ['type' => 'Koran bekas (LKS, koran, dll)', 'points_per_kg' => 21250],
            ['type' => 'Kertas duplek bekas', 'points_per_kg' => 11000],
            ['type' => 'Kertas harumanis', 'points_per_kg' => 12500],

            ['type' => 'Kayu', 'points_per_kg' => 13500],

            ['type' => 'Limbah Kaca Bening', 'points_per_kg' => 550],
            ['type' => 'Limbah Kaca Berwarna', 'points_per_kg' => 400],

            ['type' => 'Besi Bekas Industri', 'points_per_kg' => 8000],
            ['type' => 'Besi Bekas Kendaraan', 'points_per_kg' => 6750],
            ['type' => 'Besi Bekas Bangunan', 'points_per_kg' => 6000],
            ['type' => 'Besi Tua/Rongsokan Campuran', 'points_per_kg' => 4750],

            ['type' => 'Plastik PET Bening (Botol)', 'points_per_kg' => 2050],
            ['type' => 'Kantong Kresek / Plastik Daur Ulang', 'points_per_kg' => 50],

            ['type' => 'Tembaga', 'points_per_kg' => 45000],
            ['type' => 'Baja', 'points_per_kg' => 1500],
            ['type' => 'Aluminium', 'points_per_kg' => 9000],
        ]);
    }
}
