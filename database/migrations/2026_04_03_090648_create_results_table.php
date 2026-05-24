<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_id')->nullable();
            $table->unsignedBigInteger('winner_team_id')->nullable();
            $table->integer('score_a')->nullable();
            $table->integer('score_b')->nullable();
            $table->timestamps();
        });

        // Add foreign keys
        Schema::table('results', function (Blueprint $table) {
            $table->foreign('match_id')->references('id')->on('matches')->cascadeOnDelete();
            $table->foreign('winner_team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
