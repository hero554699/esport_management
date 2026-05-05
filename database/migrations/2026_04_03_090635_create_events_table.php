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
            $table->foreignId('game_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('status', ['upcoming', 'live', 'completed'])->default('upcoming');
            $table->enum('type', ['local', 'national', 'international', 'world'])->default('local');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('prize_pool')->nullable();
            $table->string('banner_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};