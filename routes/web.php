<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Guru\KelasController;
use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Ortu\MonitoringController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::get('siswa/{siswa}/barcode', [SiswaController::class, 'generateBarcode'])->name('siswa.barcode');
    Route::resource('mata-pelajaran', MataPelajaranController::class);
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kela']);
    Route::post('kelas/{kela}/toggle-active', [KelasController::class, 'toggleActive'])->name('kelas.toggle-active');
    Route::get('kelas/{kela}/manage-siswa', [KelasController::class, 'manageSiswa'])->name('kelas.manage-siswa');
    Route::post('kelas/{kela}/update-siswa', [KelasController::class, 'updateSiswa'])->name('kelas.update-siswa');
    
    Route::get('kelas/{kela}/scan', [AbsensiController::class, 'scan'])->name('absensi.scan');
    Route::post('kelas/{kela}/scan', [AbsensiController::class, 'processScan'])->name('absensi.process');
    Route::get('kelas/{kela}/riwayat', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    Route::delete('kelas/{kela}/absensi/{absensi}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
    
    Route::get('kelas/{kela}/laporan', [\App\Http\Controllers\Guru\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('kelas/{kela}/laporan', [\App\Http\Controllers\Guru\LaporanController::class, 'generate'])->name('laporan.generate');
    Route::post('kelas/{kela}/laporan/export-csv', [\App\Http\Controllers\Guru\LaporanController::class, 'exportCsv'])->name('laporan.export-csv');
    Route::post('kelas/{kela}/laporan/export-excel', [\App\Http\Controllers\Guru\LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::post('kelas/{kela}/laporan/export-pdf', [\App\Http\Controllers\Guru\LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
});

// Orang Tua Routes
Route::middleware(['auth', 'role:ortu'])->prefix('ortu')->name('ortu.')->group(function () {
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::match(['get', 'post'], '/monitoring/search', [MonitoringController::class, 'search'])->name('monitoring.search');
});
