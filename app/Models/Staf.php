<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    protected $table      = 'STAF';
    protected $primaryKey = 'PERD_ID'; // PK is same as FK to PERDORUES
    public    $timestamps = false;

    protected $fillable = [
        'PERD_ID',
        'STF_KOD',
        'STF_POZICION',
        'STF_DEP_ID',
        'STF_DATA_FILL',
        'STF_AKTIV',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function perdoruesi()
    {
        return $this->belongsTo(User::class, 'PERD_ID', 'PERD_ID');
    }

    public function departamenti()
    {
        return $this->belongsTo(Departament::class, 'STF_DEP_ID', 'DEP_ID');
    }
}
