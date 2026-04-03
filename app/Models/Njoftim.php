<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Njoftim extends Model
{
    protected $table      = 'NJOFTIM';
    protected $primaryKey = 'NJF_ID';
    public    $timestamps = false;

    protected $fillable = [
        'PERD_ID',
        'DEP_ID',
        'NJF_TITULLI',
        'NJF_PERMBAJTJA',
        'NJF_AUDIENCE',
        'NJF_DATA_PUB',
        'NJF_DATA_SKA',
        'NJF_FIKSUAR',
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
}
