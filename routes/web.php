<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TestController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot.password');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'signIn'])->name('auth.sign.in');
