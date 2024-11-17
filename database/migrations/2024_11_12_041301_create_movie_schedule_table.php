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
        Schema::create('movie_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->time('show_start');
            $table->time('show_end');

            $table->uuid('price_id');
            $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');
            $table->uuid('movie_id');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->uuid('auditorium_id');
            $table->foreign('auditorium_id')->references('id')->on('auditoria')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_schedule');
    }
};
