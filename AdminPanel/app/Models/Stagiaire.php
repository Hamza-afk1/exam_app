<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'groupe_id',
        // ... other fillable fields
    ];

    // Define the relationship with Groupe
    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }
}