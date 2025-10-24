<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            if (!Schema::hasColumn('brackets', 'tournament_name')) {
                $table->string('tournament_name')->nullable()->after('sport');
            }
        });
    }

    public function down(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            if (Schema::hasColumn('brackets', 'tournament_name')) {
                $table->dropColumn('tournament_name');
            }
        });
    }
};
