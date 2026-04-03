<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table      = 'STUDENT';
    protected $primaryKey = 'STD_ID';
    public    $timestamps = false;

    protected $fillable = [
        'PERD_ID',
        'DEP_ID',
        'STD_KOD',
        'STD_STATUSI',
        'STD_GPA',
        'STD_KREDIT_FITUAR',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function perdoruesi()
    {
        return $this->belongsTo(User::class, 'PERD_ID', 'PERD_ID');
    }

    public function departamenti()
    {
        return $this->belongsTo(Departament::class, 'DEP_ID', 'DEP_ID');
    }

    public function programet()
    {
        return $this->hasMany(StudentProgram::class, 'STD_ID', 'STD_ID');
    }

    public function regjistrimet()
    {
        return $this->hasMany(Regjistrim::class, 'STD_ID', 'STD_ID');
    }

    public function rezultatetProvimit()
    {
        return $this->hasMany(RezultatProvim::class, 'STD_ID', 'STD_ID');
    }
}
