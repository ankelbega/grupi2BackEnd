<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProgram extends Model
{
    protected $table      = 'STUDENT_PROGRAM';
    protected $primaryKey = 'STD_PRG_ID';
    public    $timestamps = false;

    protected $fillable = [
        'STD_ID',
        'KURR_VER_ID',
        'STD_PRG_DTF',
        'STD_PRG_DTM',
        'STD_PRG_STATUS',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function studenti()
    {
        return $this->belongsTo(Student::class, 'STD_ID', 'STD_ID');
    }

    public function versioniKurrikules()
    {
        return $this->belongsTo(VersionKurrikule::class, 'KURR_VER_ID', 'KURR_VER_ID');
    }
}
