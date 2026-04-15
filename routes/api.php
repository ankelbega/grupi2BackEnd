<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LendeController;
use App\Http\Controllers\API\OrarController;
use App\Http\Controllers\API\PedagogController;
use App\Http\Controllers\API\ProgramStudimiController;
use App\Http\Controllers\API\SeksionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes here are automatically prefixed with /api by Laravel.
| Public routes require no authentication.
| Protected routes require a valid Sanctum Bearer token.
|
*/

// ─── Public Routes ───────────────────────────────────────────────────────────

Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');
Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:login');

// ─── Protected Routes (require Bearer token) ─────────────────────────────────

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // ─── Lende (Subjects) ────────────────────────────────────────────────────
    Route::get('/lende',                  [LendeController::class,          'index']);
    Route::get('/lende/{id}',             [LendeController::class,          'show']);
    Route::post('/lende',                 [LendeController::class,          'store']);
    Route::put('/lende/{id}',             [LendeController::class,          'update']);
    Route::delete('/lende/{id}',          [LendeController::class,          'destroy']);
    Route::get('/lende/{id}/pedagoget',   [LendeController::class,          'pedagoget']);

    // ─── Programe Studimi (Study Programs) ───────────────────────────────────
    Route::get('/programe',               [ProgramStudimiController::class, 'index']);
    Route::get('/programe/{id}',          [ProgramStudimiController::class, 'show']);
    Route::post('/programe',              [ProgramStudimiController::class, 'store']);
    Route::put('/programe/{id}',          [ProgramStudimiController::class, 'update']);
    Route::delete('/programe/{id}',       [ProgramStudimiController::class, 'destroy']);
    Route::get('/programe/{id}/lende',    [ProgramStudimiController::class, 'lendeProgramit']);

    // ─── Pedagoget (Pedagogues) ───────────────────────────────────────────────
    Route::get('/pedagoget',              [PedagogController::class, 'index']);
    Route::get('/pedagoget/{id}',         [PedagogController::class, 'show']);
    Route::post('/pedagoget',             [PedagogController::class, 'store']);
    Route::put('/pedagoget/{id}',         [PedagogController::class, 'update']);
    Route::delete('/pedagoget/{id}',      [PedagogController::class, 'destroy']);
    Route::get('/pedagoget/{id}/lende',   [PedagogController::class, 'lendetESemestrit']);
    Route::get('/pedagoget/{id}/orari',   [PedagogController::class, 'orariPedagogu']);

    // ─── Other Resources ─────────────────────────────────────────────────────
    Route::get('/seksione',  [SeksionController::class, 'index']);

    // ─── Orare (Schedule) ────────────────────────────────────────────────────
    Route::post('/orare/kontrollo',  [OrarController::class, 'kontrolloKonfliktet']);
    Route::get('/orare',             [OrarController::class, 'index']);
    Route::get('/orare/{id}',        [OrarController::class, 'show']);
    Route::post('/orare',            [OrarController::class, 'store']);
    Route::put('/orare/{id}',        [OrarController::class, 'update']);
    Route::delete('/orare/{id}',     [OrarController::class, 'destroy']);
});
