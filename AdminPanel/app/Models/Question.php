<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'examen_id',
        'exam_question',
        'question_type',
        'open_answer'
    ];

    // Relation avec le modèle Examen
    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }

    // Relation avec le modèle QuestionChoice
    public function choices()
    {
        return $this->hasMany(QuestionChoice::class);
    }
}

