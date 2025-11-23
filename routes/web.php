<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AturanController;
use App\Http\Controllers\AturanGejalaController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

// ===============================
// Public (Tanpa Login)
// ===============================
Route::get('/', [HomeController::class, '__invoke']);
Route::get('/dokter', [DokterController::class, 'index'])->name('dokter');

// ===============================
// Login / Logout
// ===============================
Route::get('/login', [LoginController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('admin_or_user');

// ===============================
// Admin dan User (akses bersama)
// ===============================
Route::middleware('admin_or_user:admin')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::resource('gejala', GejalaController::class);
    Route::resource('penyakit', PenyakitController::class);
    Route::resource('aturan', AturanController::class);
    Route::resource('aturangejala', AturanGejalaController::class);
});

Route::middleware('admin_or_user:user')->group(function () {
    Route::resource('diagnosa', DiagnosaController::class)->except(['index']);
});

Route::middleware('admin_or_user')->group(function () {
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
});

// ===============================
// Manajemen Akun
// ===============================
Route::resource('admin', AdminController::class);
Route::resource('user', UserController::class)->except(['index']);
