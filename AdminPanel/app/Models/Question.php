<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions'; // Explicitly set the table name

    protected $fillable = [
        'examen_id',
        'exam_answer',
        'exam_question',
        'exam_ch1',
        'exam_ch2',
        'exam_ch3',
        'exam_ch4',
    ];

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }
}
