<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AspirasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\AspirasiAdminController;

// ===== ROUTE AUTH / ASPIRASI USER =====
Route::middleware(['auth'])->group(function () {
    Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('/aspirasi/history', [AspirasiController::class, 'history'])->name('aspirasi.history');
});

// ===== ROUTE ADMIN =====
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Aspirasi Admin
    Route::get('/aspirasi', [AspirasiAdminController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{id}', [AspirasiAdminController::class, 'show'])->name('aspirasi.show');
    Route::post('/aspirasi/{id}/feedback', [AspirasiAdminController::class, 'feedback'])->name('aspirasi.feedback');

    // ===== JURUSAN =====
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::get('/jurusan/{id}/delete', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // ===== KELAS =====
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{id}/delete', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // ===== SISWA =====
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});

// ===== LOGIN / LOGOUT =====
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.process');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');
