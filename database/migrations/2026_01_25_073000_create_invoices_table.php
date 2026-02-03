<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('service_reading_id')->nullable()->constrained('service_readings')->onDelete('set null'); // Nối trực tiếp để đối soát ảnh
            $table->string('month_year'); // Định dạng: 01-2024
            $table->decimal('total_amount', 15, 2); // Tổng tiền
            $table->enum('status', ['unpaid', 'paid', 'overdue'])->default('unpaid');
            $table->string('payment_method')->nullable(); // Chuyển khoản, tiền mặt...
            $table->timestamp('payment_date')->nullable();
            $table->text('qr_code_link')->nullable(); // Link ảnh QR thanh toán
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
