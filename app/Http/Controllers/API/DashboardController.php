<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ─── stats() ─────────────────────────────────────────────────────────────

    public function stats(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data'    => [
                    'total_studentet' => DB::table('STUDENT')->count(),
                    'total_pedagoget' => DB::table('PEDAGOG')->count(),
                    'total_lendet'    => DB::table('LENDE')->count(),
                    'total_programet' => DB::table('PROGRAM_STUDIMI')->count(),
                    'total_seksionet' => DB::table('SEKSION')->count(),
                    'total_oraret'    => DB::table('ORAR')->count(),
                ],
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'mesazh' => 'Gabim gjatë marrjes së statistikave'], 500);
        }
    }

    // ─── orarePerDite() ───────────────────────────────────────────────────────

    public function orarePerDite(): JsonResponse
    {
        try {
            $emratDiteve = [
                1 => 'E Hënë',
                2 => 'E Martë',
                3 => 'E Mërkurë',
                4 => 'E Enjte',
                5 => 'E Premte',
            ];

            $rows  = DB::select('SELECT ORAR_DITA, COUNT(*) AS total FROM ORAR GROUP BY ORAR_DITA ORDER BY ORAR_DITA');
            $byDay = collect($rows)->keyBy('ORAR_DITA');

            $data = collect(range(1, 5))->map(fn ($nr) => [
                'dita'    => $emratDiteve[$nr],
                'dita_nr' => $nr,
                'total'   => (int) ($byDay->get($nr)?->total ?? 0),
            ])->values();

            return response()->json(['success' => true, 'data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'mesazh' => 'Gabim gjatë marrjes së të dhënave'], 500);
        }
    }

    // ─── studentetPerProgram() ────────────────────────────────────────────────

    public function studentetPerProgram(): JsonResponse
    {
        try {
            $rows = DB::select("
                SELECT ps.PROG_EM AS programa, COUNT(DISTINCT s.STD_ID) AS total
                FROM STUDENT s
                JOIN REGJISTRIM r        ON s.STD_ID      = r.STD_ID
                JOIN SEKSION sek         ON r.SEK_ID       = sek.SEK_ID
                JOIN LENDE_PROGRAMI lp   ON sek.LEN_ID     = lp.LEN_ID
                JOIN VERSION_KURRIKULE vk ON lp.KURR_VER_ID = vk.KURR_VER_ID
                JOIN PROGRAM_STUDIMI ps  ON vk.PROG_ID     = ps.PROG_ID
                GROUP BY ps.PROG_ID, ps.PROG_EM
                ORDER BY COUNT(DISTINCT s.STD_ID) DESC
            ");

            $data = collect($rows)->map(fn ($r) => [
                'programa' => $r->programa,
                'total'    => (int) $r->total,
            ])->values();

            return response()->json(['success' => true, 'data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'mesazh' => 'Gabim gjatë marrjes së të dhënave'], 500);
        }
    }

    // ─── ngarkesaPedagoget() ──────────────────────────────────────────────────

    public function ngarkesaPedagoget(): JsonResponse
    {
        try {
            $rows = DB::select("
                SELECT TOP 8
                    RTRIM(u.PERD_EMER) + ' ' + RTRIM(u.PERD_MBIEMER) AS pedagog,
                    COUNT(DISTINCT s.SEK_ID)  AS seksione,
                    COUNT(DISTINCT o.ORAR_ID) AS orare
                FROM PEDAGOG p
                JOIN PERDORUES u  ON p.PERD_ID = u.PERD_ID
                LEFT JOIN SEKSION s ON p.PED_ID  = s.PED_ID
                LEFT JOIN ORAR o    ON s.SEK_ID   = o.SEK_ID
                GROUP BY p.PED_ID, u.PERD_EMER, u.PERD_MBIEMER
                ORDER BY COUNT(DISTINCT s.SEK_ID) DESC
            ");

            $data = collect($rows)->map(fn ($r) => [
                'pedagog'  => $r->pedagog,
                'seksione' => (int) $r->seksione,
                'orare'    => (int) $r->orare,
            ])->values();

            return response()->json(['success' => true, 'data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'mesazh' => 'Gabim gjatë marrjes së të dhënave'], 500);
        }
    }

    // ─── lendetPerDepartament() ───────────────────────────────────────────────

    public function lendetPerDepartament(): JsonResponse
    {
        try {
            $rows = DB::select("
                SELECT d.DEP_EM AS departament, COUNT(l.LEN_ID) AS total
                FROM LENDE l
                JOIN DEPARTAMENT d ON l.DEP_ID = d.DEP_ID
                GROUP BY d.DEP_ID, d.DEP_EM
                ORDER BY COUNT(l.LEN_ID) DESC
            ");

            $data = collect($rows)->map(fn ($r) => [
                'departament' => $r->departament,
                'total'       => (int) $r->total,
            ])->values();

            return response()->json(['success' => true, 'data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'mesazh' => 'Gabim gjatë marrjes së të dhënave'], 500);
        }
    }
}
