<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/vote/{id}', [VoteController::class, 'index'])->middleware('auth');
Route::post('/vote/{id}', [VoteController::class, 'vote'])->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
