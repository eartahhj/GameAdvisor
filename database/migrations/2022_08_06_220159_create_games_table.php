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
        Schema::create('games', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title_en');
            $table->string('title_it');
            $table->text('description_en')->nullable()->default('');
            $table->text('description_it')->nullable()->default('');
            $table->string('image')->nullable();
            $table->text('year');
            $table->timestamps();
            $table->boolean('approved')->default(false);
            $table->boolean('hidden')->default(false);
            $table->string('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
