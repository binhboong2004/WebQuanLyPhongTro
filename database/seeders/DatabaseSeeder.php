<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,           // 1. Tạo người dùng
            BuildingSeeder::class,       // 2. Tạo tòa nhà
            RoomSeeder::class,           // 3. Tạo phòng
            RoomMemberSeeder::class,      // Tạo thành viên phòng
            ServiceSeeder::class,        // 4. Tạo dịch vụ
            ContractSeeder::class,       // 5. Tạo hợp đồng (Phòng phải có người ở)
            ServiceReadingSeeder::class, // 6. Tạo chỉ số điện nước (Có trước hóa đơn)
            InvoiceSeeder::class,        // 7. Tạo hóa đơn (Dựa trên chỉ số)
            InvoiceDetailSeeder::class,  // 8. Chi tiết hóa đơn
            IssueSeeder::class,          // 9. Phản hồi
            NotificationSeeder::class,    // Thông báo
        ]);
    }
}
