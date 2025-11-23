<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AturanController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua endpoint di bawah ini bebas diakses tanpa middleware 'auth',
| agar dapat digunakan dari aplikasi mobile (Flutter, dsb).
|
| Jika kamu ingin menambahkan autentikasi token di masa depan,
| gunakan middleware auth:sanctum atau passport sesuai kebutuhan.
*/

// =======================
//       GEJALA
// =======================
Route::get('/gejala', [GejalaController::class, 'apiIndex']);
Route::get('/gejala/{id}', [GejalaController::class, 'apiShow']);

// =======================
//       PENYAKIT
// =======================
Route::get('/penyakit', [PenyakitController::class, 'apiIndex']);
Route::get('/penyakit/{id}', [PenyakitController::class, 'apiShow']);

// =======================
//       ATURAN
// =======================
Route::get('/aturan', [AturanController::class, 'apiIndex']);

// =======================
//     DIAGNOSA (USER)
// =======================
Route::get('/diagnosa', [DiagnosaController::class, 'apiIndex']);
Route::post('/diagnosa', [DiagnosaController::class, 'apiStore']); // Kirim data diagnosa (nama hewan, gejala, dsb)

// =======================
//       ADMIN
// =======================
Route::get('/admin', [AdminController::class, 'apiIndex']);

// =======================
//        LOGIN API
// =======================
Route::post('/login', [LoginController::class, 'apiLogin']);
Route::post('/logout', [LoginController::class, 'apiLogout']); // Opsional, jika pakai token login
