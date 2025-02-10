<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'duree',
        'formateur_id'
    ];

    public function examens()
    {
        return $this->hasMany(Examen::class, 'cou_id');
    }

    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }
}