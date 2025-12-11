<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\KetersediaanController;
use App\Http\Controllers\RekapKetersediaan;
use App\Http\Controllers\ScrapingSiharpaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landingpages.index');
})->name('landing.index');

Route::get('/komoditas', function () {
    return view('landingpages.komoditas');
})->name('landing.komoditas');

Route::get('/peta', function () {
    return view('landingpages.peta');
})->name('landing.peta');

Route::get('/pantauan-harga', function () {
    return view('landingpages.pantauan-harga');
})->name('landing.pantauan');


Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'viewLogin')->name('login');
    Route::post('/login', 'login')->name('login.process'); 
    Route::post('/logout', 'logout')->name('logout');
});


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


    // Transaksi Data

    Route::controller(KetersediaanController::class)->group(function () {
        Route::resource('/ketersediaan', KetersediaanController::class);
    });

    Route::controller(RekapKetersediaan::class)->group(function () {
        Route::resource('/rekap', RekapKetersediaan::class);
    });

    Route::controller(ScrapingSiharpaController::class)->group(function () {
        Route::get('/bahanpokok', [ScrapingSiharpaController::class, 'index'])->name('bahanpokok.index');
        Route::post('/bahanpokok/scrape', [ScrapingSiharpaController::class, 'scrapeData'])->name('bahanpokok.scrape');
        Route::post('/bahanpokok/store-from-table', [ScrapingSiharpaController::class, 'storeDataFromTable'])->name('bahanpokok.storeDataFromTable');
        Route::post('/bahanpokok/scrape-ajax', [ScrapingSiharpaController::class, 'scrapeAjax'])->name('bahanpokok.scrapeAjax');
    });

    

    // Placeholder for menu items that are not ready yet
    Route::get('/coming-soon', function () {
        abort(404);
    })->name('feature.placeholder');
});
