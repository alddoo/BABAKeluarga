<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('kegiatan');
            // Menambahkan kolom deskripsi (text digunakan agar muat lebih banyak karakter)
            $table->text('deskripsi')->nullable(); 
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('daily_reports');
    }
};