<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Jo i autentifikuar'], 401);
        }

        if (!in_array($user->PERD_TIPI, $roles)) {
            return response()->json([
                'success' => false,
                'message' => 'Nuk keni akses per kete veprim'
            ], 403);
        }

        return $next($request);
    }
}
