<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force all API responses to be JSON.
 *
 * By setting the Accept header to application/json on every incoming API
 * request, Laravel's exception handler will always return JSON error
 * responses instead of HTML pages (404, 401, 422, 500, etc.).
 */
class ForceJsonResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
