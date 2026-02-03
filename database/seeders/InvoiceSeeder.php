<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $room = DB::table('rooms')->where('room_number', 'P.202')->first();
        $reading = DB::table('service_readings')->first();

        // Chỉ chèn nếu tìm thấy cả phòng và chỉ số
        if ($room && $reading) {
            DB::table('invoices')->insert([
                'room_id' => $room->id,
                'service_reading_id' => $reading->id,
                'month_year' => now()->format('m-Y'),
                'total_amount' => 7052500,
                'status' => 'unpaid',
                'created_at' => now(),
            ]);
        }
    }
}
