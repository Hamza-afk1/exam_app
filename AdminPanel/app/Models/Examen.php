<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'groupe_id',
        'cou_id',
        'description',
        'temps_limite',
        'question_limit'
    ];

    // Define the relationship with the Cours model
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cou_id');
    }

    // Define the relationship with the Groupe model
    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }

    // Define the relationship with the Question model
    public function questions()
    {
        return $this->hasMany(Question::class, 'examen_id');
    }
    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }
}