<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArtificialIntelligenceController;
use App\Http\Controllers\KeysController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/tables/routers', [RouterController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('routersTable');

Route::get('/tables/keys', [KeysController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('keysTable');


Route::get('/tables/analysis', [AnalysisController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('analysisTable');

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

Route::post('/chatbot', [ChatbotController::class, 'handle']);
Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->middleware('auth');
Route::post('/sugerencia/enviar', [ChatbotController::class, 'enviarSugerencia'])->name('sugerencias.enviar')->middleware('auth');







require __DIR__ . '/auth.php';