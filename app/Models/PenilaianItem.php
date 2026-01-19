<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianItem extends Model
{
  protected $fillable = [
    'penilaian_header_id','anggota','posisi',
    'waktu','kerja_sama','hospitality','komunikasi','inisiatif',
    'nilai_akhir'
  ];

  public function header(){ return $this->belongsTo(PenilaianHeader::class,'penilaian_header_id'); }
}
