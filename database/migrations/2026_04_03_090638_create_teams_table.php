<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('pandascore_id')->nullable()->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('acronym')->nullable();
            $table->string('tag')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('country')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });

        // Add foreign keys
        Schema::table('teams', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('game_id')->references('id')->on('games')->cascadeOnDelete();
            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
