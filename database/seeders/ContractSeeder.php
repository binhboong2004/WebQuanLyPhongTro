<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $roomId = DB::table('rooms')->where('status', 'occupied')->first()->id;
        $tenantId = DB::table('users')->where('role', 'tenant')->first()->id;

        DB::table('contracts')->insert([
            'room_id' => $roomId,
            'tenant_id' => $tenantId,
            'start_date' => now()->subMonths(1),
            'end_date' => now()->addMonths(11),
            'deposit' => 6500000,
            'status' => 'active',
            'contract_type' => 'Dài hạn',
            'created_at' => now(),
        ]);
    }
}