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
        Schema::create('movies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('third_party_id')->unique();
            $table->string('original_title');
            $table->string('title');
            $table->string('original_language');
            $table->text('overview');
            $table->date('release_date');
            $table->string('backdrop_path')->nullable();
            $table->string('poster_path')->nullable();
            $table->boolean('adult')->default(false);
            $table->float('popularity')->default(0);
            $table->float('vote_average', 32)->default(0);
            $table->integer('vote_count')->default(0);
            $table->integer('runtime')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
