<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'schools_id',
        'darasas_id',
        'students_id',
        'isCurrent'
    ];
}
