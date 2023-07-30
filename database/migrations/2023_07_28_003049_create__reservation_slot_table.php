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
        Schema::create('reservation_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->unsignedBigInteger('staying_plan_id')->nullable();
            // $table->foreignId('reservation_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            // $table->foreignId('staying_plan_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('room_master_id')->constrained();
            $table->date('day');
            $table->boolean('cancel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_slots');
    }
};
