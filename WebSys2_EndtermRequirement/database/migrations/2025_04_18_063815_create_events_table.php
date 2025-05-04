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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_organization_id')->constrained('student_organizations')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->date('proposed_date');
            $table->enum('status', ['pending', 'approved', 'revision'])->default('pending');
            $table->text('feedback')->nullable();
            $table->string('document_file')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
