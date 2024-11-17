<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_schedule_seats', function (Blueprint $table) {
            $table->id();
            $table->uuid('movie_schedule_id');
            $table->foreign('movie_schedule_id')->references('id')->on('movie_schedules')->onDelete('cascade');
            $table->uuid('seat_id');
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('payyed')->default(false);
            $table->boolean('arrived')->default(false);
            $table->string('payment_id', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_schedule_seat');
    }
};
