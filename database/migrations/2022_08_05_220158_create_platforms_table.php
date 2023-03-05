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
        Schema::create('platforms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name_en');
            $table->string('name_it')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_it')->nullable();
            $table->boolean('approved')->default(false);
            $table->boolean('hidden')->default(false);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('platforms');
    }
};