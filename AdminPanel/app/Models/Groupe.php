<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $table = 'groupes'; // Nom de la table en base de données
    protected $fillable = ['nom']; // Champs qui peuvent être remplis
}
