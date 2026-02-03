<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = DB::table('users')->where('role', 'tenant')->first()->id;

        DB::table('issues')->insert([
            'user_id' => $tenantId,
            'title' => 'Hỏng vòi nước',
            'content' => 'Vòi nước bồn rửa mặt bị rò rỉ, cần sửa gấp.',
            'status' => 'sent',
            'created_at' => now(),
        ]);
    }
}