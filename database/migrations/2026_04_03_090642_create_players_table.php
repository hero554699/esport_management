<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('pandascore_id')->nullable()->unique();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('country')->nullable();
            $table->timestamps();
        });

        // Add foreign key
        Schema::table('players', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
