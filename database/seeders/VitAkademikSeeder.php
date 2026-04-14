<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VitAkademikSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('VIT_AKADEMIK')->insert([
            [
                'VIT_EM'      => '2023-2024',
                'VIT_DT_FILL' => '2023-09-01',
                'VIT_DT_MBR'  => '2024-06-30',
                'VIT_STATUS'  => 'mbyllur',
            ],
            [
                'VIT_EM'      => '2024-2025',
                'VIT_DT_FILL' => '2024-09-01',
                'VIT_DT_MBR'  => '2025-06-30',
                'VIT_STATUS'  => 'mbyllur',
            ],
            [
                'VIT_EM'      => '2025-2026',
                'VIT_DT_FILL' => '2025-09-01',
                'VIT_DT_MBR'  => '2026-06-30',
                'VIT_STATUS'  => 'aktiv',
            ],
        ]);
    }
}
