<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accreditation_applications', function (Blueprint $table) {
            $table->index('student_organization_id');
            $table->index('status');
        });

        Schema::table('accreditation_documents', function (Blueprint $table) {
            $table->index('accreditation_application_id');
        });
    }

    public function down(): void
    {
        Schema::table('accreditation_applications', function (Blueprint $table) {
            $table->dropIndex(['student_organization_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('accreditation_documents', function (Blueprint $table) {
            $table->dropIndex(['accreditation_application_id']);
        });
    }
};
