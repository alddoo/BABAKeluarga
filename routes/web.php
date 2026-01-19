<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WaController;
use App\Http\Controllers\PmController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;


Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.process');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::middleware(['auth','role:wa'])->group(function () {
  Route::get('/wa', [WaController::class,'form'])->name('wa.form');
  Route::post('/wa', [WaController::class,'store'])->name('wa.store');
  Route::get('/wa/history', [WaController::class,'history'])->name('wa.history');
});

Route::middleware(['auth','role:pm'])->group(function () {
  Route::get('/pm', [PmController::class,'form'])->name('pm.form');
  Route::post('/pm', [PmController::class,'store'])->name('pm.store');
});

Route::middleware(['auth','role:admin'])->group(function () {
  Route::get('/admin', [AdminController::class,'dashboard'])->name('admin.dashboard');
  Route::get('/admin/daily-report', [AdminController::class,'daily'])->name('admin.daily');
  Route::get('/admin/penilai-pm', [AdminController::class,'penilaian'])->name('admin.penilaian');

  // --- TAMBAHKAN RUTE EKSPOR DI SINI ---
  Route::get('/admin/daily-report/pdf', [AdminController::class, 'exportPdf'])->name('daily.export.pdf');
  Route::get('/admin/daily-report/word', [AdminController::class, 'exportWord'])->name('daily.export.word');
  // -------------------------------------

  // CRUD Anggota
  Route::get('/admin/anggota', [AnggotaController::class,'index'])->name('admin.anggota.index');
  Route::get('/admin/anggota/create', [AnggotaController::class,'create'])->name('admin.anggota.create');
  Route::post('/admin/anggota', [AnggotaController::class,'store'])->name('admin.anggota.store');
  Route::get('/admin/anggota/{anggota}/edit', [AnggotaController::class,'edit'])->name('admin.anggota.edit');
  Route::put('/admin/anggota/{anggota}', [AnggotaController::class,'update'])->name('admin.anggota.update');
  Route::delete('/admin/anggota/{anggota}', [AnggotaController::class,'destroy'])->name('admin.anggota.destroy');
});