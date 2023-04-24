<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsRoutine extends Model
{
    use HasFactory;
    protected $fillable = ['schools_id', 'starting_time', 'ending_time', 'activity', 'description'];
}
