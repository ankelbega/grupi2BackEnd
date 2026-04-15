<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auditor;
use App\Models\Orar;
use App\Models\Salle;
use App\Models\Seksion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrarController extends Controller
{
    private array $emratDiteve = [
        1 => 'E Hene',
        2 => 'E Marte',
        3 => 'E Merkure',
        4 => 'E Enjte',
        5 => 'E Premte',
    ];

    // ─── index() ─────────────────────────────────────────────────────────────

    public function index(Request $request): JsonResponse
    {
        $query = Orar::with([
            'salla',
            'seksioni.lenda',
            'seksioni.pedagogi.perdoruesi',
            'seksioni.semestri',
        ]);

        if ($request->filled('ped_id')) {
            $query->whereHas('seksioni', fn ($q) => $q->where('PED_ID', $request->ped_id));
        }

        if ($request->filled('salle_id')) {
            $query->where('SALLE_ID', $request->salle_id);
        }

        if ($request->filled('sem_id')) {
            $query->whereHas('seksioni', fn ($q) => $q->where('SEM_ID', $request->sem_id));
        }

        if ($request->filled('dita')) {
            $query->where('ORAR_DITA', $request->dita);
        }

        if ($request->filled('kurr_ver_id')) {
            $query->whereHas('seksioni', function ($q) use ($request) {
                $q->whereHas('lenda', function ($q2) use ($request) {
                    $q2->whereHas('lendeProgramit', fn ($q3) =>
                        $q3->where('KURR_VER_ID', $request->kurr_ver_id)
                    );
                });
            });
        }

        $oraret = $query->get()->map(function ($orar) {
            $seksioni = $orar->seksioni;
            $pedagog  = $seksioni?->pedagogi?->perdoruesi;

            return [
                'ORAR_ID'       => $orar->ORAR_ID,
                'ORAR_DITA'     => $orar->ORAR_DITA,
                'ORAR_DITA_EM'  => $this->emratDiteve[$orar->ORAR_DITA] ?? null,
                'ORAR_ORA_FILL' => $orar->ORAR_ORA_FILL,
                'ORAR_ORA_MBA'  => $orar->ORAR_ORA_MBA,
                'ORAR_LLOJI'    => $orar->ORAR_LLOJI,
                'SALLE_ID'      => $orar->SALLE_ID,
                'salla_em'      => $orar->salla?->SALLE_EM,
                'seksioni'      => $seksioni ? [
                    'SEK_ID'     => $seksioni->SEK_ID,
                    'SEK_KOD'    => $seksioni->SEK_KOD,
                    'SEK_MENYRE' => $seksioni->SEK_MENYRE,
                    'SEM_ID'     => $seksioni->SEM_ID,
                    'PED_ID'     => $seksioni->PED_ID,
                ] : null,
                'lenda_em'      => $seksioni?->lenda?->LEN_EM,
                'pedagog_em'    => $pedagog
                    ? trim($pedagog->PERD_EMER . ' ' . $pedagog->PERD_MBIEMER)
                    : null,
            ];
        });

        return response()->json(['success' => true, 'data' => $oraret], 200);
    }

    // ─── show() ───────────────────────────────────────────────────────────────

    public function show(int $id): JsonResponse
    {
        $orar = Orar::with([
            'salla',
            'seksioni.lenda',
            'seksioni.pedagogi.perdoruesi',
            'seksioni.semestri',
        ])->find($id);

        if (! $orar) {
            return response()->json(['success' => false, 'mesazh' => 'Orari nuk u gjet'], 404);
        }

        $seksioni = $orar->seksioni;
        $pedagog  = $seksioni?->pedagogi?->perdoruesi;

        return response()->json([
            'success' => true,
            'data'    => [
                'ORAR_ID'       => $orar->ORAR_ID,
                'ORAR_DITA'     => $orar->ORAR_DITA,
                'ORAR_DITA_EM'  => $this->emratDiteve[$orar->ORAR_DITA] ?? null,
                'ORAR_ORA_FILL' => $orar->ORAR_ORA_FILL,
                'ORAR_ORA_MBA'  => $orar->ORAR_ORA_MBA,
                'ORAR_LLOJI'    => $orar->ORAR_LLOJI,
                'SALLE_ID'      => $orar->SALLE_ID,
                'salla'         => $orar->salla,
                'seksioni'      => $seksioni,
                'lenda'         => $seksioni?->lenda,
                'semestri'      => $seksioni?->semestri,
                'pedagog_em'    => $pedagog
                    ? trim($pedagog->PERD_EMER . ' ' . $pedagog->PERD_MBIEMER)
                    : null,
            ],
        ], 200);
    }

    // ─── store() ──────────────────────────────────────────────────────────────

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'SEK_ID'        => 'required|integer|exists:SEKSION,SEK_ID',
            'SALLE_ID'      => 'required|integer|exists:SALLE,SALLE_ID',
            'ORAR_DITA'     => 'required|integer|in:1,2,3,4,5',
            'ORAR_ORA_FILL' => 'required|date_format:H:i',
            'ORAR_ORA_MBA'  => 'required|date_format:H:i|after:ORAR_ORA_FILL',
            'ORAR_LLOJI'    => 'required|in:ligjerata,seminar,laborator',
        ]);

        if (! Auditor::find($data['SALLE_ID'])) {
            return response()->json([
                'success' => false,
                'mesazh'  => 'Kjo salle nuk eshte auditor dhe nuk mund te perdoret per mesim',
            ], 422);
        }

        $konflikte = $this->kontrolloKonfliktetInterne($data, null);

        if (! empty($konflikte)) {
            return response()->json([
                'success'   => false,
                'konflikte' => $konflikte,
                'mesazh'    => $konflikte[0],
            ], 409);
        }

        $orar = Orar::create($data);

        return response()->json([
            'success' => true,
            'mesazh'  => 'Orari u shtua me sukses',
            'data'    => $orar,
        ], 201);
    }

    // ─── update() ─────────────────────────────────────────────────────────────

    public function update(Request $request, int $id): JsonResponse
    {
        $orar = Orar::find($id);

        if (! $orar) {
            return response()->json(['success' => false, 'mesazh' => 'Orari nuk u gjet'], 404);
        }

        $data = $request->validate([
            'SEK_ID'        => 'required|integer|exists:SEKSION,SEK_ID',
            'SALLE_ID'      => 'required|integer|exists:SALLE,SALLE_ID',
            'ORAR_DITA'     => 'required|integer|in:1,2,3,4,5',
            'ORAR_ORA_FILL' => 'required|date_format:H:i',
            'ORAR_ORA_MBA'  => 'required|date_format:H:i|after:ORAR_ORA_FILL',
            'ORAR_LLOJI'    => 'required|in:ligjerata,seminar,laborator',
        ]);

        if (! Auditor::find($data['SALLE_ID'])) {
            return response()->json([
                'success' => false,
                'mesazh'  => 'Kjo salle nuk eshte auditor dhe nuk mund te perdoret per mesim',
            ], 422);
        }

        $konflikte = $this->kontrolloKonfliktetInterne($data, $id);

        if (! empty($konflikte)) {
            return response()->json([
                'success'   => false,
                'konflikte' => $konflikte,
                'mesazh'    => $konflikte[0],
            ], 409);
        }

        $orar->update($data);

        return response()->json([
            'success' => true,
            'mesazh'  => 'Orari u perditesua me sukses',
            'data'    => $orar->fresh(),
        ], 200);
    }

    // ─── destroy() ────────────────────────────────────────────────────────────

    public function destroy(int $id): JsonResponse
    {
        $orar = Orar::find($id);

        if (! $orar) {
            return response()->json(['success' => false, 'mesazh' => 'Orari nuk u gjet'], 404);
        }

        $orar->delete();

        return response()->json(['success' => true, 'mesazh' => 'Orari u fshi me sukses'], 200);
    }

    // ─── kontrolloKonfliktet() ────────────────────────────────────────────────

    public function kontrolloKonfliktet(Request $request): JsonResponse
    {
        $data = $request->validate([
            'SEK_ID'        => 'required|integer|exists:SEKSION,SEK_ID',
            'SALLE_ID'      => 'required|integer|exists:SALLE,SALLE_ID',
            'ORAR_DITA'     => 'required|integer|in:1,2,3,4,5',
            'ORAR_ORA_FILL' => 'required|date_format:H:i',
            'ORAR_ORA_MBA'  => 'required|date_format:H:i|after:ORAR_ORA_FILL',
            'ORAR_LLOJI'    => 'required|in:ligjerata,seminar,laborator',
        ]);

        $konflikte = $this->kontrolloKonfliktetInterne($data, null);

        if (! empty($konflikte)) {
            return response()->json([
                'success'   => false,
                'konflikte' => $konflikte,
            ], 409);
        }

        return response()->json([
            'success'   => true,
            'konflikte' => [],
            'mesazh'    => 'Nuk ka perplasje',
        ], 200);
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function kontrolloKonfliktetInterne(array $data, ?int $excludeOrarId): array
    {
        $konflikte = [];
        $salleId   = $data['SALLE_ID'];
        $sekId     = $data['SEK_ID'];
        $dita      = $data['ORAR_DITA'];
        $oraFill   = $data['ORAR_ORA_FILL'];
        $oraMba    = $data['ORAR_ORA_MBA'];
        $emriDites = $this->emratDiteve[$dita] ?? $dita;

        // ── Conflict 1: Salla e zene ──────────────────────────────────────────
        $qSalla = Orar::where('SALLE_ID', $salleId)
            ->where('ORAR_DITA', $dita)
            ->where('ORAR_ORA_FILL', '<', $oraMba)
            ->where('ORAR_ORA_MBA', '>', $oraFill);

        if ($excludeOrarId !== null) {
            $qSalla->where('ORAR_ID', '!=', $excludeOrarId);
        }

        $sallaKonflikt = $qSalla->first();
        if ($sallaKonflikt) {
            $salla       = Salle::find($salleId);
            $konflikte[] = sprintf(
                'Salla eshte e zene: %s ne diten %s ora %s-%s',
                $salla?->SALLE_EM ?? $salleId,
                $emriDites,
                $sallaKonflikt->ORAR_ORA_FILL,
                $sallaKonflikt->ORAR_ORA_MBA
            );
        }

        // ── Conflict 2: Pedagogu i zene ───────────────────────────────────────
        $seksioni = Seksion::find($sekId);

        if ($seksioni && $seksioni->PED_ID) {
            $qPed = Orar::join('SEKSION', 'ORAR.SEK_ID', '=', 'SEKSION.SEK_ID')
                ->where('SEKSION.PED_ID', $seksioni->PED_ID)
                ->where('ORAR.ORAR_DITA', $dita)
                ->where('ORAR.ORAR_ORA_FILL', '<', $oraMba)
                ->where('ORAR.ORAR_ORA_MBA', '>', $oraFill)
                ->select('ORAR.*');

            if ($excludeOrarId !== null) {
                $qPed->where('ORAR.ORAR_ID', '!=', $excludeOrarId);
            }

            $pedKonflikt = $qPed->first();
            if ($pedKonflikt) {
                $konflikte[] = sprintf(
                    'Pedagogu eshte i zene ne diten %s ora %s-%s',
                    $emriDites,
                    $pedKonflikt->ORAR_ORA_FILL,
                    $pedKonflikt->ORAR_ORA_MBA
                );
            }
        }

        // ── Conflict 3: Grupi i studenteve ────────────────────────────────────
        if ($seksioni && $seksioni->SEM_ID) {
            $seksionetEGrupit = Seksion::where('SEM_ID', $seksioni->SEM_ID)
                ->where('SEK_ID', '!=', $sekId)
                ->pluck('SEK_ID');

            if ($seksionetEGrupit->isNotEmpty()) {
                $qGrup = Orar::whereIn('SEK_ID', $seksionetEGrupit)
                    ->where('ORAR_DITA', $dita)
                    ->where('ORAR_ORA_FILL', '<', $oraMba)
                    ->where('ORAR_ORA_MBA', '>', $oraFill)
                    ->with('seksioni.lenda');

                if ($excludeOrarId !== null) {
                    $qGrup->where('ORAR_ID', '!=', $excludeOrarId);
                }

                $grupKonflikt = $qGrup->first();
                if ($grupKonflikt) {
                    $lendaEm     = $grupKonflikt->seksioni?->lenda?->LEN_EM ?? 'e panjohur';
                    $konflikte[] = sprintf(
                        'Grupi i studenteve ka nje tjeter lende ne te njejten kohe: %s',
                        $lendaEm
                    );
                }
            }
        }

        return $konflikte;
    }
}
