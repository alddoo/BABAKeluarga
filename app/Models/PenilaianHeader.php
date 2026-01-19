<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianHeader extends Model
{
  protected $fillable = ['user_id','pengantin','tanggal','tempat'];

  public function user(){ return $this->belongsTo(User::class); }
  public function items(){ return $this->hasMany(PenilaianItem::class); }
}
