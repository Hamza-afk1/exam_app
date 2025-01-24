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
        'description',
        'temps_limite',
        'question_limit'
    ];

    public function groupe()
{
    return $this->belongsTo(Groupe::class);
}

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_id');
    }
}