<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOsaasTableAddProfileImageAndRoles extends Migration
{
    public function up()
    {
        Schema::table('osaas', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('password');
        });
    }

    public function down()
    {
        Schema::table('osaas', function (Blueprint $table) {
            $table->dropColumn('profile_image');
            // Cannot revert a change to default value safely unless you store the previous state.
        });
    }
}
