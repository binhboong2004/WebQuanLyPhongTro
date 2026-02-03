<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Vũ Duy Bình',
            'email' => 'admin@smartrent.com',
            'password' => Hash::make('123456'),
            'phone' => '0908123456',
            'role' => 'admin',
            'created_at' => now(),
        ]);

        // Danh sách khách thuê mẫu
        $tenants = [
            ['name' => 'Nguyễn Văn A', 'email' => 'vana@gmail.com'],
            ['name' => 'Trần Thị B', 'email' => 'thib@gmail.com'],
            ['name' => 'Lê Văn C', 'email' => 'vanc@gmail.com'],
        ];

        foreach ($tenants as $t) {
            DB::table('users')->insert([
                'name' => $t['name'],
                'email' => $t['email'],
                'password' => Hash::make('123456'),
                'phone' => '0912345678',
                'role' => 'tenant',
                'created_at' => now(),
            ]);
        }
    }
}