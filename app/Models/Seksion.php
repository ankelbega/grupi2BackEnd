<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seksion extends Model
{
    protected $table      = 'SEKSION';
    protected $primaryKey = 'SEK_ID';
    public    $timestamps = false;

    protected $fillable = [
        'LEN_ID',
        'SEM_ID',
        'PED_ID',
        'SALLE_ID',
        'SEK_KOD',
        'SEK_KAPACITET',
        'SEK_MENYRE',
        'SEK_STATUS',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function lenda()
    {
        return $this->belongsTo(Lende::class, 'LEN_ID', 'LEN_ID');
    }

    public function semestri()
    {
        return $this->belongsTo(Semestri::class, 'SEM_ID', 'SEM_ID');
    }

    public function pedagogi()
    {
        return $this->belongsTo(Pedagog::class, 'PED_ID', 'PED_ID');
    }

    public function salla()
    {
        return $this->belongsTo(Salle::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function oraret()
    {
        return $this->hasMany(Orar::class, 'SEK_ID', 'SEK_ID');
    }

    public function regjistrimet()
    {
        return $this->hasMany(Regjistrim::class, 'SEK_ID', 'SEK_ID');
    }

    public function provimet()
    {
        return $this->hasMany(Provim::class, 'SEK_ID', 'SEK_ID');
    }
}
