<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(static function () {
    Route::prefix('products')->as('products.')->group(static function () {
        Route::get('/', [ProductController::class, 'list'])->name('list');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('store');

        Route::prefix('{product}')->group(static function () {
            Route::get('/', [ProductController::class, 'update'])->name('update');
            Route::post('/', [ProductController::class, 'save'])->name('save');
            Route::delete('/', [ProductController::class, 'delete'])->name('delete');
        });
    });
});
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

require __DIR__ . '/auth.php';

