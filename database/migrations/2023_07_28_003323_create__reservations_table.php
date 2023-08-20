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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('number_of_people');
            $table->string('email');
            $table->bigInteger('phone_number');
            $table->integer('post_code');
            $table->string('address');
            $table->text('message')->nullable();
            $table->date('start_day');
            $table->date('end_day');
            $table->integer('reservation_status')->nullable();
            $table->text('admin_memo')->nullable();
            $table->integer('total_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
