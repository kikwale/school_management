<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Darasa extends Model
{
    use HasFactory;
    protected $fillable = [
        'schools_id',
        'name',
        'numeric_name',
        'level'
    ];
}
