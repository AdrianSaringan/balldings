<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_player_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('team_id')->nullable(); // references basketballs/volleyballs by sport
            $table->string('sport'); // basketball or volleyball
            // Basketball stats
            $table->unsignedInteger('points')->nullable();
            $table->unsignedInteger('rebounds')->nullable();
            $table->unsignedInteger('assists')->nullable();
            $table->unsignedInteger('steals')->nullable();
            $table->unsignedInteger('blocks')->nullable();
            $table->unsignedInteger('fouls')->nullable();
            $table->unsignedInteger('minutes')->nullable();
            // Volleyball stats
            $table->unsignedInteger('kills')->nullable();
            $table->unsignedInteger('aces')->nullable();
            $table->unsignedInteger('digs')->nullable();
            $table->unsignedInteger('vb_blocks')->nullable();
            $table->unsignedInteger('vb_assists')->nullable();
            $table->unsignedInteger('receptions')->nullable();
            $table->unsignedInteger('errors')->nullable();
            $table->unsignedInteger('sets_played')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_player_stats');
    }
};
