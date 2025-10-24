<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('volleyballs', function (Blueprint $table) {
            $table->foreignId('coach_user_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('volleyballs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('coach_user_id');
        });
    }
};
