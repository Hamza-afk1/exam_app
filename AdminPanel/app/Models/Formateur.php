<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    protected $table = 'formateurs';  // Make sure the table name matches the one in the DB
    protected $guarded = [];
}
