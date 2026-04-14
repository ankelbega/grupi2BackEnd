<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultetSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('FAKULTET')->insert([
            ['FAK_EM' => 'Fakulteti i Shkencave Kompjuterike'],
            ['FAK_EM' => 'Fakulteti i Ekonomise'],
            ['FAK_EM' => 'Fakulteti i Drejtesise'],
            ['FAK_EM' => 'Fakulteti i Inxhinierise'],
            ['FAK_EM' => 'Fakulteti i Shkencave Natyrore'],
        ]);
    }
}
