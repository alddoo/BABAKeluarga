<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update nilai_akhir to be the sum of the 5 scores
        DB::statement('UPDATE penilaian_items SET nilai_akhir = waktu + kerja_sama + hospitality + komunikasi + inisiatif');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally, revert to average if needed, but since we're changing logic, maybe not necessary
        // DB::statement('UPDATE penilaian_items SET nilai_akhir = ROUND((waktu + kerja_sama + hospitality + komunikasi + inisiatif) / 5)');
    }
};
