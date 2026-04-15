<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lende;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LendeController extends Controller
{
    /**
     * GET /api/lende
     * Listo te gjitha lendet me filtra opsionale.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Lende::with('departamenti');

        if ($request->filled('dep_id')) {
            $query->where('DEP_ID', $request->dep_id);
        }

        if ($request->filled('viti') || $request->filled('semestri') || $request->filled('kurr_ver_id')) {
            $query->whereHas('lendeProgramit', function ($q) use ($request) {
                if ($request->filled('viti')) {
                    $q->where('LP_VITI', $request->viti);
                }
                if ($request->filled('semestri')) {
                    $q->where('LP_SEMESTRI', $request->semestri);
                }
                if ($request->filled('kurr_ver_id')) {
                    $q->where('KURR_VER_ID', $request->kurr_ver_id);
                }
            });
        }

        $lendet = $query->get()->map(function ($lende) {
            return [
                'LEN_ID'   => $lende->LEN_ID,
                'LEN_EM'   => $lende->LEN_EM,
                'LEN_KOD'  => $lende->LEN_KOD,
                'DEP_ID'   => $lende->DEP_ID,
                'DEP_EM'   => $lende->departamenti?->DEP_EM,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $lendet,
        ], 200);
    }

    /**
     * GET /api/lende/{id}
     * Shfaq detajet e nje lende te caktuar.
     */
    public function show(int $id): JsonResponse
    {
        $lende = Lende::with([
            'departamenti',
            'lendeProgramit.versioniKurrikules.programiStudimit',
            'seksionet.pedagogi.perdoruesi',
        ])->find($id);

        if (!$lende) {
            return response()->json([
                'success' => false,
                'message' => 'Lenda nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        $data = [
            'LEN_ID'         => $lende->LEN_ID,
            'LEN_EM'         => $lende->LEN_EM,
            'LEN_KOD'        => $lende->LEN_KOD,
            'DEP_ID'         => $lende->DEP_ID,
            'departamenti'   => [
                'DEP_ID' => $lende->departamenti?->DEP_ID,
                'DEP_EM' => $lende->departamenti?->DEP_EM,
            ],
            'lende_programi' => $lende->lendeProgramit->map(function ($lp) {
                return [
                    'LP_ID'         => $lp->LP_ID,
                    'LP_VITI'       => $lp->LP_VITI,
                    'LP_SEMESTRI'   => $lp->LP_SEMESTRI,
                    'LP_KREDIT'     => $lp->LP_KREDIT,
                    'LP_ZGJEDHORE'  => $lp->LP_ZGJEDHORE,
                    'KURR_VER_ID'   => $lp->KURR_VER_ID,
                    'KURR_VER_NR'   => $lp->versioniKurrikules?->KURR_VER_NR,
                    'KURR_VER_AKTIV'=> $lp->versioniKurrikules?->KURR_VER_AKTIV,
                    'PROG_ID'       => $lp->versioniKurrikules?->PROG_ID,
                    'PROG_EM'       => $lp->versioniKurrikules?->programiStudimit?->PROG_EM,
                ];
            }),
            'seksionet'      => $lende->seksionet->map(function ($sek) {
                return [
                    'SEK_ID'        => $sek->SEK_ID,
                    'SEK_KOD'       => $sek->SEK_KOD,
                    'SEK_MENYRE'    => $sek->SEK_MENYRE,
                    'SEK_STATUS'    => $sek->SEK_STATUS,
                    'SEK_KAPACITET' => $sek->SEK_KAPACITET,
                    'PED_ID'        => $sek->PED_ID,
                    'PERD_EMER'     => $sek->pedagogi?->perdoruesi?->PERD_EMER,
                    'PERD_MBIEMER'  => $sek->pedagogi?->perdoruesi?->PERD_MBIEMER,
                ];
            }),
        ];

        return response()->json([
            'success' => true,
            'data'    => $data,
        ], 200);
    }

    /**
     * POST /api/lende
     * Krijo nje lende te re.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'LEN_EM'  => 'required|string|max:255',
            'LEN_KOD' => 'required|string|max:50|unique:LENDE,LEN_KOD',
            'DEP_ID'  => 'required|integer|exists:DEPARTAMENT,DEP_ID',
        ], [
            'LEN_EM.required'  => 'Emri i lendes eshte i detyrueshëm.',
            'LEN_EM.string'    => 'Emri i lendes duhet te jete tekst.',
            'LEN_KOD.required' => 'Kodi i lendes eshte i detyrueshëm.',
            'LEN_KOD.unique'   => 'Ky kod lende ekziston tashme.',
            'DEP_ID.required'  => 'Departamenti eshte i detyrueshëm.',
            'DEP_ID.exists'    => 'Departamenti i zgjedhur nuk ekziston.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Të dhënat e dhëna janë të pavlefshme.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $lende = Lende::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Lenda u krijua me sukses.',
            'data'    => $lende,
        ], 201);
    }

    /**
     * PUT /api/lende/{id}
     * Perditeso nje lende ekzistuese.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $lende = Lende::find($id);

        if (!$lende) {
            return response()->json([
                'success' => false,
                'message' => 'Lenda nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'LEN_EM'  => 'required|string|max:255',
            'LEN_KOD' => 'required|string|max:50|unique:LENDE,LEN_KOD,' . $id . ',LEN_ID',
            'DEP_ID'  => 'required|integer|exists:DEPARTAMENT,DEP_ID',
        ], [
            'LEN_EM.required'  => 'Emri i lendes eshte i detyrueshëm.',
            'LEN_EM.string'    => 'Emri i lendes duhet te jete tekst.',
            'LEN_KOD.required' => 'Kodi i lendes eshte i detyrueshëm.',
            'LEN_KOD.unique'   => 'Ky kod lende ekziston tashme.',
            'DEP_ID.required'  => 'Departamenti eshte i detyrueshëm.',
            'DEP_ID.exists'    => 'Departamenti i zgjedhur nuk ekziston.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Të dhënat e dhëna janë të pavlefshme.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $lende->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Lenda u perditesua me sukses.',
            'data'    => $lende->fresh(),
        ], 200);
    }

    /**
     * DELETE /api/lende/{id}
     * Fshi nje lende (vetem nese nuk ka seksione aktive).
     */
    public function destroy(int $id): JsonResponse
    {
        $lende = Lende::find($id);

        if (!$lende) {
            return response()->json([
                'success' => false,
                'message' => 'Lenda nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        $hasSeksione = $lende->seksionet()->exists();

        if ($hasSeksione) {
            return response()->json([
                'success' => false,
                'message' => 'Kjo lende ka seksione aktive dhe nuk mund te fshihet.',
                'data'    => null,
            ], 409);
        }

        $lende->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lenda u fshi me sukses.',
            'data'    => null,
        ], 200);
    }

    /**
     * GET /api/lende/{id}/pedagoget
     * Listo te gjithe pedagoget qe kane dhene kete lende.
     */
    public function pedagoget(int $id): JsonResponse
    {
        $lende = Lende::find($id);

        if (!$lende) {
            return response()->json([
                'success' => false,
                'message' => 'Lenda nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        $pedagoget = $lende->seksionet()
            ->with('pedagogi.perdoruesi')
            ->get()
            ->pluck('pedagogi')
            ->filter()
            ->unique('PED_ID')
            ->values()
            ->map(function ($ped) {
                return [
                    'PED_ID'          => $ped->PED_ID,
                    'PED_KOD'         => $ped->PED_KOD,
                    'PED_SPECIALIZIM' => $ped->PED_SPECIALIZIM,
                    'PERD_EMER'       => $ped->perdoruesi?->PERD_EMER,
                    'PERD_MBIEMER'    => $ped->perdoruesi?->PERD_MBIEMER,
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $pedagoget,
        ], 200);
    }
}
