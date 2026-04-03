<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provim extends Model
{
    protected $table      = 'PROVIM';
    protected $primaryKey = 'PRV_ID';
    public    $timestamps = false;

    protected $fillable = [
        'SEK_ID',
        'SEM_ID',
        'SALLE_ID',
        'PRV_EMER',
        'PRV_TIPI',
        'PRV_DATA',
        'PRV_ORA_FILL',
        'PRV_KOHEZGJATJE',
        'PRV_PIKE_MAX',
        'PRV_PIKE_KAL',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function seksioni()
    {
        return $this->belongsTo(Seksion::class, 'SEK_ID', 'SEK_ID');
    }

    public function semestri()
    {
        return $this->belongsTo(Semestri::class, 'SEM_ID', 'SEM_ID');
    }

    public function salla()
    {
        return $this->belongsTo(Salle::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function rezultatet()
    {
        return $this->hasMany(RezultatProvim::class, 'PRV_ID', 'PRV_ID');
    }
}
