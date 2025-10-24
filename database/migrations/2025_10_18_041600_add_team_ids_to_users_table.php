<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('basketball_team_id')->nullable()->constrained('basketballs')->nullOnDelete();
            $table->foreignId('volleyball_team_id')->nullable()->constrained('volleyballs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('basketball_team_id');
            $table->dropConstrainedForeignId('volleyball_team_id');
        });
    }
};
