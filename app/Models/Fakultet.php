<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultet extends Model
{
    protected $table      = 'FAKULTET';
    protected $primaryKey = 'FAK_ID';
    public    $timestamps = false;

    protected $fillable = [
        'FAK_EM',
        'PERD_ID',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function perdoruesi()
    {
        return $this->belongsTo(User::class, 'PERD_ID', 'PERD_ID');
    }

    public function departamentet()
    {
        return $this->hasMany(Departament::class, 'FAK_ID', 'FAK_ID');
    }

    public function sallet()
    {
        return $this->hasMany(Salle::class, 'FAK_ID', 'FAK_ID');
    }
}
