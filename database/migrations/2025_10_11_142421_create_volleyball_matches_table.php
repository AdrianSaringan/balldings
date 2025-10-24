<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volleyball_matches', function (Blueprint $table) {
            $table->id();
            $table->string('team_a');
            $table->string('team_b');
            $table->date('match_date');
            $table->string('venue');
            $table->integer('score_team_a')->nullable();
            $table->integer('score_team_b')->nullable();
            $table->string('winner')->nullable();
            $table->enum('status', ['Upcoming', 'Ongoing', 'Finished'])->default('Upcoming');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volleyball_matches');
    }
};
