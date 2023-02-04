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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title_it');
            $table->string('title_en');
            $table->text('html_it');
            $table->text('html_en');
            $table->string('url_it');
            $table->string('url_en');
            $table->boolean('published')->default('false');
            $table->timestamps();
            $table->foreignId('user_creator_id')->constrained('users')->cascadeOnUpdate()
            ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
