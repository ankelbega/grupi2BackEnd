<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeksionSeeder extends Seeder
{
    public function run(): void
    {
        // SEM_ID=5 → semestri i parë i vitit 2025-2026 (aktiv)
        // SALLE_ID references only AUDITOR entries (SALLE_ID 1–8)
        // PED_ID=1..5 from PEDAGOG table
        // LEN_ID=1..10 distributed across pedagoget sipas departamentit
        DB::table('SEKSION')->insert([
            // PED_ID=1 (Dept Informatike) — LEN 1 & 2
            [
                'LEN_ID'        => 1,
                'SEM_ID'        => 5,
                'PED_ID'        => 1,
                'SALLE_ID'      => 1,
                'SEK_KOD'       => 'SEK2025-001',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            [
                'LEN_ID'        => 2,
                'SEM_ID'        => 5,
                'PED_ID'        => 1,
                'SALLE_ID'      => 2,
                'SEK_KOD'       => 'SEK2025-002',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            // PED_ID=2 (Dept Inxhinieri Softuerike) — LEN 3 & 4
            [
                'LEN_ID'        => 3,
                'SEM_ID'        => 5,
                'PED_ID'        => 2,
                'SALLE_ID'      => 3,
                'SEK_KOD'       => 'SEK2025-003',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            [
                'LEN_ID'        => 4,
                'SEM_ID'        => 5,
                'PED_ID'        => 2,
                'SALLE_ID'      => 4,
                'SEK_KOD'       => 'SEK2025-004',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            // PED_ID=3 (Dept Finance) — LEN 5 & 6
            [
                'LEN_ID'        => 5,
                'SEM_ID'        => 5,
                'PED_ID'        => 3,
                'SALLE_ID'      => 5,
                'SEK_KOD'       => 'SEK2025-005',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            [
                'LEN_ID'        => 6,
                'SEM_ID'        => 5,
                'PED_ID'        => 3,
                'SALLE_ID'      => 6,
                'SEK_KOD'       => 'SEK2025-006',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            // PED_ID=4 (Dept Kontabilitet) — LEN 7 & 8
            [
                'LEN_ID'        => 7,
                'SEM_ID'        => 5,
                'PED_ID'        => 4,
                'SALLE_ID'      => 7,
                'SEK_KOD'       => 'SEK2025-007',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            [
                'LEN_ID'        => 8,
                'SEM_ID'        => 5,
                'PED_ID'        => 4,
                'SALLE_ID'      => 8,
                'SEK_KOD'       => 'SEK2025-008',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            // PED_ID=5 (Dept E Drejta) — LEN 9 & 10
            [
                'LEN_ID'        => 9,
                'SEM_ID'        => 5,
                'PED_ID'        => 5,
                'SALLE_ID'      => 1,
                'SEK_KOD'       => 'SEK2025-009',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
            [
                'LEN_ID'        => 10,
                'SEM_ID'        => 5,
                'PED_ID'        => 5,
                'SALLE_ID'      => 2,
                'SEK_KOD'       => 'SEK2025-010',
                'SEK_KAPACITET' => 30,
                'SEK_MENYRE'    => 'prezence',
                'SEK_STATUS'    => 'aktiv',
            ],
        ]);
    }
}
