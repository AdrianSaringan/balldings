<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('basketballs', function (Blueprint $table) {
        $table->id();
        $table->string('team_name');
        $table->string('coach_name');
        $table->integer('number_of_players');
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('basketballs');
    }
};
