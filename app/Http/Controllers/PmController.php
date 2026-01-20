<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\PenilaianHeader;
use App\Models\PenilaianItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PmController extends Controller
{
  public function form()
  {
    $anggotaList = Anggota::orderBy('nama')->get(); // dropdown dari database
    $posisiList  = ['Project Manager',
    'Personal Assistant',
    'Wedding Assistant',
    'Stage Manager',
    'Music Director',
    'LO Mc',
    'Runner',
    'Register',
    'VIP'];
    return view('pm.form', compact('anggotaList','posisiList'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'pengantin' => ['required','string','max:255'],
      'tanggal'   => ['required','date'],
      'tempat'    => ['required','string','max:255'],

      'items'               => ['required','array','min:1'],
      'items.*.anggota'     => ['required','string','max:255'],
      'items.*.posisi'      => ['required','string','max:255'],
      'items.*.waktu'       => ['required','integer','min:1','max:20'],
      'items.*.kerja_sama'  => ['required','integer','min:1','max:20'],
      'items.*.hospitality' => ['required','integer','min:1','max:20'],
      'items.*.komunikasi'  => ['required','integer','min:1','max:20'],
      'items.*.inisiatif'   => ['required','integer','min:1','max:20'],
    ]);

    DB::transaction(function () use ($request) {
      $header = PenilaianHeader::create([
        'user_id'   => auth()->id(),
        'pengantin' => $request->pengantin,
        'tanggal'   => $request->tanggal,
        'tempat'    => $request->tempat,
      ]);

      foreach ($request->items as $row) {
        $nilaiAkhir = $row['waktu'] + $row['kerja_sama'] + $row['hospitality'] + $row['komunikasi'] + $row['inisiatif'];

        PenilaianItem::create([
          'penilaian_header_id' => $header->id,
          'anggota' => $row['anggota'],
          'posisi'  => $row['posisi'],
          'waktu'   => $row['waktu'],
          'kerja_sama'  => $row['kerja_sama'],
          'hospitality' => $row['hospitality'],
          'komunikasi'  => $row['komunikasi'],
          'inisiatif'   => $row['inisiatif'],
          'nilai_akhir' => $nilaiAkhir,
        ]);
      }
    });

    return back()->with('ok','Penilaian berhasil disimpan.');
  }
}
