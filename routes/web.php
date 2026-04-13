<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ImageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->middleware(['auth'])->name('home');

Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('register');
    Route::post('/', [RegisterController::class, 'store']);
});

Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});
Route::post('/logout', [LogoutController::class, 'store'])->middleware(['auth'])->name('logout');

Route::prefix('company')->middleware(['auth'])->group(function () {
    Route::get('/{id}', [CompanyController::class, 'index'])->name('company.index');
    Route::put('/{id}', [CompanyController::class, 'update'])->name('company.update');
});

Route::prefix('images')->middleware(['auth'])->group(function () {
    Route::get('/user', [ImageController::class, 'generateUserImage'])->name('images.user');
    Route::get('/company', [ImageController::class, 'generateCompanyImage'])->name('images.company');
    Route::get('/pdf', [ImageController::class, 'generatePDF'])->name('images.pdf');
});
