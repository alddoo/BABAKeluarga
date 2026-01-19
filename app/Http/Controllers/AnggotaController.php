<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\PenilaianItem;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
  public function index(Request $request)
  {
    $q = $request->query('q');

    $anggotas = Anggota::query()
      ->when($q, fn($qq) => $qq->where('nama','like',"%$q%")->orWhere('posisi','like',"%$q%"))
      ->orderBy('nama')
      ->paginate(10)
      ->withQueryString();

    // Tambahkan jumlah penilaian untuk setiap anggota
    foreach ($anggotas as $anggota) {
      $evaluations = PenilaianItem::where('anggota', $anggota->nama)->get();
      $anggota->penilaian_count = $evaluations->count();
      $anggota->nilai_akhir_avg = $evaluations->avg('nilai_akhir') ?? 0;
    }

    return view('admin.anggota.index', compact('anggotas','q'));
  }

  public function create()
  {
    return view('admin.anggota.create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'nama'   => ['required','string','max:255'],
      'posisi' => ['nullable','string','max:255'],
    ]);

    Anggota::create($data);

    return redirect()->route('admin.anggota.index')->with('ok','Anggota berhasil ditambahkan.');
  }

  public function edit(Anggota $anggota)
  {
    return view('admin.anggota.edit', compact('anggota'));
  }

  public function update(Request $request, Anggota $anggota)
  {
    $data = $request->validate([
      'nama'   => ['required','string','max:255'],
      'posisi' => ['nullable','string','max:255'],
    ]);

    $anggota->update($data);

    return redirect()->route('admin.anggota.index')->with('ok','Anggota berhasil diupdate.');
  }

  public function destroy(Anggota $anggota)
  {
    $anggota->delete();
    return redirect()->route('admin.anggota.index')->with('ok','Anggota berhasil dihapus.');
  }
}
