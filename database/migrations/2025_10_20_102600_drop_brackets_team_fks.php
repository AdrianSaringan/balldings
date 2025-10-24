<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            // Best-effort: drop by known Laravel default names if they exist
            try { $table->dropForeign('brackets_team1_id_foreign'); } catch (\Throwable $e) {}
            try { $table->dropForeign('brackets_team2_id_foreign'); } catch (\Throwable $e) {}
        });

        // Ensure columns remain plain unsignedBigInteger, nullable (no FK). Avoids requiring doctrine/dbal.
        // If your columns are already unsigned big integers (as created by foreignId), no changes are needed.
        // If you previously had cascading behavior you want to keep, enforce it at application level by sport.
    }

    public function down(): void
    {
        // We won't recreate the FKs because they depend on the selected sport.
        // Down migration intentionally left empty to avoid re-introducing a wrong constraint.
    }
};
