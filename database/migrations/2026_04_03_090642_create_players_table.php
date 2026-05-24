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
            $table->string('nickname')->nullable();
            $table->string('username')->nullable(); 
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('real_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
