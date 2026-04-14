<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LendeSeeder extends Seeder
{
    public function run(): void
    {
        // DEP_ID=1 Informatike | DEP_ID=2 Inxhinieri Softuerike
        // DEP_ID=3 Finance     | DEP_ID=4 Kontabilitet
        // DEP_ID=5 E Drejta   | DEP_ID=6 Inxhinieri Mekanike
        DB::table('LENDE')->insert([
            // Informatike (5 lende)
            ['DEP_ID' => 1, 'LEN_EM' => 'Bazat e Programimit',      'LEN_KOD' => 'INF101'],
            ['DEP_ID' => 1, 'LEN_EM' => 'Struktura e te Dhenave',   'LEN_KOD' => 'INF102'],
            ['DEP_ID' => 1, 'LEN_EM' => 'Algoritmet',               'LEN_KOD' => 'INF103'],
            ['DEP_ID' => 1, 'LEN_EM' => 'Baza e te Dhenave',        'LEN_KOD' => 'INF104'],
            ['DEP_ID' => 1, 'LEN_EM' => 'Rrjeta Kompjuterike',      'LEN_KOD' => 'INF105'],
            // Inxhinieri Softuerike (2 lende)
            ['DEP_ID' => 2, 'LEN_EM' => 'Inxhinieri Softuerike',    'LEN_KOD' => 'SOF101'],
            ['DEP_ID' => 2, 'LEN_EM' => 'Testimi i Softuerit',      'LEN_KOD' => 'SOF102'],
            // Finance (2 lende)
            ['DEP_ID' => 3, 'LEN_EM' => 'Ekonomi Makro',            'LEN_KOD' => 'EKO101'],
            ['DEP_ID' => 3, 'LEN_EM' => 'Finance e Korporatave',    'LEN_KOD' => 'FIN101'],
            // Kontabilitet (1 lende)
            ['DEP_ID' => 4, 'LEN_EM' => 'Kontabilitet i Pergjithshem', 'LEN_KOD' => 'KON101'],
            // E Drejta (1 lende)
            ['DEP_ID' => 5, 'LEN_EM' => 'E Drejta Kontraktuale',    'LEN_KOD' => 'DRE101'],
            // Inxhinieri Mekanike (1 lende)
            ['DEP_ID' => 6, 'LEN_EM' => 'Mekanika e Aplikuar',      'LEN_KOD' => 'MEK101'],
        ]);
    }
}
