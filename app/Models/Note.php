<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table      = 'NOTE';
    protected $primaryKey = 'NOTE_ID';
    public    $timestamps = false;

    protected $fillable = [
        'REGJ_ID',
        'PERD_ID',
        'NOTE_NDERMJET',
        'NOTE_FINALE',
        'NOTE_DETYRE',
        'NOTE_TOTALE',
        'NOTE_SHKRONJE',
        'NOTE_GPA',
        'NOTE_DATA',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function regjistrim()
    {
        return $this->belongsTo(Regjistrim::class, 'REGJ_ID', 'REGJ_ID');
    }

    public function perdoruesi()
    {
        return $this->belongsTo(User::class, 'PERD_ID', 'PERD_ID');
    }
}
