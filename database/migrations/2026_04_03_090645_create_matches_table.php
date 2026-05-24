<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('pandascore_id')->nullable()->unique();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('team_a_id')->nullable();
            $table->unsignedBigInteger('team_b_id')->nullable();
            $table->string('stage')->nullable();
            $table->enum('status', ['scheduled', 'live', 'completed', 'cancelled'])->default('scheduled');
            $table->dateTime('scheduled_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->constrained('events', 'event_id', 'id')->onDelete('cascade');
            $table->constrained('teams', 'team_a_id', 'id')->onDelete('cascade');
            $table->constrained('teams', 'team_b_id', 'id')->onDelete('cascade');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        Schema::dropIfExists('matches');

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
};
