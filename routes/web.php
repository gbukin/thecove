<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PromotionsController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::name('news.')->prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/data', [NewsController::class, 'data'])->name('data');

        Route::get('/show/{news}', [NewsController::class, 'show'])->name('show');

        Route::get('/create', [NewsController::class, 'create'])->name('create');
        Route::post('/store', [NewsController::class, 'store'])->name('store');

        Route::get('/edit/{news}', [NewsController::class, 'edit'])->name('edit');
        Route::post('/update/{news}', [NewsController::class, 'update'])->name('update');
    });

    Route::name('promotions.')->prefix('promotions')->group(function () {
        Route::get('/', [PromotionsController::class, 'index'])->name('index');
        Route::get('/data', [PromotionsController::class, 'data'])->name('data');

        Route::get('/show/{promotion}', [PromotionsController::class, 'show'])->name('show');

        Route::get('/create', [PromotionsController::class, 'create'])->name('create');
        Route::post('/store', [PromotionsController::class, 'store'])->name('store');

        Route::get('/edit/{promotion}', [PromotionsController::class, 'edit'])->name('edit');
        Route::post('/update/{promotion}', [PromotionsController::class, 'update'])->name('update');
    });
});

Route::redirect('/', '/login')->middleware('guest');
Route::redirect('/', '/news')->middleware('auth');

require __DIR__.'/auth.php';
