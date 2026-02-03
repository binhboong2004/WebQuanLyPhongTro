<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Điện', 'unit' => 'kWh', 'price_per_unit' => 3500],
            ['name' => 'Nước', 'unit' => 'm3', 'price_per_unit' => 20000],
            ['name' => 'Rác & Vệ sinh', 'unit' => 'Tháng', 'price_per_unit' => 50000],
            ['name' => 'Combo Internet', 'unit' => 'Tháng', 'price_per_unit' => 150000],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert(array_merge($service, ['created_at' => now()]));
        }
    }
}