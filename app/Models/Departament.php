<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    protected $table      = 'DEPARTAMENT';
    protected $primaryKey = 'DEP_ID';
    public    $timestamps = false;

    protected $fillable = [
        'DEP_EM',
        'FAK_ID',
        'PERD_ID',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function fakulteti()
    {
        return $this->belongsTo(Fakultet::class, 'FAK_ID', 'FAK_ID');
    }

    public function perdoruesi()
    {
        return $this->belongsTo(User::class, 'PERD_ID', 'PERD_ID');
    }

    public function programetStudimit()
    {
        return $this->hasMany(ProgramStudimi::class, 'DEP_ID', 'DEP_ID');
    }

    public function pedagoget()
    {
        return $this->hasMany(Pedagog::class, 'DEP_ID', 'DEP_ID');
    }

    public function studentet()
    {
        return $this->hasMany(Student::class, 'DEP_ID', 'DEP_ID');
    }

    public function lendet()
    {
        return $this->hasMany(Lende::class, 'DEP_ID', 'DEP_ID');
    }

    public function stafi()
    {
        return $this->hasMany(Staf::class, 'STF_DEP_ID', 'DEP_ID');
    }

    public function njoftimet()
    {
        return $this->hasMany(Njoftim::class, 'DEP_ID', 'DEP_ID');
    }
}
