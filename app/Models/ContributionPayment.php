<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_contributions_id',
        'schools_id',
        'methode',
        'description',
        'methode_name',
        'number',
        'amount',
        'date',
        'description'
    ];
}
