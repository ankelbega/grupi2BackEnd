<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalleSeeder extends Seeder
{
    public function run(): void
    {
        // ── SALLE (8 rows, SALLE_ID 1–8 via IDENTITY) ────────────────────────
        DB::table('SALLE')->insert([
            ['SALLE_EM' => 'Salla A101', 'SALLE_KAP' => 30,  'FAK_ID' => 1],
            ['SALLE_EM' => 'Salla A102', 'SALLE_KAP' => 50,  'FAK_ID' => 1],
            ['SALLE_EM' => 'Salla A103', 'SALLE_KAP' => 80,  'FAK_ID' => 1],
            ['SALLE_EM' => 'Salla B101', 'SALLE_KAP' => 30,  'FAK_ID' => 2],
            ['SALLE_EM' => 'Salla B102', 'SALLE_KAP' => 60,  'FAK_ID' => 2],
            ['SALLE_EM' => 'Salla C101', 'SALLE_KAP' => 40,  'FAK_ID' => 3],
            ['SALLE_EM' => 'Salla D101', 'SALLE_KAP' => 100, 'FAK_ID' => 4],
            ['SALLE_EM' => 'Salla D102', 'SALLE_KAP' => 120, 'FAK_ID' => 4],
        ]);

        // ── AUDITOR (all 8 salles — SALLE_ID is PK, no auto-increment) ───────
        // SALLE_ID must be inserted explicitly (shared PK / ISA pattern)
        DB::table('AUDITOR')->insert([
            ['SALLE_ID' => 1, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'seminar'],
            ['SALLE_ID' => 2, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'seminar'],
            ['SALLE_ID' => 3, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => 4, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'seminar'],
            ['SALLE_ID' => 5, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => 6, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'seminar'],
            ['SALLE_ID' => 7, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => 8, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
        ]);

        // ── LABORATOR (3 rows — subset of AUDITOR; SALLE_ID shared PK) ───────
        DB::table('LABORATOR')->insert([
            ['SALLE_ID' => 1, 'LAB_NR_KOMPJUTER' => 25, 'LAB_SISTEMI_OPERATIV' => 'Windows 11'],
            ['SALLE_ID' => 2, 'LAB_NR_KOMPJUTER' => 20, 'LAB_SISTEMI_OPERATIV' => 'Windows 11'],
            ['SALLE_ID' => 3, 'LAB_NR_KOMPJUTER' => 30, 'LAB_SISTEMI_OPERATIV' => 'Windows 11'],
        ]);
    }
}
