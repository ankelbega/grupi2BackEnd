<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentSeeder extends Seeder
{
    public function run(): void
    {
        // FAK_ID=1 → Fakulteti i Shkencave Kompjuterike (2 dep)
        // FAK_ID=2 → Fakulteti i Ekonomise              (2 dep)
        // FAK_ID=3 → Fakulteti i Drejtesise             (1 dep)
        // FAK_ID=4 → Fakulteti i Inxhinierise           (1 dep)
        DB::table('DEPARTAMENT')->insert([
            ['DEP_EM' => 'Informatike',                 'FAK_ID' => 1],
            ['DEP_EM' => 'Inxhinieri Softuerike',       'FAK_ID' => 1],
            ['DEP_EM' => 'Finance dhe Banke',           'FAK_ID' => 2],
            ['DEP_EM' => 'Kontabilitet dhe Auditim',    'FAK_ID' => 2],
            ['DEP_EM' => 'E Drejta',                    'FAK_ID' => 3],
            ['DEP_EM' => 'Inxhinieri Mekanike',         'FAK_ID' => 4],
        ]);
    }
}
