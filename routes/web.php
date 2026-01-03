<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\KetersediaanController;
use App\Http\Controllers\RekapKetersediaan;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScrapingSiharpaController;
use App\Http\Controllers\DistributionDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LandingPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landingpages.index');
})->name('home');

Route::prefix('landing')->controller(LandingPageController::class)->group(function () {
    Route::get('/dashboard', 'dashboardPage')->name('landing.dashboard');

    Route::get('/komoditas', 'komoditasPage')->name('landing.komoditas');
    Route::get('/getLanding-Komoditas', 'getLandingKomoditas')->name('getLandingKomoditas');
    
    Route::get('/pantauan-harga', 'pantauanHargaPage')->name('landing.pantauan-harga');

    Route::get('/peta', 'petaPage')->name('landing.peta');
    Route::get('/getLanding-Peta', 'getLandingPeta')->name('getLandingPeta');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'viewLogin')->name('login');
    Route::post('/login', 'login')->name('login.process'); 
    Route::post('/logout', 'logout')->name('logout');
});


Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    Route::get('/download-template', [DistributionDataController::class, 'indextemplate'])->name('distribution_data.download');
    Route::get('/download-template/export-template/{month}', [DistributionDataController::class, 'exportTemplate'])->name('distribution_data.export-template');
    Route::post('/download-template/upload-template', [DistributionDataController::class, 'uploadTemplate'])->name('distribution_data.upload-template');

    Route::get('/distributiondata', [DistributionDataController::class, 'index'])->name('distribution_data.index');

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
