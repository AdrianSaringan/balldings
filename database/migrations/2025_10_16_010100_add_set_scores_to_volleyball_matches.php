<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('volleyball_matches', function (Blueprint $table) {
            $table->json('set_scores')->nullable()->after('score_team_b');
        });
    }

    public function down(): void
    {
        Schema::table('volleyball_matches', function (Blueprint $table) {
            $table->dropColumn('set_scores');
        });
    }
};
