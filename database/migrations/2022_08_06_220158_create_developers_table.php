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
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_it')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_it')->nullable();
            $table->boolean('approved')->default(false);
            $table->boolean('hidden')->default(false);
            $table->string('logo')->nullable();
            $table->string('link_en')->nullable();
            $table->string('link_it')->nullable();
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
        Schema::dropIfExists('developers');
    }
};
