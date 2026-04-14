<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudimiSeeder extends Seeder
{
    public function run(): void
    {
        // DEP_ID=1 Informatike, DEP_ID=2 Inxh.Softuerike
        // DEP_ID=3 Finance, DEP_ID=4 Kontabilitet
        // DEP_ID=5 E Drejta, DEP_ID=6 Inxh.Mekanike
        DB::table('PROGRAM_STUDIMI')->insert([
            ['PROG_EM' => 'Informatike',              'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => 1],
            ['PROG_EM' => 'Inxhinieri Softuerike',    'PROG_NIV' => 'Master',   'PROG_KRD' => 120, 'DEP_ID' => 2],
            ['PROG_EM' => 'Finance',                  'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => 3],
            ['PROG_EM' => 'Kontabilitet',             'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => 4],
            ['PROG_EM' => 'E Drejta Civile',          'PROG_NIV' => 'Bachelor', 'PROG_KRD' => 180, 'DEP_ID' => 5],
            ['PROG_EM' => 'Inxhinieri Mekanike',      'PROG_NIV' => 'Master',   'PROG_KRD' => 120, 'DEP_ID' => 6],
        ]);
    }
}
