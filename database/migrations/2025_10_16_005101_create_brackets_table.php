<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brackets', function (Blueprint $table) {
            $table->id();
            $table->string('sport'); // basketball or volleyball
            $table->foreignId('team1_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team2_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('round')->default(1);
            $table->string('status')->default('pending'); // pending, ongoing, completed
            $table->string('winner')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brackets');
    }
};
