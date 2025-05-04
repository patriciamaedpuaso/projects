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
        Schema::create('accreditation_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accreditation_application_id')->constrained('accreditation_applications')->onDelete('cascade');
            $table->string('document_type');
            $table->string('file_path');
            $table->timestamp('uploaded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accreditation_documents');
    }
};
