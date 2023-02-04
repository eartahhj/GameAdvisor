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
            $table->string('title');
            $table->text('description')->nullable()->default('');
            $table->string('image')->nullable();
            $table->text('year');
            $table->timestamps();
            $table->boolean('approved')->default('false');
            $table->boolean('hidden')->default('false');
            $table->foreignId('platform_id')->constrained('games_platforms')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('publisher_id')->constrained('publishers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('developer_id')->constrained('developers')->cascadeOnUpdate()->restrictOnDelete();
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
