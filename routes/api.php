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

    // ─── Schedule Management ──────────────────────────────────────────────────
    Route::get('/lende',     [LendeController::class,          'index']);
    Route::get('/pedagoget', [PedagogController::class,        'index']);
    Route::get('/programe',  [ProgramStudimiController::class, 'index']);
    Route::get('/seksione',  [SeksionController::class,        'index']);
    Route::get('/orare',     [OrarController::class,           'index']);
});
