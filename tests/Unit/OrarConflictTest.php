<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class OrarConflictTest extends TestCase
{
    private function timesOverlap(string $start1, string $end1, string $start2, string $end2): bool
    {
        return $start1 < $end2 && $end1 > $start2;
    }

    public function test_oret_qe_mbivendosen_konflikton(): void
    {
        // 08:00-09:30 konflikton me 08:30-10:00
        $this->assertTrue($this->timesOverlap('08:00', '09:30', '08:30', '10:00'));
    }

    public function test_oret_qe_nuk_mbivendosen_nuk_konflikton(): void
    {
        // 08:00-09:30 nuk konflikton me 10:00-11:30
        $this->assertFalse($this->timesOverlap('08:00', '09:30', '10:00', '11:30'));
    }

    public function test_oret_njejta_konflikton(): void
    {
        // 08:00-09:30 konflikton me 08:00-09:30
        $this->assertTrue($this->timesOverlap('08:00', '09:30', '08:00', '09:30'));
    }

    public function test_ora_mbaron_kur_tjera_fillon_nuk_konflikton(): void
    {
        // 08:00-09:30 nuk konflikton me 09:30-11:00
        $this->assertFalse($this->timesOverlap('08:00', '09:30', '09:30', '11:00'));
    }

    public function test_overlap_i_pjesshem_nga_e_majta(): void
    {
        // 07:30-08:30 konflikton me 08:00-09:30
        $this->assertTrue($this->timesOverlap('07:30', '08:30', '08:00', '09:30'));
    }

    public function test_ora_e_dyte_brenda_se_pares_konflikton(): void
    {
        // 08:00-11:00 konflikton me 09:00-10:00
        $this->assertTrue($this->timesOverlap('08:00', '11:00', '09:00', '10:00'));
    }
}
