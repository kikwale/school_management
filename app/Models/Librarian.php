<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    use HasFactory;
    
    protected $fillable =[
        'users_id',
        'schools_id',
        'salary',
        'edu_level'
    ];
}
