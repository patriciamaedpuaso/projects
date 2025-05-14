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
        Schema::table('accomplishment_reports', function (Blueprint $table) {
            // Modify the 'status' column to include 'reviewed' and 'rejected'
            $table->enum('status', ['pending', 'reviewed', 'approved'])->default('pending')->change();

            // Add the 'reviewed_at' timestamp
            $table->timestamp('reviewed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accomplishment_reports', function (Blueprint $table) {
            // Revert the 'status' column to its original state
            $table->enum('status', ['pending', 'approved', 'revision'])->default('pending')->change();

            // Drop the 'reviewed_at' column
            $table->dropColumn('reviewed_at');
        });
    }
};
