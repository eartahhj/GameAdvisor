<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('password_salt');
            $table->string('password');
            $table->date('password_expiration_date');
            $table->boolean('enabled');
            $table->date('last_access');
            $table->unsignedSmallInteger('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
};
