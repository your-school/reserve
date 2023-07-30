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
        Schema::create('reservation_slot_staying_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_slot_id')->constrained()->onDelete('cascade');
            $table->foreignId('staying_plan_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_slot_staying_plans');
    }
};
