<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;
    protected $fillable = [
        'schools_id',
        'darasas_id',
        'fee_amount',
        'year',
        'description',
        'students_id',
        'isCurrent'
    ];
}
