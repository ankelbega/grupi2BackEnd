<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VersionKurrikule extends Model
{
    protected $table      = 'VERSION_KURRIKULE';
    protected $primaryKey = 'KURR_VER_ID';
    public    $timestamps = false;

    protected $fillable = [
        'PROG_ID',
        'KURR_VER_NR',
        'KURR_VER_AKTIV',
        'KURR_VER_DATA',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function programiStudimit()
    {
        return $this->belongsTo(ProgramStudimi::class, 'PROG_ID', 'PROG_ID');
    }

    public function lendeProgramit()
    {
        return $this->hasMany(LendeProgrami::class, 'KURR_VER_ID', 'KURR_VER_ID');
    }

    public function studentProgramet()
    {
        return $this->hasMany(StudentProgram::class, 'KURR_VER_ID', 'KURR_VER_ID');
    }
}
