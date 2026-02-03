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
        Schema::create('service_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms');
            $table->integer('invoice_id')->nullable(); // Liên kết khi hóa đơn được tạo
            $table->date('reading_date');
            $table->integer('electricity_index'); // Chỉ số mới
            $table->integer('old_electricity_index')->default(0); // Chỉ số cũ để đối chiếu
            $table->integer('water_index');
            $table->integer('old_water_index')->default(0);
            $table->string('image_proof_elec')->nullable(); // Ảnh minh chứng
            $table->string('image_proof_water')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // Ghi chú của admin khi không duyệt
            $table->foreignId('created_by')->constrained('users'); // User khai báo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_readings');
    }
};
