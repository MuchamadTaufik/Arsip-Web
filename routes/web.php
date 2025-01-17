<?php

use App\Http\Controllers\Admin\BiodataController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\KelolaAkunController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardAdminController;
use App\Http\Controllers\Admin\RiwayatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'guest'], function() {
   Route::get('/login', [AuthController::class, 'index'])->name('login');
   Route::post('/login', [AuthController::class, 'auth'])->name('auth.login');
});

Route::group(['middleware' => 'auth'], function() {
   Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
   Route::get('/', [DashboardAdminController::class, 'index'])->name('home');

   // Biodata
   Route::get('/pegawai/create', [BiodataController::class, 'create'])->name('pegawai.create');
   Route::post('/pegawai/store', [BiodataController::class, 'store'])->name('pegawai.store');
   Route::delete('/pegawai/delete/{biodata}', [BiodataController::class, 'destroy'])->name('pegawai.destroy');

   // Edit Riwayat
   Route::delete('/pegawai/riwayat/delete/{id}', [RiwayatController::class, 'destroy'])->name('pegawai.riwayat.destroy');

   //Edit Pegawai
   Route::get('/pegawai/{id}/edit', [BiodataController::class, 'edit'])->name('pegawai.edit');
   Route::put('/pegawai/update/{id}', [BiodataController::class, 'update'])->name('pegawai.update');

   //Dokumen
   Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
   Route::post('/dokumen/store', [DokumenController::class, 'store'])->name('dokumen.store');
   Route::get('/dokumen/edit/{dokumen}', [DokumenController::class, 'edit'])->name('dokumen.edit');
   Route::put('/dokumen/update/{dokumen}', [DokumenController::class, 'update'])->name('dokumen.update');
   Route::delete('/dokumen/delete/{dokumen}', [DokumenController::class, 'destroy'])->name('dokumen.delete');

   Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
   Route::get('/laporan/download', [LaporanController::class, 'export'])->name('reports.export');
   

   Route::get('/kelola-akun', [KelolaAkunController::class, 'index'])->name('kelola.akun');
   Route::get('/kelola-akun/create', [KelolaAkunController::class, 'create'])->name('kelola.akun.create');
   Route::post('/kelola-akun/store', [KelolaAkunController::class, 'store'])->name('kelola.akun.store');
   Route::get('/kelola-akun/edit/{akun}', [KelolaAkunController::class, 'edit'])->name('kelola.akun.edit');
   Route::put('/kelola-akun/update/{akun}', [KelolaAkunController::class, 'update'])->name('kelola.akun.update');
   Route::delete('/kelola-akun/delete/{akun}', [KelolaAkunController::class, 'destroy'])->name('kelola.akun.delete');
});

Route::group(['middleware' => ['auth', 'role:admin,pegawai']], function(){

   // Biodata
   Route::get('/pegawai', [BiodataController::class, 'index'])->name('pegawai');
   Route::get('/pegawai/search', [BiodataController::class, 'search'])->name('pegawai.search');

   Route::get('/pegawai/show/{slug}', [BiodataController::class, 'show'])->name('pegawai.show');

   //Dokumen
   Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen');
   Route::get('/dokumen/show/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show');
   
});

Route::group(['middleware' => ['auth', 'role:pegawai']], function(){
   Route::get('/arsip', [DashboardAdminController::class, 'indexPegawai'])->name('arsip');
   
});