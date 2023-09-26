<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(static function () {
    Route::prefix('products')->as('products.')->group(static function () {
        Route::get('/', [ProductController::class, 'list'])->name('list');
        Route::post('/', [ProductController::class, 'create'])->name('create');

        Route::prefix('{product}')->group(static function () {
            Route::get('/', [ProductController::class, 'get'])->name('get');
            Route::put('/', [ProductController::class, 'update'])->name('update');
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

