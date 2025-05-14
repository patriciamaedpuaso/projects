<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_organizations', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('contact_number');
        });
    }

    public function down()
    {
        Schema::table('student_organizations', function (Blueprint $table) {
            $table->dropColumn('logo_path');
        });
    }

};
