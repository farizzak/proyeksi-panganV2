<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dashboard
Route::view('/', 'admin.dashboard');
Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

// ==========================
// Role Management
// ==========================
Route::controller(RoleController::class)->group(function () {
    Route::resource('roles', RoleController::class);
});

// ==========================
// User Management
// ==========================
Route::controller(UserController::class)->group(function () {
    Route::resource('users', UserController::class);
    Route::get('users/restore/{id}', 'restore')->name('users.restore');
});