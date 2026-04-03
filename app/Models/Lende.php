<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lende extends Model
{
    protected $table      = 'LENDE';
    protected $primaryKey = 'LEN_ID';
    public    $timestamps = false;

    protected $fillable = [
        'DEP_ID',
        'LEN_EM',
        'LEN_KOD',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function departamenti()
    {
        return $this->belongsTo(Departament::class, 'DEP_ID', 'DEP_ID');
    }

    public function lendeProgramit()
    {
        return $this->hasMany(LendeProgrami::class, 'LEN_ID', 'LEN_ID');
    }

    public function seksionet()
    {
        return $this->hasMany(Seksion::class, 'LEN_ID', 'LEN_ID');
    }
}
