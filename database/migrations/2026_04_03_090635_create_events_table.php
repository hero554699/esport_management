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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pandascore_id')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('status', ['upcoming', 'live', 'completed'])->default('upcoming');
            $table->enum('type', ['local', 'national', 'international', 'world'])->default('local');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('prize_pool')->nullable();
            $table->string('banner_url')->nullable();
            $table->string('certification_path')->nullable();
            $table->boolean('is_certification_public')->default(false);
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
