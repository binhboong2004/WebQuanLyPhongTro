<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceDetailSeeder extends Seeder
{
    public function run(): void
    {
        $invoiceId = DB::table('invoices')->first()->id;

        DB::table('invoice_details')->insert([
            [
                'invoice_id' => $invoiceId,
                'description' => 'Tiền phòng P.202',
                'quantity' => 1,
                'unit_price' => 6500000,
                'subtotal' => 6500000,
                'created_at' => now(),
            ],
            [
                'invoice_id' => $invoiceId,
                'description' => 'Tiền điện (115 kWh)',
                'quantity' => 115,
                'unit_price' => 3500,
                'subtotal' => 402500,
                'created_at' => now(),
            ]
        ]);
    }
}