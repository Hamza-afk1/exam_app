<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'groupe'
    ];

    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe', 'nom');  // Relation basée sur le nom du groupe
    }
}