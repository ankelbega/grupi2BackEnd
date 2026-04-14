<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LendeProgramiSeeder extends Seeder
{
    public function run(): void
    {
        // KURR_VER_ID=1 → Prog.Informatike (Bachelor)
        // KURR_VER_ID=2 → Prog.Inxh.Softuerike (Master)
        // KURR_VER_ID=3 → Prog.Finance (Bachelor)
        // KURR_VER_ID=4 → Prog.Kontabilitet (Bachelor)
        // KURR_VER_ID=5 → Prog.E Drejta Civile (Bachelor)
        // KURR_VER_ID=6 → Prog.Inxh.Mekanike (Master)
        DB::table('LENDE_PROGRAMI')->insert([
            // Kurrikula Informatike — LEN_ID 1–5
            ['LEN_ID' => 1, 'KURR_VER_ID' => 1, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            ['LEN_ID' => 2, 'KURR_VER_ID' => 1, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            ['LEN_ID' => 3, 'KURR_VER_ID' => 1, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 2, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            ['LEN_ID' => 4, 'KURR_VER_ID' => 1, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 2, 'LP_ZGJEDHORE' => 0],
            ['LEN_ID' => 5, 'KURR_VER_ID' => 1, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 2, 'LP_VITI' => 2, 'LP_ZGJEDHORE' => 1],
            // Kurrikula Inxhinieri Softuerike — LEN_ID 6–7
            ['LEN_ID' => 6, 'KURR_VER_ID' => 2, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            ['LEN_ID' => 7, 'KURR_VER_ID' => 2, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 2, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            // Kurrikula Finance — LEN_ID 8–9
            ['LEN_ID' => 8, 'KURR_VER_ID' => 3, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            ['LEN_ID' => 9, 'KURR_VER_ID' => 3, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 2, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            // Kurrikula Kontabilitet — LEN_ID 10
            ['LEN_ID' => 10, 'KURR_VER_ID' => 4, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            // Kurrikula E Drejta Civile — LEN_ID 11
            ['LEN_ID' => 11, 'KURR_VER_ID' => 5, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
            // Kurrikula Inxhinieri Mekanike — LEN_ID 12
            ['LEN_ID' => 12, 'KURR_VER_ID' => 6, 'LP_KREDIT' => 6, 'LP_SEMESTRI' => 1, 'LP_VITI' => 1, 'LP_ZGJEDHORE' => 0],
        ]);
    }
}
