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
        Schema::create('accreditation_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_organization_id')->constrained('student_organizations')->onDelete('cascade');
            $table->enum('type', ['new', 'renewal']);
            $table->enum('status', ['pending', 'approved', 'revision'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accreditation_applications');
    }
};
