<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedagogSeeder extends Seeder
{
    public function run(): void
    {
        // PERD_ID 1–5 are the pedagog users inserted in PerdoruesSeeder
        DB::table('PEDAGOG')->insert([
            [
                'PERD_ID'            => 1,
                'DEP_ID'             => 1,
                'PED_KOD'            => 'PED001',
                'PED_SPECIALIZIM'    => 'Programim dhe Algoritme',
                'PED_DATA_PUNESIMIT' => '2018-09-01',
                'PED_LLOJ_KONTRATE'  => 'kohe-plote',
            ],
            [
                'PERD_ID'            => 2,
                'DEP_ID'             => 2,
                'PED_KOD'            => 'PED002',
                'PED_SPECIALIZIM'    => 'Inxhinieri dhe Cilesia e Softuerit',
                'PED_DATA_PUNESIMIT' => '2019-09-01',
                'PED_LLOJ_KONTRATE'  => 'kohe-plote',
            ],
            [
                'PERD_ID'            => 3,
                'DEP_ID'             => 3,
                'PED_KOD'            => 'PED003',
                'PED_SPECIALIZIM'    => 'Ekonomi dhe Finance',
                'PED_DATA_PUNESIMIT' => '2017-09-01',
                'PED_LLOJ_KONTRATE'  => 'kohe-plote',
            ],
            [
                'PERD_ID'            => 4,
                'DEP_ID'             => 4,
                'PED_KOD'            => 'PED004',
                'PED_SPECIALIZIM'    => 'Kontabilitet dhe Auditim',
                'PED_DATA_PUNESIMIT' => '2020-09-01',
                'PED_LLOJ_KONTRATE'  => 'kohe-pjesshme',
            ],
            [
                'PERD_ID'            => 5,
                'DEP_ID'             => 5,
                'PED_KOD'            => 'PED005',
                'PED_SPECIALIZIM'    => 'E Drejta Civile dhe Kontraktuale',
                'PED_DATA_PUNESIMIT' => '2021-02-01',
                'PED_LLOJ_KONTRATE'  => 'kohe-pjesshme',
            ],
        ]);
    }
}
