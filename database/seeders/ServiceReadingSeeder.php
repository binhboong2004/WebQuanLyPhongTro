<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceReadingSeeder extends Seeder
{
    public function run(): void
    {
        $roomId = DB::table('rooms')->where('room_number', 'P.202')->first()->id;
        $adminId = DB::table('users')->where('role', 'admin')->first()->id;

        DB::table('service_readings')->insert([
            'room_id' => $roomId,
            'reading_date' => now(),
            'old_electricity_index' => 4520,
            'electricity_index' => 4635,
            'old_water_index' => 45,
            'water_index' => 50,
            'status' => 'pending',
            'created_by' => $adminId,
            'created_at' => now(),
        ]);
    }
}