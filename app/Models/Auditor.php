<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditor extends Model
{
    protected $table      = 'AUDITOR';
    protected $primaryKey = 'SALLE_ID'; // Also FK to SALLE (ISA)
    public    $timestamps = false;
    public    $incrementing = false; // PK is shared with SALLE, not auto-increment here

    protected $fillable = [
        'SALLE_ID',
        'AUD_KA_PROJEKTOR',
        'AUD_LLOJI',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    // ISA parent
    public function salla()
    {
        return $this->belongsTo(Salle::class, 'SALLE_ID', 'SALLE_ID');
    }

    // ISA child (overlap partial)
    public function laboratori()
    {
        return $this->hasOne(Laborator::class, 'SALLE_ID', 'SALLE_ID');
    }
}
