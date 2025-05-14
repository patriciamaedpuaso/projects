<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsaasTable extends Migration
{
    public function up()
    {
        Schema::create('osaas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('staff'); // Adding the role column with a default value
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('osaas');
    }
}
