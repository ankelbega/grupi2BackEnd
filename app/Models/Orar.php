<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orar extends Model
{
    protected $table      = 'ORAR';
    protected $primaryKey = 'ORAR_ID';
    public    $timestamps = false;

    protected $fillable = [
        'SEK_ID',
        'ORAR_DITA',
        'ORAR_ORA_FILL',
        'ORAR_ORA_MBA',
        'SALLE_ID',
        'ORAR_LLOJI',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function seksioni()
    {
        return $this->belongsTo(Seksion::class, 'SEK_ID', 'SEK_ID');
    }

    public function salla()
    {
        return $this->belongsTo(Salle::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function prezencat()
    {
        return $this->hasMany(Prezence::class, 'ORAR_ID', 'ORAR_ID');
    }
}
