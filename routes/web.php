<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ComidaController;

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
    
    Route::get('/comida', [ComidaController::class, 'index'])->name('comida.index');
    Route::get('/comida/create', [ComidaController::class, 'create'])->name('comida.create');
    Route::post('/comida', [ComidaController::class, 'store'])->name('comida.store');
    Route::get('/comida/{comida}', [ComidaController::class, 'show'])->name('comida.show');
    Route::get('/comida/{comida}/edit', [ComidaController::class, 'edit'])->name('comida.edit');
    Route::put('/comida/{comida}', [ComidaController::class, 'update'])->name('comida.update');
    Route::delete('/comida/{comida}', [ComidaController::class, 'destroy'])->name('comida.destroy');
});

require __DIR__.'/auth.php';
