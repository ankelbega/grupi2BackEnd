<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laborator extends Model
{
    protected $table      = 'LABORATOR';
    protected $primaryKey = 'SALLE_ID'; // Also FK to AUDITOR (ISA from AUDITOR)
    public    $timestamps = false;
    public    $incrementing = false; // PK is shared with AUDITOR, not auto-increment here

    protected $fillable = [
        'SALLE_ID',
        'LAB_NR_KOMPJUTER',
        'LAB_SISTEMI_OPERATIV',
        'LAB_SOFTUERET',
        'LAB_PERGJEGJESI',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    // ISA parent (AUDITOR)
    public function auditori()
    {
        return $this->belongsTo(Auditor::class, 'SALLE_ID', 'SALLE_ID');
    }
}
