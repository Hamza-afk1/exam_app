<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'groupe_id',
        'description',
        'temps_limite',
        'question_limit',
        
    ];
        public function questions()
        {
            return $this->hasMany(Question::class);
        }
        
    
        // Si vous avez une relation avec le modèle Course, définissez-la ici
        public function course()
        {
            return $this->belongsTo(Course::class); // Assurez-vous que la clé étrangère est correcte
        }
    }




