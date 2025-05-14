<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('accreditation_applications', function (Blueprint $table) {
            $table->boolean('can_renew')->default(false);
        });
    }

    public function down()
    {
        Schema::table('accreditation_applications', function (Blueprint $table) {
            $table->dropColumn('can_renew');
        });
    }
};
