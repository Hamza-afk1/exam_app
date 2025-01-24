<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    public $timestamps = false;  // Désactive les timestamps

    protected $fillable = [
        'nom'
    ];

    public function stagiaires()
    {
        return $this->hasMany(Stagiaire::class, 'groupe', 'nom');
    }
}