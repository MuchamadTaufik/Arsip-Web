<?php

use App\Http\Controllers\Admin\BiodataController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardAdminController;
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

   Route::get('/pegawai', [BiodataController::class, 'index'])->name('pegawai');
   Route::get('/pegawai/create', [BiodataController::class, 'create'])->name('pegawai.create');
});