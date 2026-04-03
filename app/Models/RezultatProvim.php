<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RezultatProvim extends Model
{
    protected $table      = 'REZULTAT_PROVIM';
    protected $primaryKey = 'REZ_ID';
    public    $timestamps = false;

    protected $fillable = [
        'PRV_ID',
        'STD_ID',
        'REZ_PIKE',
        'REZ_MUNGOI',
        'REZ_VEREJTJE',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function provimi()
    {
        return $this->belongsTo(Provim::class, 'PRV_ID', 'PRV_ID');
    }

    public function studenti()
    {
        return $this->belongsTo(Student::class, 'STD_ID', 'STD_ID');
    }
}
