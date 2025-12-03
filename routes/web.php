<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\KetersediaanController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'viewLogin')->name('login');
    Route::post('/login', 'login')->name('login.process'); // ← FIXED
    Route::get('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (HARUS LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::controller(RoleController::class)->group(function () {
        Route::resource('roles', RoleController::class);
    });

    Route::controller(KategoriController::class)->group(function () {
        Route::resource('/kategori', KategoriController::class);
    });

    Route::controller(UserController::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::get('users/restore/{id}', 'restore')->name('users.restore');
    });

    Route::controller(KomoditasController::class)->group(function () {
        Route::post('/komoditas/{id}/status', [KomoditasController::class, 'updateStatus'])->name('komoditas.status');
        Route::resource('/komoditas', KomoditasController::class);
    });

    Route::controller(KetersediaanController::class)->group(function () {
        Route::resource('/ketersediaan', KetersediaanController::class);
    });
});