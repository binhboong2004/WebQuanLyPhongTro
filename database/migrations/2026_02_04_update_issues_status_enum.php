<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First add 'open' and 'closed' to the enum (keep old values to not break existing data)
        DB::statement("ALTER TABLE issues MODIFY status ENUM('sent', 'processing', 'resolved', 'open', 'closed') DEFAULT 'sent'");

        // Update existing data to match new enum values
        DB::statement("UPDATE issues SET status = 'open' WHERE status IN ('sent', 'processing')");

        // Now change the enum to only have new values
        DB::statement("ALTER TABLE issues MODIFY status ENUM('open', 'resolved', 'closed') DEFAULT 'open'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE issues MODIFY status ENUM('sent', 'processing', 'resolved') DEFAULT 'sent'");
    }
};
