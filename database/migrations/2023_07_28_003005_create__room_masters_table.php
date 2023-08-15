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
        Schema::create('room_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('room_type');
            $table->integer('capacity');
            $table->string('image')->nullable();
            $table->text('explain');
            $table->text('facility');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_masters');
    }
};
