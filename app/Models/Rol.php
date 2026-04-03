<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table      = 'ROL';
    protected $primaryKey = 'ROL_ID';
    public    $timestamps = false;

    protected $fillable = [
        'ROL_EMER',
        'ROL_PERSHKRIM',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function perdoruesRol()
    {
        return $this->hasMany(PerdoruesRol::class, 'ROL_ID', 'ROL_ID');
    }

    public function perdoruesit()
    {
        return $this->belongsToMany(User::class, 'PERDORUES_ROL', 'ROL_ID', 'PERD_ID')
                    ->withPivot(['PERD_ROL_DATA', 'PERD_ROL_AKTIV']);
    }
}
