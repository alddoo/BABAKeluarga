<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('penilaian_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('penilaian_header_id')->constrained('penilaian_headers')->cascadeOnDelete();

      $table->string('anggota');
      $table->string('posisi');

      $table->unsignedTinyInteger('waktu');
      $table->unsignedTinyInteger('kerja_sama');
      $table->unsignedTinyInteger('hospitality');
      $table->unsignedTinyInteger('komunikasi');
      $table->unsignedTinyInteger('inisiatif');

      $table->unsignedTinyInteger('nilai_akhir');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('penilaian_items');
  }
};
