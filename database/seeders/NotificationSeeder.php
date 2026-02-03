<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'title' => 'Thông báo tiền phòng tháng 02/2026',
                'content' => 'Hệ thống đã gửi hóa đơn tiền phòng tháng 02. Quý khách vui lòng thanh toán trước ngày 05.',
                'type' => 'general',
                'created_at' => now(),
            ],
            [
                'title' => 'Lịch bảo trì hệ thống điện',
                'content' => 'Tòa nhà sẽ tạm ngừng cấp điện để bảo trì từ 08h00 đến 10h00 ngày 15/02.',
                'type' => 'maintenance',
                'created_at' => now(),
            ],
            [
                'title' => 'Nhắc nhở nộp tiền cọc',
                'content' => 'Vui lòng hoàn tất khoản tiền cọc còn thiếu cho hợp đồng P.101.',
                'type' => 'payment',
                'created_at' => now(),
            ]
        ]);
    }
}