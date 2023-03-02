<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentContribution extends Model
{
    use HasFactory;
    protected $fillable = [
        'schools_id',
        'darasas_id',
        'contribution_amount',
        'year',
        'description',
        'students_id',
        'isCurrent'
    ];
}
