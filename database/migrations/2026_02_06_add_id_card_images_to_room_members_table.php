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
        Schema::table('room_members', function (Blueprint $table) {
            $table->string('id_card_front')->nullable()->after('id_card')->comment('Ảnh mặt trước CCCD');
            $table->string('id_card_back')->nullable()->after('id_card_front')->comment('Ảnh mặt sau CCCD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_members', function (Blueprint $table) {
            $table->dropColumn(['id_card_front', 'id_card_back']);
        });
    }
};
