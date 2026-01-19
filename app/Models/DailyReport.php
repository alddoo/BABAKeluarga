<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DailyReport extends Model
{
    protected $fillable = [
        'user_id', 
        'nama', 
        'tanggal', 
        'waktu', 
        'kegiatan', 
        'deskripsi', 
        'file_path'
    ];

    public function user()
    { 
        return $this->belongsTo(User::class); 
    }
}