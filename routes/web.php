<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtificialIntelligenceController;
use App\Http\Controllers\KeysController;
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

Route::get('/tables', [RouterController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('tables');

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

Route::post('/ia/create', [ArtificialIntelligenceController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('ia.create');

Route::post('/analysis/create', [AnalysisController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('analysis.create');

Route::post('/keys/create', [KeysController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('keys.create');

Route::get('/ia/json', [ArtificialIntelligenceController::class, 'getIA'])->name('ia.json');

Route::get('/keys/json', [KeysController::class, 'getKeys'])->name('keys.json');

Route::get('/routers/json', [RouterController::class, 'getRouters'])->name('routers.json');
Route::put('/routers/update/{id}', [RouterController::class, 'update'])->name('routers.update');


Route::post('/logs/get', [LogController::class, 'getLogs'])->name('logs.get');
Route::post('/logs/analizar', [LogController::class, 'analizarLogsConIA'])->name('logs.analizar');
Route::post('/logs/upload', [LogController::class, 'uploadLog'])->name('logs.upload');


Route::get('/tipo-analisis', [AnalysisController::class, 'getAnalysisTypes']);






require __DIR__ . '/auth.php';