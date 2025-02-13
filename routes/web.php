<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Pegawai Management
    Route::get('/pegawai', [AdminController::class, 'pegawaiIndex'])->name('pegawai.index');
    Route::get('/pegawai/create', [AdminController::class, 'pegawaiCreate'])->name('pegawai.create');
    Route::post('/pegawai', [AdminController::class, 'pegawaiStore'])->name('pegawai.store');
    Route::get('/pegawai/{pegawai}/edit', [AdminController::class, 'pegawaiEdit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [AdminController::class, 'pegawaiUpdate'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [AdminController::class, 'pegawaiDestroy'])->name('pegawai.destroy');
    
    // Kontrak Management
    Route::get('/kontrak', [AdminController::class, 'kontrakIndex'])->name('kontrak.index');
    Route::get('/kontrak/create', [AdminController::class, 'kontrakCreate'])->name('kontrak.create');
    Route::post('/kontrak', [AdminController::class, 'kontrakStore'])->name('kontrak.store');
    Route::get('/kontrak/{kontrak}/edit', [AdminController::class, 'kontrakEdit'])->name('kontrak.edit');
    Route::put('/kontrak/{kontrak}', [AdminController::class, 'kontrakUpdate'])->name('kontrak.update');
    Route::delete('/kontrak/{kontrak}', [AdminController::class, 'kontrakDestroy'])->name('kontrak.destroy');
});

// Employee Routes
Route::prefix('employee')->name('employee.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');
    Route::put('/profile', [EmployeeController::class, 'updateProfile'])->name('profile.update');
    Route::get('/kontrak', [EmployeeController::class, 'kontrak'])->name('kontrak');
});
