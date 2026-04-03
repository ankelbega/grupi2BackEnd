<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerdoruesRol extends Model
{
    protected $table      = 'PERDORUES_ROL';
    protected $primaryKey = 'PERD_ROL_ID';
    public    $timestamps = false;

    protected $fillable = [
        'PERD_ID',
        'ROL_ID',
        'PERD_ROL_DATA',
        'PERD_ROL_AKTIV',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function perdoruesi()
    {
        return $this->belongsTo(User::class, 'PERD_ID', 'PERD_ID');
    }

    public function roli()
    {
        return $this->belongsTo(Rol::class, 'ROL_ID', 'ROL_ID');
    }
}
