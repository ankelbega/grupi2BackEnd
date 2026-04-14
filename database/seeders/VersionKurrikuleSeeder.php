<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VersionKurrikuleSeeder extends Seeder
{
    public function run(): void
    {
        // One active version per program (PROG_ID 1–6)
        DB::table('VERSION_KURRIKULE')->insert([
            ['PROG_ID' => 1, 'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2020-09-01'],
            ['PROG_ID' => 2, 'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2021-09-01'],
            ['PROG_ID' => 3, 'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2020-09-01'],
            ['PROG_ID' => 4, 'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2020-09-01'],
            ['PROG_ID' => 5, 'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2020-09-01'],
            ['PROG_ID' => 6, 'KURR_VER_NR' => 1, 'KURR_VER_AKTIV' => 1, 'KURR_VER_DATA' => '2021-09-01'],
        ]);
    }
}
