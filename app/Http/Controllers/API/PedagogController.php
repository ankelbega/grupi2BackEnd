<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pedagog;
use App\Models\Seksion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedagogController extends Controller
{
    // ─── index ────────────────────────────────────────────────────────────────

    public function index(Request $request): JsonResponse
    {
        $query = Pedagog::with(['perdoruesi', 'departamenti']);

        if ($request->filled('dep_id')) {
            $query->where('DEP_ID', $request->dep_id);
        }

        if ($request->filled('kontrata')) {
            $query->where('PED_LLOJ_KONTRATE', $request->kontrata);
        }

        $pedagoget = $query->get()->map(function ($pedagog) {
            return [
                'PED_ID'             => $pedagog->PED_ID,
                'PED_KOD'            => $pedagog->PED_KOD,
                'PED_SPECIALIZIM'    => $pedagog->PED_SPECIALIZIM,
                'PED_LLOJ_KONTRATE'  => $pedagog->PED_LLOJ_KONTRATE,
                'DEP_ID'             => $pedagog->DEP_ID,
                'PERD_EMER'          => $pedagog->perdoruesi?->PERD_EMER,
                'PERD_MBIEMER'       => $pedagog->perdoruesi?->PERD_MBIEMER,
                'PERD_EMAIL'         => $pedagog->perdoruesi?->PERD_EMAIL,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $pedagoget,
        ], 200);
    }

    // ─── show ─────────────────────────────────────────────────────────────────

    public function show(int $id): JsonResponse
    {
        $pedagog = Pedagog::with([
            'perdoruesi',
            'departamenti',
            'seksionet.lenda',
            'seksionet.semestri',
        ])->find($id);

        if (! $pedagog) {
            return response()->json([
                'success' => false,
                'message' => 'Pedagogu nuk u gjet',
            ], 404);
        }

        $seksionet = $pedagog->seksionet->map(function ($seksion) {
            return [
                'SEK_ID'      => $seksion->SEK_ID,
                'SEK_KOD'     => $seksion->SEK_KOD,
                'SEK_MENYRE'  => $seksion->SEK_MENYRE,
                'SEK_STATUS'  => $seksion->SEK_STATUS,
                'LEN_EM'      => $seksion->lenda?->LEN_EM,
                'SEM_ID'      => $seksion->SEM_ID,
                'SEM_EMRI'    => $seksion->semestri?->SEM_EMRI ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'PED_ID'            => $pedagog->PED_ID,
                'PED_KOD'           => $pedagog->PED_KOD,
                'PED_SPECIALIZIM'   => $pedagog->PED_SPECIALIZIM,
                'PED_LLOJ_KONTRATE' => $pedagog->PED_LLOJ_KONTRATE,
                'DEP_ID'            => $pedagog->DEP_ID,
                'DEP_EM'            => $pedagog->departamenti?->DEP_EM,
                'PERD_EMER'         => $pedagog->perdoruesi?->PERD_EMER,
                'PERD_MBIEMER'      => $pedagog->perdoruesi?->PERD_MBIEMER,
                'PERD_EMAIL'        => $pedagog->perdoruesi?->PERD_EMAIL,
                'seksionet'         => $seksionet,
            ],
        ], 200);
    }

    // ─── lendetESemestrit ─────────────────────────────────────────────────────

    public function lendetESemestrit(Request $request, int $id): JsonResponse
    {
        if (! $request->filled('sem_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Semestri eshte i detyrushem',
            ], 422);
        }

        $pedagog = Pedagog::find($id);

        if (! $pedagog) {
            return response()->json([
                'success' => false,
                'message' => 'Pedagogu nuk u gjet',
            ], 404);
        }

        $seksionet = Seksion::with('lenda')
            ->where('PED_ID', $id)
            ->where('SEM_ID', $request->sem_id)
            ->get()
            ->map(function ($seksion) {
                return [
                    'LEN_ID'     => $seksion->lenda?->LEN_ID,
                    'LEN_EM'     => $seksion->lenda?->LEN_EM,
                    'LEN_KOD'    => $seksion->lenda?->LEN_KOD,
                    'SEK_ID'     => $seksion->SEK_ID,
                    'SEK_KOD'    => $seksion->SEK_KOD,
                    'SEK_MENYRE' => $seksion->SEK_MENYRE,
                    'SEK_STATUS' => $seksion->SEK_STATUS,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $seksionet,
        ], 200);
    }

    // ─── orariPedagogu ────────────────────────────────────────────────────────

    public function orariPedagogu(Request $request, int $id): JsonResponse
    {
        $pedagog = Pedagog::find($id);

        if (! $pedagog) {
            return response()->json([
                'success' => false,
                'message' => 'Pedagogu nuk u gjet',
            ], 404);
        }

        $seksionQuery = Seksion::where('PED_ID', $id);

        if ($request->filled('sem_id')) {
            $seksionQuery->where('SEM_ID', $request->sem_id);
        }

        $seksionIds = $seksionQuery->pluck('SEK_ID');

        $oraret = \App\Models\Orar::with(['seksioni.lenda', 'salla'])
            ->whereIn('SEK_ID', $seksionIds)
            ->orderBy('ORAR_DITA')
            ->orderBy('ORAR_ORA_FILL')
            ->get()
            ->map(function ($orar) {
                return [
                    'ORAR_ID'       => $orar->ORAR_ID,
                    'ORAR_DITA'     => $orar->ORAR_DITA,
                    'ORAR_ORA_FILL' => $orar->ORAR_ORA_FILL,
                    'ORAR_ORA_MBA'  => $orar->ORAR_ORA_MBA,
                    'ORAR_LLOJI'    => $orar->ORAR_LLOJI,
                    'LEN_EM'        => $orar->seksioni?->lenda?->LEN_EM,
                    'SALLE_EM'      => $orar->salla?->SALLE_EM,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $oraret,
        ], 200);
    }

    // ─── store ────────────────────────────────────────────────────────────────

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'DEP_ID'            => 'required|exists:DEPARTAMENT,DEP_ID',
            'PERD_ID'           => 'nullable|integer|exists:PERDORUES,PERD_ID',
            'PED_KOD'           => 'required|unique:PEDAGOG,PED_KOD',
            'PED_SPECIALIZIM'   => 'required|string',
            'PED_DATA_PUNESIMIT' => 'nullable|date',
            'PED_LLOJ_KONTRATE' => 'required|in:kohe-plote,kohe-pjesshme',
            'PERD_EMER'         => 'nullable|string',
            'PERD_MBIEMER'      => 'nullable|string',
        ]);

        $pedagog = Pedagog::create(array_intersect_key($validated, array_flip([
            'DEP_ID', 'PERD_ID', 'PED_KOD', 'PED_SPECIALIZIM', 'PED_DATA_PUNESIMIT', 'PED_LLOJ_KONTRATE',
        ])));

        return response()->json([
            'success' => true,
            'message' => 'Pedagogu u shtua me sukses',
            'data'    => $pedagog,
        ], 201);
    }

    // ─── update ───────────────────────────────────────────────────────────────

    public function update(Request $request, int $id): JsonResponse
    {
        $pedagog = Pedagog::find($id);

        if (! $pedagog) {
            return response()->json([
                'success' => false,
                'message' => 'Pedagogu nuk u gjet',
            ], 404);
        }

        $validated = $request->validate([
            'DEP_ID'            => 'required|exists:DEPARTAMENT,DEP_ID',
            'PERD_ID'           => 'nullable|integer|exists:PERDORUES,PERD_ID',
            'PED_KOD'           => ['required', Rule::unique('PEDAGOG', 'PED_KOD')->ignore($pedagog->PED_ID, 'PED_ID')],
            'PED_SPECIALIZIM'   => 'required|string',
            'PED_DATA_PUNESIMIT' => 'nullable|date',
            'PED_LLOJ_KONTRATE' => 'required|in:kohe-plote,kohe-pjesshme',
            'PERD_EMER'         => 'nullable|string',
            'PERD_MBIEMER'      => 'nullable|string',
        ]);

        $pedagog->update(array_intersect_key($validated, array_flip([
            'DEP_ID', 'PERD_ID', 'PED_KOD', 'PED_SPECIALIZIM', 'PED_DATA_PUNESIMIT', 'PED_LLOJ_KONTRATE',
        ])));

        return response()->json([
            'success' => true,
            'message' => 'Pedagogu u perditesua me sukses',
            'data'    => $pedagog,
        ], 200);
    }

    // ─── destroy ──────────────────────────────────────────────────────────────

    public function destroy(int $id): JsonResponse
    {
        $pedagog = Pedagog::find($id);

        if (! $pedagog) {
            return response()->json([
                'success' => false,
                'message' => 'Pedagogu nuk u gjet',
            ], 404);
        }

        $hasActiveSeksione = Seksion::where('PED_ID', $id)
            ->where('SEK_STATUS', 'aktiv')
            ->exists();

        if ($hasActiveSeksione) {
            return response()->json([
                'success' => false,
                'message' => 'Ky pedagog ka seksione aktive dhe nuk mund te fshihet',
            ], 409);
        }

        $pedagog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pedagogu u fshi me sukses',
        ], 200);
    }
}
