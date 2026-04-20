<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LendeTest extends TestCase
{
    use RefreshDatabase;

    private function createDepartament(): int
    {
        $fakId = DB::table('FAKULTET')->insertGetId(['FAK_EM' => 'Test Fakultet']);

        return DB::table('DEPARTAMENT')->insertGetId([
            'DEP_EM' => 'Test Departament',
            'FAK_ID' => $fakId,
        ]);
    }

    public function test_admin_mund_te_shikoje_lendet(): void
    {
        $response = $this->withToken($this->adminToken())
            ->getJson('/api/lende');

        $response->assertStatus(200)->assertJsonStructure(['success', 'data']);
    }

    public function test_student_mund_te_shikoje_lendet(): void
    {
        $response = $this->withToken($this->studentToken())
            ->getJson('/api/lende');

        $response->assertStatus(200);
    }

    public function test_pedagog_mund_te_shikoje_lendet(): void
    {
        $response = $this->withToken($this->pedagogToken())
            ->getJson('/api/lende');

        $response->assertStatus(200);
    }

    public function test_admin_mund_te_krijoje_lende(): void
    {
        $depId = $this->createDepartament();

        $response = $this->withToken($this->adminToken())
            ->postJson('/api/lende', [
                'LEN_EM'  => 'Lende Test',
                'LEN_KOD' => 'TST101',
                'DEP_ID'  => $depId,
            ]);

        $response->assertStatus(201);
    }

    public function test_pedagog_nuk_mund_te_krijoje_lende(): void
    {
        $depId = $this->createDepartament();

        $response = $this->withToken($this->pedagogToken())
            ->postJson('/api/lende', [
                'LEN_EM'  => 'Lende Test',
                'LEN_KOD' => 'TST102',
                'DEP_ID'  => $depId,
            ]);

        $response->assertStatus(403);
    }

    public function test_student_nuk_mund_te_krijoje_lende(): void
    {
        $depId = $this->createDepartament();

        $response = $this->withToken($this->studentToken())
            ->postJson('/api/lende', [
                'LEN_EM'  => 'Lende Test',
                'LEN_KOD' => 'TST103',
                'DEP_ID'  => $depId,
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_nuk_mund_te_fshije_lende_me_seksione(): void
    {
        $depId = $this->createDepartament();

        $lenId = DB::table('LENDE')->insertGetId([
            'DEP_ID'  => $depId,
            'LEN_EM'  => 'Lende Me Seksion',
            'LEN_KOD' => 'TST104',
        ]);

        $vitId = DB::table('VIT_AKADEMIK')->insertGetId([
            'VIT_EM'      => '2025-2026',
            'VIT_DT_FILL' => '2025-09-01',
            'VIT_DT_MBR'  => '2026-06-30',
            'VIT_STATUS'  => 'aktiv',
        ]);

        $semId = DB::table('SEMESTËR')->insertGetId([
            'VIT_ID'      => $vitId,
            'SEM_NR'      => 1,
            'SEM_DT_FILL' => '2025-09-01',
            'SEM_DT_MBR'  => '2026-01-31',
        ]);

        $pedUser = $this->createPedagog();

        $pedId = DB::table('PEDAGOG')->insertGetId([
            'DEP_ID'              => $depId,
            'PERD_ID'             => $pedUser->PERD_ID,
            'PED_KOD'             => 'TPED001',
            'PED_SPECIALIZIM'     => 'Test',
            'PED_LLOJ_KONTRATE'   => 'kohe-plote',
        ]);

        DB::table('SEKSION')->insert([
            'LEN_ID'        => $lenId,
            'SEM_ID'        => $semId,
            'PED_ID'        => $pedId,
            'SEK_KOD'       => 'TSEK001',
            'SEK_KAPACITET' => 30,
            'SEK_MENYRE'    => 'prezence',
            'SEK_STATUS'    => 'aktiv',
        ]);

        $response = $this->withToken($this->adminToken())
            ->deleteJson("/api/lende/{$lenId}");

        $response->assertStatus(409);
    }
}
