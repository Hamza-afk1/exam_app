<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'examen_id',
        'question',
        'type',
        'reponses',
        'reponse_correcte',
    ];

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }
}
