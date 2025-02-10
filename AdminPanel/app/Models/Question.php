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
    ];

    // Relation avec le modèle Examen
    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    // Relation avec le modèle Choice
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}

