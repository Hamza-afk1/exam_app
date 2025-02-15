<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    // Define any necessary relationships, fillable fields, etc.
    protected $fillable = [
        'title',
        'description',
        'formateur_id',
        'groupe_id',
        // ... other fillable fields
    ];

    protected $table = 'cours'; // or 'courses' depending on your table name

    public function examens()
    {
        return $this->hasMany(Examen::class, 'cou_id');
    }
    public function formateur()
    {
        return $this->belongsTo(Formateur::class, 'formateur_id');
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }
}
