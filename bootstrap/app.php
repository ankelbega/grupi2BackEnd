<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // API routes are loaded from routes/api.php and prefixed with /api
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Apply to every API route:
        // 1. EnsureFrontendRequestsAreStateful — enables Sanctum cookie auth for SPAs
        //    (harmless here since we use token auth, but required by Sanctum docs)
        // 2. ForceJsonResponse — sets Accept: application/json so all errors
        //    (401, 404, 422, 500…) are returned as JSON, never as HTML
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Laravel automatically returns JSON for requests that have
        // Accept: application/json (which ForceJsonResponse sets above).
        // No additional configuration needed here.
    })->create();
