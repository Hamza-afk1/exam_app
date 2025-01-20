<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    protected $table = 'stagiaires'; // Ensure this matches the table name in the DB
    protected $guarded = [];
}
