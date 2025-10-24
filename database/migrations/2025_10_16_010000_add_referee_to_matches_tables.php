<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('basketball_matches', function (Blueprint $table) {
            $table->foreignId('referee_id')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('volleyball_matches', function (Blueprint $table) {
            $table->foreignId('referee_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('basketball_matches', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referee_id');
        });
        Schema::table('volleyball_matches', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referee_id');
        });
    }
};
