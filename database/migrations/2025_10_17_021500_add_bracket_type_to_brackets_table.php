<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            if (!Schema::hasColumn('brackets', 'bracket_type')) {
                $table->string('bracket_type')->default('upper')->after('winner');
            }
        });
    }

    public function down(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            if (Schema::hasColumn('brackets', 'bracket_type')) {
                $table->dropColumn('bracket_type');
            }
        });
    }
};
