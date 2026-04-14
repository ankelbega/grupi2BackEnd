<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Disable ALL FK/CHECK constraints across every table ────────────
        DB::statement("EXEC sp_MSforeachtable 'ALTER TABLE ? NOCHECK CONSTRAINT ALL'");

        // ── 2. Delete in reverse FK dependency order ──────────────────────────
        //    Leaf tables first, root tables last
        $tables = [
            // deepest leaves
            'REZULTAT_PROVIM',
            'PREZENCE',
            'NOTE',
            'REGJISTRIM',
            'PROVIM',
            'ORAR',
            'SEKSION',
            'STUDENT_PROGRAM',
            'STUDENT',
            'NJOFTIM',
            'PERDORUES_ROL',
            'STAF',
            'ZYRE',
            'PEDAGOG',
            'PERDORUES',
            'LABORATOR',
            'AUDITOR',
            'SALLE',
            'LENDE_PROGRAMI',
            'LENDE',
            'VERSION_KURRIKULE',
            'PROGRAM_STUDIMI',
            'SEMESTËR',
            'VIT_AKADEMIK',
            'DEPARTAMENT',
            'FAKULTET',
        ];

        foreach ($tables as $table) {
            try {
                DB::table($table)->delete();
            } catch (\Throwable $e) {
                // Table might not exist yet — skip gracefully
            }
        }

        // ── 3. Reset IDENTITY counters to 0 (next insert → 1) ────────────────
        $identityTables = [
            'FAKULTET', 'DEPARTAMENT', 'PROGRAM_STUDIMI', 'VERSION_KURRIKULE',
            'VIT_AKADEMIK', 'SEMESTËR', 'LENDE', 'LENDE_PROGRAMI',
            'PERDORUES', 'PEDAGOG', 'SALLE', 'SEKSION', 'ORAR',
        ];

        foreach ($identityTables as $table) {
            try {
                DB::statement("DBCC CHECKIDENT (N'$table', RESEED, 0)");
            } catch (\Throwable $e) {
                // ignore if table has no identity column
            }
        }

        // ── 4. Re-enable constraints (CHECK only — no re-validation of rows) ──
        DB::statement("EXEC sp_MSforeachtable 'ALTER TABLE ? CHECK CONSTRAINT ALL'");

        // ── 5. Seed in FK dependency order ────────────────────────────────────
        $this->call([
            FakultetSeeder::class,
            DepartamentSeeder::class,
            ProgramStudimiSeeder::class,
            VersionKurrikuleSeeder::class,
            VitAkademikSeeder::class,
            SemestrSeeder::class,
            LendeSeeder::class,
            LendeProgramiSeeder::class,
            PerdoruesSeeder::class,
            PedagogSeeder::class,
            SalleSeeder::class,
            SeksionSeeder::class,
            OrarSeeder::class,
        ]);
    }
}
