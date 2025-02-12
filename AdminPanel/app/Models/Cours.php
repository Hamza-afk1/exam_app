<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    // Define any necessary relationships, fillable fields, etc.
    protected $fillable = [
        'titre',
        'description'
    ];
    protected $table = 'cours'; // or 'courses' depending on your table name

    public function examens()
    {
        return $this->hasMany(Examen::class, 'cou_id');
    }
}
