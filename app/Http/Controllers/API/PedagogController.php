<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pedagog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PedagogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $pedagoget = Pedagog::with('perdoruesi', 'departamenti')->get();

        return response()->json([
            'success' => true,
            'data'    => $pedagoget,
        ], 200);
    }
}
