<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerdoruesSeeder extends Seeder
{
    public function run(): void
    {
        $hash = bcrypt('password123');

        DB::table('PERDORUES')->insert([
            // ── Pedagoget (PERD_ID 1–5) ──────────────────────────────────────
            [
                'PERD_EMER'    => 'Artan',
                'PERD_MBIEMER' => 'Berisha',
                'PERD_EMAIL'   => 'artan.berisha@uni.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'pedagog',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Blerina',
                'PERD_MBIEMER' => 'Koci',
                'PERD_EMAIL'   => 'blerina.koci@uni.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'pedagog',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Gent',
                'PERD_MBIEMER' => 'Marku',
                'PERD_EMAIL'   => 'gent.marku@uni.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'pedagog',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Drita',
                'PERD_MBIEMER' => 'Hoxha',
                'PERD_EMAIL'   => 'drita.hoxha@uni.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'pedagog',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Ilir',
                'PERD_MBIEMER' => 'Shehu',
                'PERD_EMAIL'   => 'ilir.shehu@uni.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'pedagog',
                'PERD_AKTIV'   => 1,
            ],
            // ── Studentet (PERD_ID 6–15) ─────────────────────────────────────
            [
                'PERD_EMER'    => 'Andi',
                'PERD_MBIEMER' => 'Leka',
                'PERD_EMAIL'   => 'andi.leka@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Sara',
                'PERD_MBIEMER' => 'Gjoka',
                'PERD_EMAIL'   => 'sara.gjoka@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Endri',
                'PERD_MBIEMER' => 'Prifti',
                'PERD_EMAIL'   => 'endri.prifti@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Klara',
                'PERD_MBIEMER' => 'Doci',
                'PERD_EMAIL'   => 'klara.doci@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Redi',
                'PERD_MBIEMER' => 'Cela',
                'PERD_EMAIL'   => 'redi.cela@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Anisa',
                'PERD_MBIEMER' => 'Kelmendi',
                'PERD_EMAIL'   => 'anisa.kelmendi@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Erjon',
                'PERD_MBIEMER' => 'Murati',
                'PERD_EMAIL'   => 'erjon.murati@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Mirela',
                'PERD_MBIEMER' => 'Zajmi',
                'PERD_EMAIL'   => 'mirela.zajmi@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Alban',
                'PERD_MBIEMER' => 'Brahimi',
                'PERD_EMAIL'   => 'alban.brahimi@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
            [
                'PERD_EMER'    => 'Vesa',
                'PERD_MBIEMER' => 'Osmani',
                'PERD_EMAIL'   => 'vesa.osmani@stud.edu.al',
                'PERD_FJKALIM' => $hash,
                'PERD_TIPI'    => 'student',
                'PERD_AKTIV'   => 1,
            ],
        ]);
    }
}
