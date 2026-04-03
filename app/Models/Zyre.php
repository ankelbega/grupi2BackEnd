<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zyre extends Model
{
    protected $table      = 'ZYRE';
    protected $primaryKey = 'SALLE_ID'; // Also FK to SALLE (ISA)
    public    $timestamps = false;
    public    $incrementing = false; // PK is shared with SALLE, not auto-increment here

    protected $fillable = [
        'SALLE_ID',
        'PED_ID',
        'ZYR_LLOJI',
        'ZYR_PERSHKRIM',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    // ISA parent
    public function salla()
    {
        return $this->belongsTo(Salle::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function pedagogi()
    {
        return $this->belongsTo(Pedagog::class, 'PED_ID', 'PED_ID');
    }
}
