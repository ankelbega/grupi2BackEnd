<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Disable FK constraints ────────────────────────────────────────────
        DB::statement("EXEC sp_MSforeachtable 'ALTER TABLE ? NOCHECK CONSTRAINT ALL'");

        // ── Delete in reverse FK dependency order ─────────────────────────────
        $tables = [
            'REZULTAT_PROVIM', 'PREZENCE', 'NOTE', 'PROVIM', 'REGJISTRIM',
            'ORAR', 'SEKSION', 'STUDENT_PROGRAM', 'NJOFTIM', 'PERDORUES_ROL',
            'STAF', 'LABORATOR', 'ZYRE', 'AUDITOR', 'SALLE', 'STUDENT',
            'PEDAGOG', 'PERDORUES', 'LENDE_PROGRAMI', 'LENDE',
            'VERSION_KURRIKULE', 'PROGRAM_STUDIMI', 'DEPARTAMENT',
            'SEMESTËR', 'VIT_AKADEMIK', 'FAKULTET', 'ROL',
        ];
        foreach ($tables as $table) {
            try { DB::table($table)->delete(); } catch (\Throwable $e) {}
        }

        // ── Reset identity counters ───────────────────────────────────────────
        $identityTables = [
            'ROL', 'FAKULTET', 'PERDORUES', 'PERDORUES_ROL', 'DEPARTAMENT',
            'PEDAGOG', 'STUDENT', 'PROGRAM_STUDIMI', 'VERSION_KURRIKULE',
            'LENDE', 'LENDE_PROGRAMI', 'VIT_AKADEMIK', 'SEMESTËR', 'SALLE',
            'SEKSION', 'ORAR', 'STUDENT_PROGRAM', 'REGJISTRIM', 'PREZENCE',
            'NOTE', 'PROVIM', 'REZULTAT_PROVIM', 'NJOFTIM',
        ];
        foreach ($identityTables as $table) {
            try { DB::statement("DBCC CHECKIDENT (N'$table', RESEED, 0)"); } catch (\Throwable $e) {}
        }

        // ── Re-enable constraints ─────────────────────────────────────────────
        DB::statement("EXEC sp_MSforeachtable 'ALTER TABLE ? CHECK CONSTRAINT ALL'");

        // ═════════════════════════════════════════════════════════════════════
        // 1. ROL
        // ═════════════════════════════════════════════════════════════════════
        DB::table('ROL')->insert([
            ['ROL_EMER' => 'admin',    'ROL_PERSHKRIM' => 'Administrator i sistemit'],
            ['ROL_EMER' => 'pedagog',  'ROL_PERSHKRIM' => 'Pedagog / Lektor'],
            ['ROL_EMER' => 'student',  'ROL_PERSHKRIM' => 'Student'],
            ['ROL_EMER' => 'staf',     'ROL_PERSHKRIM' => 'Staf administrativ'],
        ]);

        // ═════════════════════════════════════════════════════════════════════
        // 2. FAKULTET
        // ═════════════════════════════════════════════════════════════════════
        DB::table('FAKULTET')->insert([
            ['FAK_EM' => 'Fakulteti i Shkencave Kompjuterike', 'PERD_ID' => null],
            ['FAK_EM' => 'Fakulteti i Ekonomise',              'PERD_ID' => null],
            ['FAK_EM' => 'Fakulteti i Drejtesise',             'PERD_ID' => null],
            ['FAK_EM' => 'Fakulteti i Inxhinierise',           'PERD_ID' => null],
            ['FAK_EM' => 'Fakulteti i Shkencave Natyrore',     'PERD_ID' => null],
        ]);

        $fakKompjuterike = DB::table('FAKULTET')->where('FAK_EM', 'Fakulteti i Shkencave Kompjuterike')->value('FAK_ID');
        $fakEkonomise    = DB::table('FAKULTET')->where('FAK_EM', 'Fakulteti i Ekonomise')->value('FAK_ID');
        $fakDrejtesise   = DB::table('FAKULTET')->where('FAK_EM', 'Fakulteti i Drejtesise')->value('FAK_ID');
        $fakInxhinierise = DB::table('FAKULTET')->where('FAK_EM', 'Fakulteti i Inxhinierise')->value('FAK_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 3. PERDORUES
        // ═════════════════════════════════════════════════════════════════════
        $pass = Hash::make('password123');
        $adminPass = Hash::make('admin123');

        DB::table('PERDORUES')->insert([
            // Adminët
            ['PERD_EMER' => 'Admin',      'PERD_MBIEMER' => 'Sistemi',    'PERD_EMAIL' => 'admin@uni.edu.al',      'PERD_FJKALIM' => $adminPass, 'PERD_TIPI' => 'admin', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Rektori',    'PERD_MBIEMER' => 'Universitetit', 'PERD_EMAIL' => 'rektori@uni.edu.al', 'PERD_FJKALIM' => $adminPass, 'PERD_TIPI' => 'admin', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Sekretaria', 'PERD_MBIEMER' => 'Akademike',  'PERD_EMAIL' => 'sekretaria@uni.edu.al', 'PERD_FJKALIM' => $adminPass, 'PERD_TIPI' => 'admin', 'PERD_AKTIV' => true],
            // Pedagoget
            ['PERD_EMER' => 'Artan',   'PERD_MBIEMER' => 'Berisha', 'PERD_EMAIL' => 'artan.berisha@uni.edu.al',   'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'pedagog', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Blerina', 'PERD_MBIEMER' => 'Koci',    'PERD_EMAIL' => 'blerina.koci@uni.edu.al',    'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'pedagog', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Gent',    'PERD_MBIEMER' => 'Marku',   'PERD_EMAIL' => 'gent.marku@uni.edu.al',      'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'pedagog', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Drita',   'PERD_MBIEMER' => 'Hoxha',   'PERD_EMAIL' => 'drita.hoxha@uni.edu.al',     'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'pedagog', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Ilir',    'PERD_MBIEMER' => 'Shehu',   'PERD_EMAIL' => 'ilir.shehu@uni.edu.al',      'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'pedagog', 'PERD_AKTIV' => true],
            // Studentet
            ['PERD_EMER' => 'Alban',   'PERD_MBIEMER' => 'Brahimi', 'PERD_EMAIL' => 'alban.brahimi@stud.edu.al',  'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Andi',    'PERD_MBIEMER' => 'Leka',    'PERD_EMAIL' => 'andi.leka@stud.edu.al',      'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Anisa',   'PERD_MBIEMER' => 'Kelmendi','PERD_EMAIL' => 'anisa.kelmendi@stud.edu.al', 'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Endri',   'PERD_MBIEMER' => 'Prifti',  'PERD_EMAIL' => 'endri.prifti@stud.edu.al',   'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Erjon',   'PERD_MBIEMER' => 'Murati',  'PERD_EMAIL' => 'erjon.murati@stud.edu.al',   'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Klara',   'PERD_MBIEMER' => 'Doci',    'PERD_EMAIL' => 'klara.doci@stud.edu.al',     'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Mirela',  'PERD_MBIEMER' => 'Zajmi',   'PERD_EMAIL' => 'mirela.zajmi@stud.edu.al',   'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Redi',    'PERD_MBIEMER' => 'Cela',    'PERD_EMAIL' => 'redi.cela@stud.edu.al',      'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Sara',    'PERD_MBIEMER' => 'Gjoka',   'PERD_EMAIL' => 'sara.gjoka@stud.edu.al',     'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
            ['PERD_EMER' => 'Vesa',    'PERD_MBIEMER' => 'Osmani',  'PERD_EMAIL' => 'vesa.osmani@stud.edu.al',    'PERD_FJKALIM' => $pass, 'PERD_TIPI' => 'student', 'PERD_AKTIV' => true],
        ]);

        $perdArtan   = DB::table('PERDORUES')->where('PERD_EMAIL', 'artan.berisha@uni.edu.al')->value('PERD_ID');
        $perdBlerina = DB::table('PERDORUES')->where('PERD_EMAIL', 'blerina.koci@uni.edu.al')->value('PERD_ID');
        $perdGent    = DB::table('PERDORUES')->where('PERD_EMAIL', 'gent.marku@uni.edu.al')->value('PERD_ID');
        $perdDrita   = DB::table('PERDORUES')->where('PERD_EMAIL', 'drita.hoxha@uni.edu.al')->value('PERD_ID');
        $perdIlir    = DB::table('PERDORUES')->where('PERD_EMAIL', 'ilir.shehu@uni.edu.al')->value('PERD_ID');

        $perdAlban   = DB::table('PERDORUES')->where('PERD_EMAIL', 'alban.brahimi@stud.edu.al')->value('PERD_ID');
        $perdAndi    = DB::table('PERDORUES')->where('PERD_EMAIL', 'andi.leka@stud.edu.al')->value('PERD_ID');
        $perdAnisa   = DB::table('PERDORUES')->where('PERD_EMAIL', 'anisa.kelmendi@stud.edu.al')->value('PERD_ID');
        $perdEndri   = DB::table('PERDORUES')->where('PERD_EMAIL', 'endri.prifti@stud.edu.al')->value('PERD_ID');
        $perdErjon   = DB::table('PERDORUES')->where('PERD_EMAIL', 'erjon.murati@stud.edu.al')->value('PERD_ID');
        $perdKlara   = DB::table('PERDORUES')->where('PERD_EMAIL', 'klara.doci@stud.edu.al')->value('PERD_ID');
        $perdMirela  = DB::table('PERDORUES')->where('PERD_EMAIL', 'mirela.zajmi@stud.edu.al')->value('PERD_ID');
        $perdRedi    = DB::table('PERDORUES')->where('PERD_EMAIL', 'redi.cela@stud.edu.al')->value('PERD_ID');
        $perdSara    = DB::table('PERDORUES')->where('PERD_EMAIL', 'sara.gjoka@stud.edu.al')->value('PERD_ID');
        $perdVesa    = DB::table('PERDORUES')->where('PERD_EMAIL', 'vesa.osmani@stud.edu.al')->value('PERD_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 4. DEPARTAMENT
        // ═════════════════════════════════════════════════════════════════════
        DB::table('DEPARTAMENT')->insert([
            ['DEP_EM' => 'Informatike',              'FAK_ID' => $fakKompjuterike, 'PERD_ID' => null],
            ['DEP_EM' => 'Inxhinieri Softuerike',    'FAK_ID' => $fakKompjuterike, 'PERD_ID' => null],
            ['DEP_EM' => 'Finance dhe Banke',        'FAK_ID' => $fakEkonomise,    'PERD_ID' => null],
            ['DEP_EM' => 'Kontabilitet dhe Auditim', 'FAK_ID' => $fakEkonomise,    'PERD_ID' => null],
            ['DEP_EM' => 'E Drejta',                 'FAK_ID' => $fakDrejtesise,   'PERD_ID' => null],
            ['DEP_EM' => 'Inxhinieri Mekanike',      'FAK_ID' => $fakInxhinierise, 'PERD_ID' => null],
        ]);

        $depInformatike   = DB::table('DEPARTAMENT')->where('DEP_EM', 'Informatike')->value('DEP_ID');
        $depSoftueri      = DB::table('DEPARTAMENT')->where('DEP_EM', 'Inxhinieri Softuerike')->value('DEP_ID');
        $depFinance       = DB::table('DEPARTAMENT')->where('DEP_EM', 'Finance dhe Banke')->value('DEP_ID');
        $depKontabilitet  = DB::table('DEPARTAMENT')->where('DEP_EM', 'Kontabilitet dhe Auditim')->value('DEP_ID');
        $depDrejte        = DB::table('DEPARTAMENT')->where('DEP_EM', 'E Drejta')->value('DEP_ID');
        $depInxhinieri    = DB::table('DEPARTAMENT')->where('DEP_EM', 'Inxhinieri Mekanike')->value('DEP_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 5. PROGRAM_STUDIMI
        // ═════════════════════════════════════════════════════════════════════
        DB::table('PROGRAM_STUDIMI')->insert([
            ['PROG_EM' => 'Informatike',           'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => $depInformatike],
            ['PROG_EM' => 'Inxhinieri Softuerike', 'PROG_NIV' => 'Master',   'PROG_KRD' => 120, 'DEP_ID' => $depSoftueri],
            ['PROG_EM' => 'Finance',               'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => $depFinance],
            ['PROG_EM' => 'Kontabilitet',          'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => $depKontabilitet],
            ['PROG_EM' => 'E Drejta Civile',       'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => $depDrejte],
            ['PROG_EM' => 'Inxhinieri Mekanike',   'PROG_NIV' => 'Master',   'PROG_KRD' => 120, 'DEP_ID' => $depInxhinieri],
        ]);

        $progInformatike  = DB::table('PROGRAM_STUDIMI')->where('PROG_EM', 'Informatike')->value('PROG_ID');
        $progSoftueri     = DB::table('PROGRAM_STUDIMI')->where('PROG_EM', 'Inxhinieri Softuerike')->value('PROG_ID');
        $progFinance      = DB::table('PROGRAM_STUDIMI')->where('PROG_EM', 'Finance')->value('PROG_ID');
        $progKontabilitet = DB::table('PROGRAM_STUDIMI')->where('PROG_EM', 'Kontabilitet')->value('PROG_ID');
        $progDrejte       = DB::table('PROGRAM_STUDIMI')->where('PROG_EM', 'E Drejta Civile')->value('PROG_ID');
        $progInxhinieri   = DB::table('PROGRAM_STUDIMI')->where('PROG_EM', 'Inxhinieri Mekanike')->value('PROG_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 6. VERSION_KURRIKULE (one active version per program)
        // ═════════════════════════════════════════════════════════════════════
        DB::table('VERSION_KURRIKULE')->insert([
            ['PROG_ID' => $progInformatike,  'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2023-09-01'],
            ['PROG_ID' => $progSoftueri,     'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2023-09-01'],
            ['PROG_ID' => $progFinance,      'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2023-09-01'],
            ['PROG_ID' => $progKontabilitet, 'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2023-09-01'],
            ['PROG_ID' => $progDrejte,       'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2023-09-01'],
            ['PROG_ID' => $progInxhinieri,   'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2023-09-01'],
        ]);

        $kurrInformatike  = DB::table('VERSION_KURRIKULE')->where('PROG_ID', $progInformatike)->value('KURR_VER_ID');
        $kurrSoftueri     = DB::table('VERSION_KURRIKULE')->where('PROG_ID', $progSoftueri)->value('KURR_VER_ID');
        $kurrFinance      = DB::table('VERSION_KURRIKULE')->where('PROG_ID', $progFinance)->value('KURR_VER_ID');
        $kurrKontabilitet = DB::table('VERSION_KURRIKULE')->where('PROG_ID', $progKontabilitet)->value('KURR_VER_ID');
        $kurrDrejte       = DB::table('VERSION_KURRIKULE')->where('PROG_ID', $progDrejte)->value('KURR_VER_ID');
        $kurrInxhinieri   = DB::table('VERSION_KURRIKULE')->where('PROG_ID', $progInxhinieri)->value('KURR_VER_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 7. VIT_AKADEMIK
        // ═════════════════════════════════════════════════════════════════════
        DB::table('VIT_AKADEMIK')->insert([
            ['VIT_EM' => '2023-2024', 'VIT_DT_FILL' => '2023-09-01', 'VIT_DT_MBR' => '2024-06-30', 'VIT_STATUS' => 'mbyllur'],
            ['VIT_EM' => '2024-2025', 'VIT_DT_FILL' => '2024-09-01', 'VIT_DT_MBR' => '2025-06-30', 'VIT_STATUS' => 'mbyllur'],
            ['VIT_EM' => '2025-2026', 'VIT_DT_FILL' => '2025-09-01', 'VIT_DT_MBR' => '2026-06-30', 'VIT_STATUS' => 'aktiv'],
        ]);

        $vit2324 = DB::table('VIT_AKADEMIK')->where('VIT_EM', '2023-2024')->value('VIT_ID');
        $vit2425 = DB::table('VIT_AKADEMIK')->where('VIT_EM', '2024-2025')->value('VIT_ID');
        $vit2526 = DB::table('VIT_AKADEMIK')->where('VIT_EM', '2025-2026')->value('VIT_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 8. SEMESTËR (2 per academic year)
        // ═════════════════════════════════════════════════════════════════════
        DB::table('SEMESTËR')->insert([
            ['VIT_ID' => $vit2324, 'SEM_NR' => 1, 'SEM_DT_FILL' => '2023-09-01', 'SEM_DT_MBR' => '2024-01-31'],
            ['VIT_ID' => $vit2324, 'SEM_NR' => 2, 'SEM_DT_FILL' => '2024-02-01', 'SEM_DT_MBR' => '2024-06-30'],
            ['VIT_ID' => $vit2425, 'SEM_NR' => 1, 'SEM_DT_FILL' => '2024-09-01', 'SEM_DT_MBR' => '2025-01-31'],
            ['VIT_ID' => $vit2425, 'SEM_NR' => 2, 'SEM_DT_FILL' => '2025-02-01', 'SEM_DT_MBR' => '2025-06-30'],
            ['VIT_ID' => $vit2526, 'SEM_NR' => 1, 'SEM_DT_FILL' => '2025-09-01', 'SEM_DT_MBR' => '2026-01-31'],
            ['VIT_ID' => $vit2526, 'SEM_NR' => 2, 'SEM_DT_FILL' => '2026-02-01', 'SEM_DT_MBR' => '2026-06-30'],
        ]);

        $sem2526s1 = DB::table('SEMESTËR')->where('VIT_ID', $vit2526)->where('SEM_NR', 1)->value('SEM_ID');
        $sem2526s2 = DB::table('SEMESTËR')->where('VIT_ID', $vit2526)->where('SEM_NR', 2)->value('SEM_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 9. LENDE
        // ═════════════════════════════════════════════════════════════════════
        DB::table('LENDE')->insert([
            ['LEN_KOD' => 'INF101', 'LEN_EM' => 'Bazat e Programimit',        'DEP_ID' => $depInformatike],
            ['LEN_KOD' => 'INF102', 'LEN_EM' => 'Struktura e te Dhenave',     'DEP_ID' => $depInformatike],
            ['LEN_KOD' => 'INF103', 'LEN_EM' => 'Algoritmet',                 'DEP_ID' => $depInformatike],
            ['LEN_KOD' => 'INF104', 'LEN_EM' => 'Baza e te Dhenave',          'DEP_ID' => $depInformatike],
            ['LEN_KOD' => 'INF105', 'LEN_EM' => 'Rrjeta Kompjuterike',        'DEP_ID' => $depInformatike],
            ['LEN_KOD' => 'SOF101', 'LEN_EM' => 'Inxhinieri Softuerike',      'DEP_ID' => $depSoftueri],
            ['LEN_KOD' => 'SOF102', 'LEN_EM' => 'Testimi i Softuerit',        'DEP_ID' => $depSoftueri],
            ['LEN_KOD' => 'EKO101', 'LEN_EM' => 'Ekonomi Makro',              'DEP_ID' => $depFinance],
            ['LEN_KOD' => 'FIN101', 'LEN_EM' => 'Finance e Korporatave',      'DEP_ID' => $depFinance],
            ['LEN_KOD' => 'KON101', 'LEN_EM' => 'Kontabilitet i Pergjithshem','DEP_ID' => $depKontabilitet],
            ['LEN_KOD' => 'DRE101', 'LEN_EM' => 'E Drejta Civile',            'DEP_ID' => $depDrejte],
            ['LEN_KOD' => 'INX101', 'LEN_EM' => 'Inxhinieri Mekanike Bazike', 'DEP_ID' => $depInxhinieri],
        ]);

        $lenINF101 = DB::table('LENDE')->where('LEN_KOD', 'INF101')->value('LEN_ID');
        $lenINF102 = DB::table('LENDE')->where('LEN_KOD', 'INF102')->value('LEN_ID');
        $lenINF103 = DB::table('LENDE')->where('LEN_KOD', 'INF103')->value('LEN_ID');
        $lenINF104 = DB::table('LENDE')->where('LEN_KOD', 'INF104')->value('LEN_ID');
        $lenINF105 = DB::table('LENDE')->where('LEN_KOD', 'INF105')->value('LEN_ID');
        $lenSOF101 = DB::table('LENDE')->where('LEN_KOD', 'SOF101')->value('LEN_ID');
        $lenSOF102 = DB::table('LENDE')->where('LEN_KOD', 'SOF102')->value('LEN_ID');
        $lenEKO101 = DB::table('LENDE')->where('LEN_KOD', 'EKO101')->value('LEN_ID');
        $lenFIN101 = DB::table('LENDE')->where('LEN_KOD', 'FIN101')->value('LEN_ID');
        $lenKON101 = DB::table('LENDE')->where('LEN_KOD', 'KON101')->value('LEN_ID');
        $lenDRE101 = DB::table('LENDE')->where('LEN_KOD', 'DRE101')->value('LEN_ID');
        $lenINX101 = DB::table('LENDE')->where('LEN_KOD', 'INX101')->value('LEN_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 10. PEDAGOG
        // ═════════════════════════════════════════════════════════════════════
        DB::table('PEDAGOG')->insert([
            ['DEP_ID' => $depInformatike,  'PERD_ID' => $perdArtan,   'PED_KOD' => 'PED001', 'PED_SPECIALIZIM' => 'Programim',               'PED_DATA_PUNESIMIT' => '2015-09-01'],
            ['DEP_ID' => $depSoftueri,     'PERD_ID' => $perdBlerina, 'PED_KOD' => 'PED002', 'PED_SPECIALIZIM' => 'Inxhinieri Softuerike',    'PED_DATA_PUNESIMIT' => '2016-09-01'],
            ['DEP_ID' => $depFinance,      'PERD_ID' => $perdGent,    'PED_KOD' => 'PED003', 'PED_SPECIALIZIM' => 'Ekonomi',                  'PED_DATA_PUNESIMIT' => '2017-09-01'],
            ['DEP_ID' => $depKontabilitet, 'PERD_ID' => $perdDrita,   'PED_KOD' => 'PED004', 'PED_SPECIALIZIM' => 'Kontabilitet',             'PED_DATA_PUNESIMIT' => '2018-09-01'],
            ['DEP_ID' => $depDrejte,       'PERD_ID' => $perdIlir,    'PED_KOD' => 'PED005', 'PED_SPECIALIZIM' => 'E Drejta',                 'PED_DATA_PUNESIMIT' => '2019-09-01'],
        ]);

        $pedArtan   = DB::table('PEDAGOG')->where('PED_KOD', 'PED001')->value('PED_ID');
        $pedBlerina = DB::table('PEDAGOG')->where('PED_KOD', 'PED002')->value('PED_ID');
        $pedGent    = DB::table('PEDAGOG')->where('PED_KOD', 'PED003')->value('PED_ID');
        $pedDrita   = DB::table('PEDAGOG')->where('PED_KOD', 'PED004')->value('PED_ID');
        $pedIlir    = DB::table('PEDAGOG')->where('PED_KOD', 'PED005')->value('PED_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 11. STUDENT
        // ═════════════════════════════════════════════════════════════════════
        DB::table('STUDENT')->insert([
            ['PERD_ID' => $perdAlban,  'DEP_ID' => $depInformatike,  'STD_KOD' => 'STD001', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdAndi,   'DEP_ID' => $depInformatike,  'STD_KOD' => 'STD002', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdAnisa,  'DEP_ID' => $depSoftueri,     'STD_KOD' => 'STD003', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdEndri,  'DEP_ID' => $depSoftueri,     'STD_KOD' => 'STD004', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdErjon,  'DEP_ID' => $depFinance,      'STD_KOD' => 'STD005', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdKlara,  'DEP_ID' => $depFinance,      'STD_KOD' => 'STD006', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdMirela, 'DEP_ID' => $depKontabilitet, 'STD_KOD' => 'STD007', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdRedi,   'DEP_ID' => $depKontabilitet, 'STD_KOD' => 'STD008', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdSara,   'DEP_ID' => $depDrejte,       'STD_KOD' => 'STD009', 'STD_STATUSI' => 'aktiv'],
            ['PERD_ID' => $perdVesa,   'DEP_ID' => $depInxhinieri,   'STD_KOD' => 'STD010', 'STD_STATUSI' => 'aktiv'],
        ]);

        // ═════════════════════════════════════════════════════════════════════
        // 12. SALLE (8 salla)
        // ═════════════════════════════════════════════════════════════════════
        DB::table('SALLE')->insert([
            ['SALLE_EM' => 'Salla A101', 'SALLE_KAP' => 30, 'FAK_ID' => $fakKompjuterike],
            ['SALLE_EM' => 'Salla A102', 'SALLE_KAP' => 40, 'FAK_ID' => $fakKompjuterike],
            ['SALLE_EM' => 'Salla A103', 'SALLE_KAP' => 50, 'FAK_ID' => $fakKompjuterike],
            ['SALLE_EM' => 'Salla A104', 'SALLE_KAP' => 60, 'FAK_ID' => $fakKompjuterike],
            ['SALLE_EM' => 'Salla B101', 'SALLE_KAP' => 30, 'FAK_ID' => $fakKompjuterike],
            ['SALLE_EM' => 'Salla B102', 'SALLE_KAP' => 40, 'FAK_ID' => $fakKompjuterike],
            ['SALLE_EM' => 'Salla B103', 'SALLE_KAP' => 50, 'FAK_ID' => $fakKompjuterike],
            ['SALLE_EM' => 'Salla B104', 'SALLE_KAP' => 60, 'FAK_ID' => $fakKompjuterike],
        ]);

        $salleA101 = DB::table('SALLE')->where('SALLE_EM', 'Salla A101')->value('SALLE_ID');
        $salleA102 = DB::table('SALLE')->where('SALLE_EM', 'Salla A102')->value('SALLE_ID');
        $salleA103 = DB::table('SALLE')->where('SALLE_EM', 'Salla A103')->value('SALLE_ID');
        $salleA104 = DB::table('SALLE')->where('SALLE_EM', 'Salla A104')->value('SALLE_ID');
        $salleB101 = DB::table('SALLE')->where('SALLE_EM', 'Salla B101')->value('SALLE_ID');
        $salleB102 = DB::table('SALLE')->where('SALLE_EM', 'Salla B102')->value('SALLE_ID');
        $salleB103 = DB::table('SALLE')->where('SALLE_EM', 'Salla B103')->value('SALLE_ID');
        $salleB104 = DB::table('SALLE')->where('SALLE_EM', 'Salla B104')->value('SALLE_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 13. AUDITOR (all 8 salla)
        // ═════════════════════════════════════════════════════════════════════
        DB::table('AUDITOR')->insert([
            ['SALLE_ID' => $salleA101, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => $salleA102, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => $salleA103, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => $salleA104, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => $salleB101, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => $salleB102, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => $salleB103, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
            ['SALLE_ID' => $salleB104, 'AUD_KA_PROJEKTOR' => 1, 'AUD_LLOJI' => 'lecture hall'],
        ]);

        // ═════════════════════════════════════════════════════════════════════
        // 14. LABORATOR (first 3 salla: A101, A102, A103)
        // ═════════════════════════════════════════════════════════════════════
        DB::table('LABORATOR')->insert([
            ['SALLE_ID' => $salleA101, 'LAB_NR_KOMPJUTER' => 20, 'LAB_SISTEMI_OPERATIV' => 'Windows 11'],
            ['SALLE_ID' => $salleA102, 'LAB_NR_KOMPJUTER' => 20, 'LAB_SISTEMI_OPERATIV' => 'Windows 11'],
            ['SALLE_ID' => $salleA103, 'LAB_NR_KOMPJUTER' => 20, 'LAB_SISTEMI_OPERATIV' => 'Windows 11'],
        ]);

        // ═════════════════════════════════════════════════════════════════════
        // 15. LENDE_PROGRAMI
        // ═════════════════════════════════════════════════════════════════════
        DB::table('LENDE_PROGRAMI')->insert([
            // Informatike curriculum
            ['LEN_ID' => $lenINF101, 'KURR_VER_ID' => $kurrInformatike,  'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 1],
            ['LEN_ID' => $lenINF102, 'KURR_VER_ID' => $kurrInformatike,  'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 2],
            ['LEN_ID' => $lenINF103, 'KURR_VER_ID' => $kurrInformatike,  'LP_KREDIT' => 6, 'LP_VITI' => 2, 'LP_SEMESTRI' => 3],
            ['LEN_ID' => $lenINF104, 'KURR_VER_ID' => $kurrInformatike,  'LP_KREDIT' => 6, 'LP_VITI' => 2, 'LP_SEMESTRI' => 4],
            ['LEN_ID' => $lenINF105, 'KURR_VER_ID' => $kurrInformatike,  'LP_KREDIT' => 6, 'LP_VITI' => 3, 'LP_SEMESTRI' => 5],
            // Inxhinieri Softuerike curriculum
            ['LEN_ID' => $lenSOF101, 'KURR_VER_ID' => $kurrSoftueri,     'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 1],
            ['LEN_ID' => $lenSOF102, 'KURR_VER_ID' => $kurrSoftueri,     'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 2],
            // Finance curriculum
            ['LEN_ID' => $lenEKO101, 'KURR_VER_ID' => $kurrFinance,      'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 1],
            ['LEN_ID' => $lenFIN101, 'KURR_VER_ID' => $kurrFinance,      'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 2],
            // Kontabilitet curriculum
            ['LEN_ID' => $lenKON101, 'KURR_VER_ID' => $kurrKontabilitet, 'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 1],
            // E Drejta curriculum
            ['LEN_ID' => $lenDRE101, 'KURR_VER_ID' => $kurrDrejte,       'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 1],
            // Inxhinieri Mekanike curriculum
            ['LEN_ID' => $lenINX101, 'KURR_VER_ID' => $kurrInxhinieri,   'LP_KREDIT' => 6, 'LP_VITI' => 1, 'LP_SEMESTRI' => 1],
        ]);

        // ═════════════════════════════════════════════════════════════════════
        // 16. SEKSION (10 seksione aktive)
        // ═════════════════════════════════════════════════════════════════════
        DB::table('SEKSION')->insert([
            ['LEN_ID' => $lenINF101, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedArtan,   'SALLE_ID' => $salleA101, 'SEK_KOD' => 'SEK001', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenINF102, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedArtan,   'SALLE_ID' => $salleA102, 'SEK_KOD' => 'SEK002', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenINF103, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedArtan,   'SALLE_ID' => $salleA103, 'SEK_KOD' => 'SEK003', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenINF104, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedArtan,   'SALLE_ID' => $salleA104, 'SEK_KOD' => 'SEK004', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenSOF101, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedBlerina, 'SALLE_ID' => $salleB101, 'SEK_KOD' => 'SEK005', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenSOF102, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedBlerina, 'SALLE_ID' => $salleB102, 'SEK_KOD' => 'SEK006', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenEKO101, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedGent,    'SALLE_ID' => $salleB103, 'SEK_KOD' => 'SEK007', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenFIN101, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedGent,    'SALLE_ID' => $salleB104, 'SEK_KOD' => 'SEK008', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenKON101, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedDrita,   'SALLE_ID' => $salleA101, 'SEK_KOD' => 'SEK009', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
            ['LEN_ID' => $lenDRE101, 'SEM_ID' => $sem2526s1, 'PED_ID' => $pedIlir,    'SALLE_ID' => $salleA102, 'SEK_KOD' => 'SEK010', 'SEK_KAPACITET' => 30, 'SEK_STATUS' => 'aktiv'],
        ]);

        $sek001 = DB::table('SEKSION')->where('SEK_KOD', 'SEK001')->value('SEK_ID');
        $sek002 = DB::table('SEKSION')->where('SEK_KOD', 'SEK002')->value('SEK_ID');
        $sek003 = DB::table('SEKSION')->where('SEK_KOD', 'SEK003')->value('SEK_ID');
        $sek004 = DB::table('SEKSION')->where('SEK_KOD', 'SEK004')->value('SEK_ID');
        $sek005 = DB::table('SEKSION')->where('SEK_KOD', 'SEK005')->value('SEK_ID');
        $sek006 = DB::table('SEKSION')->where('SEK_KOD', 'SEK006')->value('SEK_ID');
        $sek007 = DB::table('SEKSION')->where('SEK_KOD', 'SEK007')->value('SEK_ID');
        $sek008 = DB::table('SEKSION')->where('SEK_KOD', 'SEK008')->value('SEK_ID');
        $sek009 = DB::table('SEKSION')->where('SEK_KOD', 'SEK009')->value('SEK_ID');
        $sek010 = DB::table('SEKSION')->where('SEK_KOD', 'SEK010')->value('SEK_ID');

        // ═════════════════════════════════════════════════════════════════════
        // 17. ORAR (15 orare, no conflicts)
        // Rules: unique (SALLE_ID, DITA, ORA_FILL/MBA overlap) per salle
        //        unique (PED_ID, DITA, ORA_FILL/MBA overlap) per pedagog
        // Schedule:
        //   Dita 1 (Hene):   SEK001 A101 08:00-10:00, SEK002 A102 08:00-10:00, SEK005 B101 08:00-10:00
        //   Dita 1 (Hene):   SEK001 A101 10:00-12:00 (2nd slot, different time), SEK006 B102 10:00-12:00
        //   Dita 2 (Marte):  SEK003 A103 08:00-10:00, SEK004 A104 08:00-10:00, SEK007 B103 08:00-10:00
        //   Dita 2 (Marte):  SEK008 B104 10:00-12:00, SEK009 A101 10:00-12:00
        //   Dita 3 (Merkure):SEK010 A102 08:00-10:00, SEK002 A102 12:00-14:00
        //   Dita 4 (Enjte):  SEK003 A103 10:00-12:00, SEK005 B101 10:00-12:00
        //   Dita 5 (Premte): SEK006 B102 08:00-10:00, SEK007 B103 10:00-12:00
        // Note: Artan teaches SEK001-004, Blerina SEK005-006, Gent SEK007-008, Drita SEK009, Ilir SEK010
        // ═════════════════════════════════════════════════════════════════════
        DB::table('ORAR')->insert([
            // Dita 1 - Artan: SEK001 A101 08-10, SEK002 A102 08-10 (diff salle/same ped same time = CONFLICT)
            // Fix: stagger Artan's slots
            // Dita 1: SEK001 A101 08-10 (Artan), SEK005 B101 08-10 (Blerina), SEK007 B103 08-10 (Gent)
            ['SEK_ID' => $sek001, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleA101, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => $sek005, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleB101, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => $sek007, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleB103, 'ORAR_LLOJI' => 'ligjerata'],
            // Dita 1: SEK002 A102 10-12 (Artan), SEK006 B102 10-12 (Blerina), SEK008 B104 10-12 (Gent)
            ['SEK_ID' => $sek002, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '10:00', 'ORAR_ORA_MBA' => '12:00', 'SALLE_ID' => $salleA102, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => $sek006, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '10:00', 'ORAR_ORA_MBA' => '12:00', 'SALLE_ID' => $salleB102, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => $sek008, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '10:00', 'ORAR_ORA_MBA' => '12:00', 'SALLE_ID' => $salleB104, 'ORAR_LLOJI' => 'ligjerata'],
            // Dita 2: SEK003 A103 08-10 (Artan), SEK009 A101 08-10 (Drita), SEK010 A102 08-10 (Ilir)
            ['SEK_ID' => $sek003, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleA103, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => $sek009, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleA101, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => $sek010, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleA102, 'ORAR_LLOJI' => 'ligjerata'],
            // Dita 2: SEK004 A104 10-12 (Artan), SEK005 B101 10-12 (Blerina)
            ['SEK_ID' => $sek004, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '10:00', 'ORAR_ORA_MBA' => '12:00', 'SALLE_ID' => $salleA104, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => $sek005, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '10:00', 'ORAR_ORA_MBA' => '12:00', 'SALLE_ID' => $salleB101, 'ORAR_LLOJI' => 'seminar'],
            // Dita 3: SEK001 A101 10-12 (Artan), SEK006 B102 08-10 (Blerina), SEK007 B103 10-12 (Gent)
            ['SEK_ID' => $sek001, 'ORAR_DITA' => 3, 'ORAR_ORA_FILL' => '10:00', 'ORAR_ORA_MBA' => '12:00', 'SALLE_ID' => $salleA101, 'ORAR_LLOJI' => 'seminar'],
            ['SEK_ID' => $sek006, 'ORAR_DITA' => 3, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleB102, 'ORAR_LLOJI' => 'seminar'],
            ['SEK_ID' => $sek007, 'ORAR_DITA' => 3, 'ORAR_ORA_FILL' => '10:00', 'ORAR_ORA_MBA' => '12:00', 'SALLE_ID' => $salleB103, 'ORAR_LLOJI' => 'seminar'],
            // Dita 3: SEK008 B104 08-10 (Gent)
            ['SEK_ID' => $sek008, 'ORAR_DITA' => 3, 'ORAR_ORA_FILL' => '08:00', 'ORAR_ORA_MBA' => '10:00', 'SALLE_ID' => $salleB104, 'ORAR_LLOJI' => 'seminar'],
        ]);
    }
}
