<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Orar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrarController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $oraret = Orar::with('seksioni')->get();

        return response()->json([
            'success' => true,
            'data'    => $oraret,
        ], 200);
    }
}
