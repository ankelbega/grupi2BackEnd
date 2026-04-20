<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    private function createDepId(): int
    {
        $fakId = DB::table('FAKULTET')->insertGetId(['FAK_EM' => 'Test Fakultet']);
        return DB::table('DEPARTAMENT')->insertGetId(['DEP_EM' => 'Test Dep', 'FAK_ID' => $fakId]);
    }

    public function test_admin_mund_te_aksesoje_post_routes(): void
    {
        $depId = $this->createDepId();

        $response = $this->withToken($this->adminToken())
            ->postJson('/api/lende', [
                'LEN_EM'  => 'Role Test Lende',
                'LEN_KOD' => 'ROL101',
                'DEP_ID'  => $depId,
            ]);

        $response->assertStatus(201);
    }

    public function test_pedagog_nuk_mund_te_aksesoje_post_routes(): void
    {
        $depId = $this->createDepId();

        $response = $this->withToken($this->pedagogToken())
            ->postJson('/api/lende', [
                'LEN_EM'  => 'Role Test Lende',
                'LEN_KOD' => 'ROL102',
                'DEP_ID'  => $depId,
            ]);

        $response->assertStatus(403);
    }

    public function test_student_nuk_mund_te_aksesoje_post_routes(): void
    {
        $depId = $this->createDepId();

        $response = $this->withToken($this->studentToken())
            ->postJson('/api/lende', [
                'LEN_EM'  => 'Role Test Lende',
                'LEN_KOD' => 'ROL103',
                'DEP_ID'  => $depId,
            ]);

        $response->assertStatus(403);
    }

    public function test_perdorues_i_pa_autentifikuar_merr_401(): void
    {
        $response = $this->getJson('/api/lende');

        $response->assertStatus(401);
    }
}
