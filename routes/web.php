<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MikrotikController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/routers', [MikrotikController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('routers');

Route::post('/routers/create', [MikrotikController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('routers.create');

Route::get('/logs', [LogController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('logs');


Route::get('/routers/json', [MikrotikController::class, 'getRouters'])->name('routers.json');


require __DIR__ . '/auth.php';
