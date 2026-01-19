<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;

class AnggotaSeeder extends Seeder
{
  public function run(): void
  {
    Anggota::truncate();
    Anggota::create(['nama'=>'Anggota 1','posisi'=>'Crew']);
    Anggota::create(['nama'=>'Anggota 2','posisi'=>'Runner']);
    Anggota::create(['nama'=>'Anggota 3','posisi'=>'PIC']);
  }
}
