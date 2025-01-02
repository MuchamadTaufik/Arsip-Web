<?php

use App\Http\Controllers\Admin\BiodataController;
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


Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'auth'])->name('auth.login')->middleware('guest');

Route::group(['middleware' => ['auth', 'role:admin']], function(){
   Route::get('/', [DashboardAdminController::class, 'index'])->name('home');

   // Biodata
   Route::get('/pegawai', [BiodataController::class, 'index'])->name('pegawai');
   Route::get('/pegawai/create', [BiodataController::class, 'create'])->name('pegawai.create');
   Route::post('/pegawai/store', [BiodataController::class, 'store'])->name('pegawai.store');
   Route::delete('/pegawai/delete/{slug}', [BiodataController::class, 'destroy'])->name('pegawai.destroy');
   Route::get('/pegawai/search', [BiodataController::class, 'search'])->name('pegawai.search');

   // Edit Riwayat
   Route::delete('/pegawai/riwayat/delete/{id}', [RiwayatController::class, 'destroy'])->name('pegawai.riwayat.destroy');

   
   Route::get('/pegawai/{id}/edit', [BiodataController::class, 'edit'])->name('pegawai.edit');

   Route::put('/pegawai/update/{slug}', [BiodataController::class, 'update'])->name('pegawai.update');
   
});