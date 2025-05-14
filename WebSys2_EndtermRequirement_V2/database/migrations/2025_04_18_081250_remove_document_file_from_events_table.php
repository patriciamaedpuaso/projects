<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('document_file');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('document_file')->nullable();
        });
    }
};
