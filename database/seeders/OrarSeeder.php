<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrarSeeder extends Seeder
{
    public function run(): void
    {
        // Conflict constraints respected:
        //   • SALLE_ID + ORAR_DITA + ORAR_ORA_FILL must be unique (no double room booking)
        //   • PED_ID   + ORAR_DITA + ORAR_ORA_FILL must be unique (no pedagog overlap)
        //
        // ORAR_DITA: 1=E Hene, 2=E Marte, 3=E Merkure, 4=E Enjte, 5=E Premte
        //
        // Seksion → (PED_ID, SALLE_ID):
        //   SEK1(1,1) SEK2(1,2) SEK3(2,3) SEK4(2,4) SEK5(3,5)
        //   SEK6(3,6) SEK7(4,7) SEK8(4,8) SEK9(5,1) SEK10(5,2)
        DB::table('ORAR')->insert([
            // SEK_ID=1 — PED=1, SALLE=1
            ['SEK_ID' => 1, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '08:00:00', 'ORAR_ORA_MBA' => '09:30:00', 'SALLE_ID' => 1, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => 1, 'ORAR_DITA' => 3, 'ORAR_ORA_FILL' => '08:00:00', 'ORAR_ORA_MBA' => '09:30:00', 'SALLE_ID' => 1, 'ORAR_LLOJI' => 'ligjerata'],

            // SEK_ID=2 — PED=1, SALLE=2  (different days from SEK1 → no PED conflict)
            ['SEK_ID' => 2, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '08:00:00', 'ORAR_ORA_MBA' => '09:30:00', 'SALLE_ID' => 2, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => 2, 'ORAR_DITA' => 4, 'ORAR_ORA_FILL' => '08:00:00', 'ORAR_ORA_MBA' => '09:30:00', 'SALLE_ID' => 2, 'ORAR_LLOJI' => 'seminar'],

            // SEK_ID=3 — PED=2, SALLE=3  (different slot 09:30 → no room/ped conflict)
            ['SEK_ID' => 3, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '09:30:00', 'ORAR_ORA_MBA' => '11:00:00', 'SALLE_ID' => 3, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => 3, 'ORAR_DITA' => 3, 'ORAR_ORA_FILL' => '09:30:00', 'ORAR_ORA_MBA' => '11:00:00', 'SALLE_ID' => 3, 'ORAR_LLOJI' => 'seminar'],

            // SEK_ID=4 — PED=2, SALLE=4
            ['SEK_ID' => 4, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '09:30:00', 'ORAR_ORA_MBA' => '11:00:00', 'SALLE_ID' => 4, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => 4, 'ORAR_DITA' => 4, 'ORAR_ORA_FILL' => '09:30:00', 'ORAR_ORA_MBA' => '11:00:00', 'SALLE_ID' => 4, 'ORAR_LLOJI' => 'ligjerata'],

            // SEK_ID=5 — PED=3, SALLE=5
            ['SEK_ID' => 5, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '11:00:00', 'ORAR_ORA_MBA' => '12:30:00', 'SALLE_ID' => 5, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => 5, 'ORAR_DITA' => 3, 'ORAR_ORA_FILL' => '11:00:00', 'ORAR_ORA_MBA' => '12:30:00', 'SALLE_ID' => 5, 'ORAR_LLOJI' => 'seminar'],

            // SEK_ID=6 — PED=3, SALLE=6
            ['SEK_ID' => 6, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '11:00:00', 'ORAR_ORA_MBA' => '12:30:00', 'SALLE_ID' => 6, 'ORAR_LLOJI' => 'ligjerata'],
            ['SEK_ID' => 6, 'ORAR_DITA' => 4, 'ORAR_ORA_FILL' => '11:00:00', 'ORAR_ORA_MBA' => '12:30:00', 'SALLE_ID' => 6, 'ORAR_LLOJI' => 'seminar'],

            // SEK_ID=7 — PED=4, SALLE=7
            ['SEK_ID' => 7, 'ORAR_DITA' => 1, 'ORAR_ORA_FILL' => '12:30:00', 'ORAR_ORA_MBA' => '14:00:00', 'SALLE_ID' => 7, 'ORAR_LLOJI' => 'ligjerata'],

            // SEK_ID=8 — PED=4, SALLE=8
            ['SEK_ID' => 8, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '12:30:00', 'ORAR_ORA_MBA' => '14:00:00', 'SALLE_ID' => 8, 'ORAR_LLOJI' => 'ligjerata'],

            // SEK_ID=9 — PED=5, SALLE=1  (SALLE=1 on Tue 14:00 — no conflict with rows 1,2)
            ['SEK_ID' => 9, 'ORAR_DITA' => 2, 'ORAR_ORA_FILL' => '14:00:00', 'ORAR_ORA_MBA' => '15:30:00', 'SALLE_ID' => 1, 'ORAR_LLOJI' => 'ligjerata'],
        ]);
    }
}
