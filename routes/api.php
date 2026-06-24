<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\PantauanHargaApiController;
use App\Http\Controllers\Api\KomoditasApiController;
use App\Http\Controllers\Api\UserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/pantauan-harga', [PantauanHargaApiController::class, 'index']);
Route::get('/kategori/count', [KategoriApiController::class, 'count']);
Route::get('/komoditas/count', [KomoditasApiController::class, 'count']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-token', [AuthController::class, 'checkToken']);

    Route::get('/kategori', [KategoriApiController::class, 'index']);
    Route::post('/kategori', [KategoriApiController::class, 'store']);
    Route::match(['put', 'patch'], '/kategori/{id}', [KategoriApiController::class, 'update']);

    Route::get('/komoditas', [KomoditasApiController::class, 'index']);
    Route::post('/komoditas', [KomoditasApiController::class, 'store']);
    Route::match(['put', 'patch'], '/komoditas/{id}', [KomoditasApiController::class, 'update']);

    Route::match(['put', 'patch'], '/user', [UserApiController::class, 'update']);
});
