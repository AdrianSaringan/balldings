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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('sport')->nullable();
            $table->string('position')->nullable();
            $table->date('dob')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('experience')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->integer('jersey_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'sport',
                'position',
                'dob',
                'height',
                'weight',
                'experience',
                'emergency_contact',
                'jersey_number',
            ]);
        });
    }
};
