<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'cours'; // Indique que le modèle utilise la table 'cours'

    protected $fillable = ['titre', 'description'];

    // Définir les relations si nécessaire
    public function examens()
    {
        return $this->hasMany(Examen::class);
    }
}