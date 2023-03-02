<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wazazi extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'schools_id',
        'address',
        'work'
    ];
}
