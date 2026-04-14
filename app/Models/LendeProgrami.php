<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendeProgrami extends Model
{
    protected $table      = 'LENDE_PROGRAMI';
    protected $primaryKey = 'LP_ID';
    public    $timestamps = false;

    protected $fillable = [
        'LEN_ID',
        'KURR_VER_ID',
        'LP_KREDIT',
        'LP_VITI',
        'LP_SEMESTRI',
        'LP_ZGJEDHORE',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function lenda()
    {
        return $this->belongsTo(Lende::class, 'LEN_ID', 'LEN_ID');
    }

    public function versioniKurrikules()
    {
        return $this->belongsTo(VersionKurrikule::class, 'KURR_VER_ID', 'KURR_VER_ID');
    }

    public function seksionet()
    {
        return $this->hasMany(Seksion::class, 'LP_ID', 'LP_ID');
    }
}
