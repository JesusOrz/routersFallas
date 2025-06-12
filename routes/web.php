<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AnalysisController;
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

Route::get('/cargar-logs', [LogController::class, 'cargarLogsView'])
    ->middleware(['auth', 'verified'])
    ->name('cargar-logs');

Route::get('/logs/{id}', [LogController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('logs.show');

Route::post('/analysis/create', [AnalysisController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('analysis.create');


Route::get('/routers/json', [RouterController::class, 'getRouters'])->name('routers.json');
Route::put('/routers/update/{id}', [RouterController::class, 'update'])->name('routers.update');


Route::post('/logs/get', [LogController::class, 'getLogs'])->name('logs.get');
Route::post('/logs/analizar', [LogController::class, 'analizarLogsConIA'])->name('logs.analizar');
Route::post('/logs/upload', [LogController::class, 'uploadLog'])->name('logs.upload');


Route::get('/tipo-analisis', [AnalysisController::class, 'getAnalysisTypes']);






require __DIR__ . '/auth.php';