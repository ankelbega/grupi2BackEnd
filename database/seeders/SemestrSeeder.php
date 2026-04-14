<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemestrSeeder extends Seeder
{
    public function run(): void
    {
        // Table has special char: SEMESTËR (as defined in Semestri model)
        // VIT_ID=1 → 2023-2024 | VIT_ID=2 → 2024-2025 | VIT_ID=3 → 2025-2026
        DB::table('SEMESTËR')->insert([
            // 2023-2024
            ['VIT_ID' => 1, 'SEM_NR' => 1, 'SEM_DT_FILL' => '2023-09-01', 'SEM_DT_MBR' => '2024-01-31'],
            ['VIT_ID' => 1, 'SEM_NR' => 2, 'SEM_DT_FILL' => '2024-02-01', 'SEM_DT_MBR' => '2024-06-30'],
            // 2024-2025
            ['VIT_ID' => 2, 'SEM_NR' => 1, 'SEM_DT_FILL' => '2024-09-01', 'SEM_DT_MBR' => '2025-01-31'],
            ['VIT_ID' => 2, 'SEM_NR' => 2, 'SEM_DT_FILL' => '2025-02-01', 'SEM_DT_MBR' => '2025-06-30'],
            // 2025-2026
            ['VIT_ID' => 3, 'SEM_NR' => 1, 'SEM_DT_FILL' => '2025-09-01', 'SEM_DT_MBR' => '2026-01-31'],
            ['VIT_ID' => 3, 'SEM_NR' => 2, 'SEM_DT_FILL' => '2026-02-01', 'SEM_DT_MBR' => '2026-06-30'],
        ]);
    }
}
