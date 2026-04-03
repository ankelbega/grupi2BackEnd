<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudimi extends Model
{
    protected $table      = 'PROGRAM_STUDIMI';
    protected $primaryKey = 'PROG_ID';
    public    $timestamps = false;

    protected $fillable = [
        'DEP_ID',
        'PROG_EM',
        'PROG_NIV',
        'PROG_KRD',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function departamenti()
    {
        return $this->belongsTo(Departament::class, 'DEP_ID', 'DEP_ID');
    }

    public function versionetKurrikules()
    {
        return $this->hasMany(VersionKurrikule::class, 'PROG_ID', 'PROG_ID');
    }
}
