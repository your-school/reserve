<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staying_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_images_id')->constrained();
            $table->string('title');
            $table->integer('price');
            $table->text('explain');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staying_plans');
    }
};
