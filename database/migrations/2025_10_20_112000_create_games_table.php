<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('sport'); // basketball or volleyball
            $table->unsignedBigInteger('team1_id')->nullable(); // references basketballs/volleyballs by sport
            $table->unsignedBigInteger('team2_id')->nullable();
            $table->unsignedInteger('team1_score')->default(0);
            $table->unsignedInteger('team2_score')->default(0);
            $table->string('status')->default('scheduled'); // scheduled, ongoing, completed
            $table->dateTime('played_at')->nullable();
            $table->string('venue')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
