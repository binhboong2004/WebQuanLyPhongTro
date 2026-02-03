<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $buildingId = DB::table('buildings')->first()->id;

        DB::table('rooms')->insert([
            [
                'building_id' => $buildingId,
                'room_number' => 'P.101',
                'price_base' => 5000000,
                'status' => 'available',
                'created_at' => now(),
            ],
            [
                'building_id' => $buildingId,
                'room_number' => 'P.202',
                'price_base' => 6500000,
                'status' => 'occupied',
                'created_at' => now(),
            ],
            [
                'building_id' => $buildingId,
                'room_number' => 'P.303',
                'price_base' => 4500000,
                'status' => 'maintenance',
                'created_at' => now(),
            ]
        ]);
    }
}