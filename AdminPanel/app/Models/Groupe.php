<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = [
        'name',
        'formateur_id',
        // ... other fillable fields
    ];

    // Define the relationship with Stagiaire
    public function stagiaires()
    {
        return $this->hasMany(Stagiaire::class, 'groupe_id');
    }

    // Define the relationship with Formateur
    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    // Add method to get total stagiaires count
    public function getStagiairesCountAttribute()
    {
        return $this->stagiaires()->count();
    }

    public function scopeForFormateur($query, $formateurId)
    {
        return $query->where('formateur_id', $formateurId);
    }

    // Add this method to get all students count
    public function getTotalStudentsAttribute()
    {
        return $this->stagiaires()->count();
    }
}