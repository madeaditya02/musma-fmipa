<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Middleware\IsAdmin;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/vote/{id}', [VoteController::class, 'index'])->middleware('auth');
Route::post('/vote/{id}', [VoteController::class, 'vote'])->middleware('auth');

Route::resource('events', EventController::class)->except(['show'])->middleware(['auth', 'verified', IsAdmin::class]);

Route::resource('candidates', KandidatController::class)
        ->only(['index', 'store', 'update', 'destroy'])->middleware(['auth', 'verified', IsAdmin::class]);

Route::resource('users', MahasiswaController::class)
        ->only(['index', 'store', 'update', 'destroy'])->middleware(['auth', 'verified', IsAdmin::class]);

Route::post('users/sync-data/{year}', [MahasiswaController::class, 'syncMahasiswa'])
        ->name('users.sync-data')->middleware(['auth', 'verified', IsAdmin::class]);

Route::get('result', [EventController::class, 'hasil'])->middleware(['auth', IsAdmin::class]);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
