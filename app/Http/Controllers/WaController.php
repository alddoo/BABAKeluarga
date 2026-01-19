<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianItem;
use App\Models\DailyReport;

class WaController extends Controller
{
    public function form()
    {
        $kegiatanList = ['Meeting Pertama','Meeting Kedua','Technical Meeting', 'Test Food', 'Gladi','Dekorasi','Lain-lain'];
        return view('wa.form', compact('kegiatanList'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Data (Menambahkan deskripsi)
        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:255'],
            'tanggal'   => ['required', 'date'],
            'waktu'     => ['required', 'date_format:H:i'],
            'kegiatan'  => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'], // Menambahkan deskripsi wajib diisi
            'file'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        // 2. Handling Upload File
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('daily_reports', 'public');
        }

        // 3. Simpan ke Database
        DailyReport::create([
            'user_id'   => auth()->id(),
            'nama'      => $data['nama'],
            'tanggal'   => $data['tanggal'],
            'waktu'     => $data['waktu'],
            'kegiatan'  => $data['kegiatan'],
            'deskripsi' => $data['deskripsi'], // Simpan data deskripsi
            'file_path' => $filePath,
        ]);

        // 4. Kembali dengan Pesan Sukses
        return back()->with('ok', 'Daily report berhasil disimpan.');
    }

    public function history() {
        $reports = DailyReport::all();
        return view('wa.history', compact('reports'));
    }
}