<?php

namespace App\Http\Controllers\API;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Models\ProgramStudimi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramStudimiController extends Controller
{
    /**
     * GET /api/programe
     * Listo te gjitha programet e studimit me filtra opsionale.
     */
    public function index(Request $request): JsonResponse
    {
        $query = ProgramStudimi::with('departamenti');

        if ($request->filled('dep_id')) {
            $query->where('DEP_ID', $request->dep_id);
        }

        if ($request->filled('niveli')) {
            $query->where('PROG_NIV', $request->niveli);
        }

        $programet = $query->get()->map(function ($prog) {
            return [
                'PROG_ID'  => $prog->PROG_ID,
                'PROG_EM'  => $prog->PROG_EM,
                'PROG_NIV' => $prog->PROG_NIV,
                'PROG_KRD' => $prog->PROG_KRD,
                'DEP_ID'   => $prog->DEP_ID,
                'DEP_EM'   => $prog->departamenti?->DEP_EM,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $programet,
        ], 200);
    }

    /**
     * GET /api/programe/{id}
     * Shfaq detajet e nje programi studimi.
     */
    public function show(int $id): JsonResponse
    {
        $program = ProgramStudimi::with([
            'departamenti',
            'versionetKurrikules.lendeProgramit.lenda',
        ])->find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Programi i studimit nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        $versioniAktiv = $program->versionetKurrikules
            ->firstWhere('KURR_VER_AKTIV', 1);

        $lendaAktive = $versioniAktiv
            ? $versioniAktiv->lendeProgramit->map(function ($lp) {
                return [
                    'LEN_ID'        => $lp->lenda?->LEN_ID,
                    'LEN_EM'        => $lp->lenda?->LEN_EM,
                    'LEN_KOD'       => $lp->lenda?->LEN_KOD,
                    'LP_KREDIT'     => $lp->LP_KREDIT,
                    'LP_VITI'       => $lp->LP_VITI,
                    'LP_SEMESTRI'   => $lp->LP_SEMESTRI,
                    'LP_ZGJEDHORE'  => $lp->LP_ZGJEDHORE,
                ];
            })
            : [];

        $data = [
            'PROG_ID'      => $program->PROG_ID,
            'PROG_EM'      => $program->PROG_EM,
            'PROG_NIV'     => $program->PROG_NIV,
            'PROG_KRD'     => $program->PROG_KRD,
            'DEP_ID'       => $program->DEP_ID,
            'departamenti' => [
                'DEP_ID' => $program->departamenti?->DEP_ID,
                'DEP_EM' => $program->departamenti?->DEP_EM,
            ],
            'versionet_kurrikules' => $program->versionetKurrikules->map(function ($ver) {
                return [
                    'KURR_VER_ID'    => $ver->KURR_VER_ID,
                    'KURR_VER_NR'    => $ver->KURR_VER_NR,
                    'KURR_VER_AKTIV' => $ver->KURR_VER_AKTIV,
                    'KURR_VER_DATA'  => $ver->KURR_VER_DATA,
                ];
            }),
            'versioni_aktiv_lende' => $lendaAktive,
        ];

        return response()->json([
            'success' => true,
            'data'    => $data,
        ], 200);
    }

    /**
     * POST /api/programe
     * Krijo nje program studimi te ri.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'PROG_EM'  => 'required|string|max:255',
            'PROG_NIV' => 'required|string|in:' . implode(',', AppConstants::PROG_NIVELET),
            'DEP_ID'   => 'required|integer|exists:DEPARTAMENT,DEP_ID',
            'PROG_KRD' => 'required|integer|min:1',
        ], [
            'PROG_EM.required'  => 'Emri i programit eshte i detyrueshëm.',
            'PROG_EM.string'    => 'Emri i programit duhet te jete tekst.',
            'PROG_NIV.required' => 'Niveli i programit eshte i detyrueshëm.',
            'PROG_NIV.in'       => 'Niveli duhet te jete: ' . implode(', ', AppConstants::PROG_NIVELET) . '.',
            'DEP_ID.required'   => 'Departamenti eshte i detyrueshëm.',
            'DEP_ID.exists'     => 'Departamenti i zgjedhur nuk ekziston.',
            'PROG_KRD.required' => 'Numri i krediteve eshte i detyrueshëm.',
            'PROG_KRD.integer'  => 'Numri i krediteve duhet te jete nje numer i plote.',
            'PROG_KRD.min'      => 'Numri i krediteve duhet te jete me i madh se zero.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Të dhënat e dhëna janë të pavlefshme.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $program = ProgramStudimi::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Programi i studimit u krijua me sukses.',
            'data'    => $program,
        ], 201);
    }

    /**
     * PUT /api/programe/{id}
     * Perditeso nje program studimi ekzistues.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $program = ProgramStudimi::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Programi i studimit nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'PROG_EM'  => 'required|string|max:255',
            'PROG_NIV' => 'required|string|in:' . implode(',', AppConstants::PROG_NIVELET),
            'DEP_ID'   => 'required|integer|exists:DEPARTAMENT,DEP_ID',
            'PROG_KRD' => 'required|integer|min:1',
        ], [
            'PROG_EM.required'  => 'Emri i programit eshte i detyrueshëm.',
            'PROG_EM.string'    => 'Emri i programit duhet te jete tekst.',
            'PROG_NIV.required' => 'Niveli i programit eshte i detyrueshëm.',
            'PROG_NIV.in'       => 'Niveli duhet te jete: ' . implode(', ', AppConstants::PROG_NIVELET) . '.',
            'DEP_ID.required'   => 'Departamenti eshte i detyrueshëm.',
            'DEP_ID.exists'     => 'Departamenti i zgjedhur nuk ekziston.',
            'PROG_KRD.required' => 'Numri i krediteve eshte i detyrueshëm.',
            'PROG_KRD.integer'  => 'Numri i krediteve duhet te jete nje numer i plote.',
            'PROG_KRD.min'      => 'Numri i krediteve duhet te jete me i madh se zero.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Të dhënat e dhëna janë të pavlefshme.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $program->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Programi i studimit u perditesua me sukses.',
            'data'    => $program->fresh(),
        ], 200);
    }

    /**
     * DELETE /api/programe/{id}
     * Fshi nje program studimi (vetem nese nuk ka versione kurrikule).
     */
    public function destroy(int $id): JsonResponse
    {
        $program = ProgramStudimi::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Programi i studimit nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        if ($program->versionetKurrikules()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ky program ka versione kurrikule dhe nuk mund te fshihet.',
                'data'    => null,
            ], 409);
        }

        $program->delete();

        return response()->json([
            'success' => true,
            'message' => 'Programi i studimit u fshi me sukses.',
            'data'    => null,
        ], 200);
    }

    /**
     * GET /api/programe/{id}/lende
     * Listo lendet e versionit aktiv te kurrikules, te grupuara sipas vitit dhe semestrit.
     */
    public function lendeProgramit(int $id): JsonResponse
    {
        $program = ProgramStudimi::with([
            'versionetKurrikules' => function ($q) {
                $q->where('KURR_VER_AKTIV', 1);
            },
            'versionetKurrikules.lendeProgramit.lenda',
        ])->find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Programi i studimit nuk u gjet.',
                'data'    => null,
            ], 404);
        }

        $versioniAktiv = $program->versionetKurrikules->first();

        if (!$versioniAktiv) {
            return response()->json([
                'success' => false,
                'message' => 'Ky program nuk ka version aktiv te kurrikules.',
                'data'    => null,
            ], 404);
        }

        $grouped = $versioniAktiv->lendeProgramit
            ->groupBy('LP_VITI')
            ->map(function ($perViti, $viti) {
                return [
                    'viti'      => $viti,
                    'semestrat' => $perViti->groupBy('LP_SEMESTRI')
                        ->map(function ($perSemestri, $semestri) {
                            return [
                                'semestri' => $semestri,
                                'lende'    => $perSemestri->map(function ($lp) {
                                    return [
                                        'LEN_ID'       => $lp->lenda?->LEN_ID,
                                        'LEN_EM'       => $lp->lenda?->LEN_EM,
                                        'LEN_KOD'      => $lp->lenda?->LEN_KOD,
                                        'LP_KREDIT'    => $lp->LP_KREDIT,
                                        'LP_VITI'      => $lp->LP_VITI,
                                        'LP_SEMESTRI'  => $lp->LP_SEMESTRI,
                                        'LP_ZGJEDHORE' => $lp->LP_ZGJEDHORE,
                                    ];
                                })->values(),
                            ];
                        })->values(),
                ];
            })->values();

        return response()->json([
            'success'         => true,
            'KURR_VER_ID'     => $versioniAktiv->KURR_VER_ID,
            'KURR_VER_NR'     => $versioniAktiv->KURR_VER_NR,
            'data'            => $grouped,
        ], 200);
    }
}
