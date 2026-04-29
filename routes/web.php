<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TestController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'signIn'])->name('auth.sign.in');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendPassword'])->name('auth.forgot.send.password');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'updatePassword'])
    ->middleware('guest')
    ->name('password.store');

Route::prefix('/admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
})->middleware('auth:admin')->name('admin.index');