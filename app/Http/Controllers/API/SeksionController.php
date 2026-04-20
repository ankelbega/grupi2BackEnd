<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seksion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function show($id): JsonResponse
    {
        $seksion = Seksion::with('lenda', 'pedagogi', 'semestri')->find($id);

        if (! $seksion) {
            return response()->json(['message' => 'Seksioni nuk u gjet.'], 404);
        }

        return response()->json(['success' => true, 'data' => $seksion], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(
            [
                'SEK_KOD'       => 'required|string|max:20|unique:SEKSION,SEK_KOD',
                'SEK_KAPACITET' => 'required|integer|min:1|max:200',
                'SEK_MENYRE'    => 'nullable|string|max:50',
                'SEK_STATUS'    => 'nullable|string|max:20',
                'LEN_ID'        => 'required|exists:LENDE,LEN_ID',
                'PED_ID'        => 'nullable|exists:PEDAGOG,PED_ID',
                'SEM_ID'        => ['required', Rule::exists('SEMESTËR', 'SEM_ID')],
                'SALLE_ID'      => 'nullable|exists:SALLE,SALLE_ID',
            ],
            [
                'SEK_KOD.required'       => 'Kodi i seksionit është i detyrueshëm.',
                'SEK_KOD.max'            => 'Kodi i seksionit nuk mund të jetë më i gjatë se 20 karaktere.',
                'SEK_KOD.unique'         => 'Ky kod seksioni ekziston tashmë.',
                'SEK_KAPACITET.required' => 'Kapaciteti është i detyrueshëm.',
                'SEK_KAPACITET.integer'  => 'Kapaciteti duhet të jetë numër i plotë.',
                'SEK_KAPACITET.min'      => 'Kapaciteti minimal është 1.',
                'SEK_KAPACITET.max'      => 'Kapaciteti maksimal është 200.',
                'LEN_ID.required'        => 'Lënda është e detyrueshme.',
                'LEN_ID.exists'          => 'Lënda e zgjedhur nuk ekziston.',
                'PED_ID.exists'          => 'Pedagogu i zgjedhur nuk ekziston.',
                'SEM_ID.required'        => 'Semestri është i detyrueshëm.',
                'SEM_ID.exists'          => 'Semestri i zgjedhur nuk ekziston.',
                'SALLE_ID.exists'        => 'Salla e zgjedhur nuk ekziston.',
            ]
        );

        $seksion = Seksion::create($validated);

        return response()->json(['success' => true, 'data' => $seksion], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $seksion = Seksion::find($id);

        if (! $seksion) {
            return response()->json(['message' => 'Seksioni nuk u gjet.'], 404);
        }

        $validated = $request->validate(
            [
                'SEK_KOD'       => ['required', 'string', 'max:20', Rule::unique('SEKSION', 'SEK_KOD')->ignore($id, 'SEK_ID')],
                'SEK_KAPACITET' => 'required|integer|min:1|max:200',
                'SEK_MENYRE'    => 'nullable|string|max:50',
                'SEK_STATUS'    => 'nullable|string|max:20',
                'LEN_ID'        => 'required|exists:LENDE,LEN_ID',
                'PED_ID'        => 'nullable|exists:PEDAGOG,PED_ID',
                'SEM_ID'        => ['required', Rule::exists('SEMESTËR', 'SEM_ID')],
                'SALLE_ID'      => 'nullable|exists:SALLE,SALLE_ID',
            ],
            [
                'SEK_KOD.required'       => 'Kodi i seksionit është i detyrueshëm.',
                'SEK_KOD.max'            => 'Kodi i seksionit nuk mund të jetë më i gjatë se 20 karaktere.',
                'SEK_KOD.unique'         => 'Ky kod seksioni ekziston tashmë.',
                'SEK_KAPACITET.required' => 'Kapaciteti është i detyrueshëm.',
                'SEK_KAPACITET.integer'  => 'Kapaciteti duhet të jetë numër i plotë.',
                'SEK_KAPACITET.min'      => 'Kapaciteti minimal është 1.',
                'SEK_KAPACITET.max'      => 'Kapaciteti maksimal është 200.',
                'LEN_ID.required'        => 'Lënda është e detyrueshme.',
                'LEN_ID.exists'          => 'Lënda e zgjedhur nuk ekziston.',
                'PED_ID.exists'          => 'Pedagogu i zgjedhur nuk ekziston.',
                'SEM_ID.required'        => 'Semestri është i detyrueshëm.',
                'SEM_ID.exists'          => 'Semestri i zgjedhur nuk ekziston.',
                'SALLE_ID.exists'        => 'Salla e zgjedhur nuk ekziston.',
            ]
        );

        $seksion->update($validated);

        return response()->json(['success' => true, 'data' => $seksion->fresh()], 200);
    }

    public function destroy($id): JsonResponse
    {
        $seksion = Seksion::find($id);

        if (! $seksion) {
            return response()->json(['message' => 'Seksioni nuk u gjet.'], 404);
        }

        if (DB::table('ORAR')->where('SEK_ID', $id)->exists()) {
            return response()->json(
                ['message' => 'Seksioni nuk mund të fshihet pasi ka orare të lidhura.'],
                409
            );
        }

        $seksion->delete();

        return response()->json(['message' => 'Seksioni u fshi me sukses.'], 200);
    }
}
