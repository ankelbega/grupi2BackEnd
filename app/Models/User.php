<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table      = 'PERDORUES';
    protected $primaryKey = 'PERD_ID';
    public    $timestamps = false;

    protected $fillable = [
        'PERD_EMER',
        'PERD_MBIEMER',
        'PERD_EMAIL',
        'PERD_FJKALIM',
        'PERD_GJINI',
        'PERD_DTL',
        'PERD_ADRESE',
        'PERD_TEL',
        'PERD_TIPI',
        'PERD_AKTIV',
        'PERD_KRIJUAR',
    ];

    protected $hidden = ['PERD_FJKALIM'];

    protected function casts(): array
    {
        return [
            'PERD_FJKALIM' => 'hashed',
            'PERD_AKTIV'   => 'boolean',
        ];
    }

    // Tell Laravel Auth which column holds the hashed password
    public function getAuthPasswordName(): string
    {
        return 'PERD_FJKALIM';
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function pedagog()
    {
        return $this->hasOne(Pedagog::class, 'PERD_ID', 'PERD_ID');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'PERD_ID', 'PERD_ID');
    }

    public function staf()
    {
        return $this->hasOne(Staf::class, 'PERD_ID', 'PERD_ID');
    }

    public function rolet()
    {
        return $this->hasMany(PerdoruesRol::class, 'PERD_ID', 'PERD_ID');
    }

    public function fakultetet()
    {
        return $this->hasMany(Fakultet::class, 'PERD_ID', 'PERD_ID');
    }

    public function departamentet()
    {
        return $this->hasMany(Departament::class, 'PERD_ID', 'PERD_ID');
    }

    public function njoftimet()
    {
        return $this->hasMany(Njoftim::class, 'PERD_ID', 'PERD_ID');
    }

    public function notat()
    {
        return $this->hasMany(Note::class, 'PERD_ID', 'PERD_ID');
    }
}
