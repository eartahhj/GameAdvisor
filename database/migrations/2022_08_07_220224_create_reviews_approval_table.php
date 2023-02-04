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
        Schema::create('reviews_approval', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreignId('review_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('approved_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews_approval');
    }
};
