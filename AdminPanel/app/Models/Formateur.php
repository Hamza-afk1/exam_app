<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Formateur extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'role',
        'picture'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'role' => 'formateur',
    ];

    public function groupes()
    {
        return $this->hasMany(Groupe::class, 'formateur_id');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'formateur_id');
    }

    public function examens()
    {
        return $this->hasManyThrough(Examen::class, Groupe::class);
    }
}