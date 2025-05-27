<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MikrotikController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/routers', [MikrotikController::class, 'conectar'])
    ->middleware(['auth', 'verified'])
    ->name('routers');

Route::get('/logs', [MikrotikController::class, 'mostrarLogs'])
    ->middleware(['auth', 'verified'])
    ->name('logs');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/conectar-mikrotik', [MikrotikController::class, 'conectar']);


require __DIR__.'/auth.php';
