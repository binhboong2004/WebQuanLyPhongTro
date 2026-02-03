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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('tenant_id')->constrained('users'); // Người đại diện thuê
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('deposit', 15, 2); // Tiền cọc
            $table->enum('status', ['active', 'expired', 'terminated'])->default('active');
            $table->string('contract_file')->nullable(); // Đường dẫn ảnh/PDF
            $table->text('contract_type')->nullable(); // Loại hợp đồng/Cam kết
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
