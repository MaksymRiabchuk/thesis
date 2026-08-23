<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\OffersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'signIn'])->name('auth.sign.in');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendPassword'])->name('auth.forgot.send.password');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'signUp'])->name('auth.sign.up');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'updatePassword'])
    ->middleware('guest')
    ->name('password.store');

Route::prefix('/admin')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/offers', [OffersController::class, 'index'])->name('admin.offers');
    Route::get('/offers/personal', [OffersController::class, 'personalOffers'])->name('admin.offers.personal');
    Route::get('/offers/create', [OffersController::class, 'create'])->name('admin.offers.create');
    Route::post('/offers', [OffersController::class, 'store'])->name('admin.offers.store');
    Route::get('/offers/{offer}/edit', [OffersController::class, 'edit'])->name('admin.offers.edit');
    Route::put('/offers/{offer}', [OffersController::class, 'update'])->name('admin.offers.update');

    Route::middleware(['is_admin'])->group(function () {
        Route::get('/categories', [CategoriesController::class, 'index'])->name('admin.categories');
        Route::get('/categories/create', [CategoriesController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

        Route::get('/faqs', [FaqsController::class, 'index'])->name('admin.faqs');
        Route::get('/faqs/create', [FaqsController::class, 'create'])->name('admin.faqs.create');
        Route::post('/faqs', [FaqsController::class, 'store'])->name('admin.faqs.store');
        Route::get('/faqs/{faq}/edit', [FaqsController::class, 'edit'])->name('admin.faqs.edit');
        Route::put('/faqs/{faq}', [FaqsController::class, 'update'])->name('admin.faqs.update');
        Route::delete('/faqs/{faq}', [FaqsController::class, 'destroy'])->name('admin.faqs.destroy');
    });
})->name('admin.index');