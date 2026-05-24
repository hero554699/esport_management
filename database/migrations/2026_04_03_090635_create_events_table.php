<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('pandascore_id')->nullable()->unique();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('status', ['upcoming', 'live', 'completed'])->default('upcoming');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->enum('type', ['local', 'national', 'international', 'world'])->default('local');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('prize_pool')->nullable();
            $table->string('banner_url')->nullable();
            $table->timestamps();
        });

        // Add foreign keys after table creation
        Schema::table('events', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
