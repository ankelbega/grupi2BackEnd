<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regjistrim extends Model
{
    protected $table      = 'REGJISTRIM';
    protected $primaryKey = 'REGJ_ID';
    public    $timestamps = false;

    protected $fillable = [
        'STD_ID',
        'SEK_ID',
        'SEM_ID',
        'REGJ_DT',
        'REGJ_STATUS',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function studenti()
    {
        return $this->belongsTo(Student::class, 'STD_ID', 'STD_ID');
    }

    public function seksioni()
    {
        return $this->belongsTo(Seksion::class, 'SEK_ID', 'SEK_ID');
    }

    public function semestri()
    {
        return $this->belongsTo(Semestri::class, 'SEM_ID', 'SEM_ID');
    }

    public function prezencat()
    {
        return $this->hasMany(Prezence::class, 'REGJ_ID', 'REGJ_ID');
    }

    public function notat()
    {
        return $this->hasMany(Note::class, 'REGJ_ID', 'REGJ_ID');
    }
}
