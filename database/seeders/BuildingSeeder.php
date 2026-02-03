<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('buildings')->insert([
            'name' => 'SmartRent SkyView',
            'address' => '123 Đường ABC, Quận 1, TP.HCM',
            'description' => 'Tòa nhà cao cấp đầy đủ tiện ích',
            'rules' => 'Không gây ồn sau 23h, để xe đúng nơi quy định',
            'created_at' => now(),
        ]);
    }
}