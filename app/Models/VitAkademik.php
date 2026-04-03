<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitAkademik extends Model
{
    protected $table      = 'VIT_AKADEMIK';
    protected $primaryKey = 'VIT_ID';
    public    $timestamps = false;

    protected $fillable = [
        'VIT_EM',
        'VIT_DT_FILL',
        'VIT_DT_MBR',
        'VIT_STATUS',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function semestrat()
    {
        return $this->hasMany(Semestri::class, 'VIT_ID', 'VIT_ID');
    }
}
