<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $table      = 'SALLE';
    protected $primaryKey = 'SALLE_ID';
    public    $timestamps = false;

    protected $fillable = [
        'SALLE_EM',
        'SALLE_KAP',
        'FAK_ID',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function fakulteti()
    {
        return $this->belongsTo(Fakultet::class, 'FAK_ID', 'FAK_ID');
    }

    // ISA subtypes (disjoint total)
    public function auditori()
    {
        return $this->hasOne(Auditor::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function zyra()
    {
        return $this->hasOne(Zyre::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function seksionet()
    {
        return $this->hasMany(Seksion::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function oraret()
    {
        return $this->hasMany(Orar::class, 'SALLE_ID', 'SALLE_ID');
    }

    public function provimet()
    {
        return $this->hasMany(Provim::class, 'SALLE_ID', 'SALLE_ID');
    }
}
