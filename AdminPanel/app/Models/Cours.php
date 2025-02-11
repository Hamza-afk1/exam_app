<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    // Define any necessary relationships, fillable fields, etc.
    protected $fillable = ['name', 'description'];  // Add your actual fields

    public function examens()
    {
        return $this->hasMany(Examen::class);
    }
}
