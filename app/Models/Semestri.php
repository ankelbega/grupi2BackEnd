<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestri extends Model
{
    // Table name uses Albanian special character Ë
    protected $table      = 'SEMESTËR';
    protected $primaryKey = 'SEM_ID';
    public    $timestamps = false;

    protected $fillable = [
        'VIT_ID',
        'SEM_NR',
        'SEM_DT_FILL',
        'SEM_DT_MBR',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function vitiAkademik()
    {
        return $this->belongsTo(VitAkademik::class, 'VIT_ID', 'VIT_ID');
    }

    public function seksionet()
    {
        return $this->hasMany(Seksion::class, 'SEM_ID', 'SEM_ID');
    }

    public function regjistrimet()
    {
        return $this->hasMany(Regjistrim::class, 'SEM_ID', 'SEM_ID');
    }

    public function provimet()
    {
        return $this->hasMany(Provim::class, 'SEM_ID', 'SEM_ID');
    }
}
