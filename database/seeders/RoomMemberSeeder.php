<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomMemberSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy ID của một phòng đang có người ở (occupied)
        $room = DB::table('rooms')->where('status', 'occupied')->first();

        if ($room) {
            DB::table('room_members')->insert([
                [
                    'room_id' => $room->id,
                    'name' => 'Nguyễn Văn Thành',
                    'id_card' => '001203004567',
                    'phone' => '0988111222',
                    'is_registered' => 1, // Đã đăng ký tạm trú
                    'created_at' => now(),
                ],
                [
                    'room_id' => $room->id,
                    'name' => 'Lê Thị Hoa',
                    'id_card' => '001203009876',
                    'phone' => '0988333444',
                    'is_registered' => 0, // Chưa đăng ký tạm trú
                    'created_at' => now(),
                ]
            ]);
        }
    }
}