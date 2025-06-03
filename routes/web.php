<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/routers', [RouterController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('routers');

Route::post('/routers/create', [RouterController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('routers.create');

Route::get('/logs', [LogController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('logs');

    Route::get('/logs/{id}', [LogController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('logs.show');


Route::get('/routers/json', [RouterController::class, 'getRouters'])->name('routers.json');
Route::put('/routers/update/{id}', [RouterController::class, 'update'])->name('routers.update');


Route::get('/routers/{id}/logs', [LogController::class, 'show'])->name('routers.logs');
Route::post('/logs/upload', [LogController::class, 'upload'])->name('logs.upload');



require __DIR__ . '/auth.php';
