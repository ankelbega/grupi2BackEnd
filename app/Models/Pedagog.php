<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedagog extends Model
{
    protected $table      = 'PEDAGOG';
    protected $primaryKey = 'PED_ID';
    public    $timestamps = false;

    protected $fillable = [
        'PERD_ID',
        'DEP_ID',
        'PED_KOD',
        'PED_TITULLI',
        'PED_SPECIALIZIM',
        'PED_DATA_PUNESIMIT',
        'PED_LLOJ_KONTRATE',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function perdoruesi()
    {
        return $this->belongsTo(User::class, 'PERD_ID', 'PERD_ID');
    }

    public function departamenti()
    {
        return $this->belongsTo(Departament::class, 'DEP_ID', 'DEP_ID');
    }

    public function seksionet()
    {
        return $this->hasMany(Seksion::class, 'PED_ID', 'PED_ID');
    }

    public function zyra()
    {
        return $this->hasOne(Zyre::class, 'PED_ID', 'PED_ID');
    }
}
