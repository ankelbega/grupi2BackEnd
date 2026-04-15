<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seksion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeksionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $seksionet = Seksion::with('lenda', 'pedagogi', 'semestri')->get();

        return response()->json([
            'success' => true,
            'data'    => $seksionet,
        ], 200);
    }
}
