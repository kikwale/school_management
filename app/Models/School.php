<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'school_name',
        'country',
        'region',
        'district',
        'street',
        'scool_number'
    ];
}
