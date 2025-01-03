<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\IsLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginView'])->name('login');
// Route::post('/', [UserController::class, 'login']);

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(IsLogin::class)->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/formPlastik', [LaporanController::class, 'formPlastik']);
    Route::get('/laporan/formLogam', [LaporanController::class, 'formLogam']);
    Route::post('/laporan/simpan', [LaporanController::class, 'simpan'])->name('laporan.simpan');
    Route::get('/laporan/view/{id}', [LaporanController::class, 'view'])->name('laporan.view');
    Route::get('/laporan/export/{id}', [LaporanController::class, 'export'])->name('laporan.export');
});


