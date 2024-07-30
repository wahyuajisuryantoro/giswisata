<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\WisataController;
use App\Http\Middleware\EnsureAdminIsAuthenticated;
use Illuminate\Support\Facades\Route;




Route::get('/', [FrontendController::class, 'index'])->name('index');;
Route::get('adminlogin', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('adminlogin', [AuthController::class, 'loginProcess'])->name('admin.loginProcess');
Route::post('/logout', [AuthController::class, 'logoutProcess'])->name('admin.logoutProcess');

Route::prefix('admin')->middleware([EnsureAdminIsAuthenticated::class])->group(function () {
    // Manajemen Maps
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/wisata', [WisataController::class, 'index'])->name('admin.wisata');
    Route::post('/wisata/store', [WisataController::class, 'store'])->name('admin.wisata.store');
    Route::put('/wisata/{id}', [WisataController::class, 'update'])->name('admin.wisata.update');
    Route::delete('/wisata/{id}', [WisataController::class, 'destroy'])->name('admin.wisata.destroy');
    // Manajemen Akun
    Route::get('/akun', [AkunController::class, 'index'])->name('admin.akun');
    Route::get('/akun/tambah', [AkunController::class, 'add'])->name('admin.akun.add');
    Route::post('/akun/store', [AkunController::class, 'store'])->name('admin.akun.store');
    Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('admin.akun.edit');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('admin.akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('admin.akun.destroy');
    
});