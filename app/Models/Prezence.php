<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prezence extends Model
{
    protected $table      = 'PREZENCE';
    protected $primaryKey = 'PREZ_ID';
    public    $timestamps = false;

    protected $fillable = [
        'REGJ_ID',
        'ORAR_ID',
        'PREZ_DATA',
        'PREZ_STATUS',
        'PREZ_ARSYE',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function regjistrim()
    {
        return $this->belongsTo(Regjistrim::class, 'REGJ_ID', 'REGJ_ID');
    }

    public function orari()
    {
        return $this->belongsTo(Orar::class, 'ORAR_ID', 'ORAR_ID');
    }
}
