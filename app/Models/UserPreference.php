<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'age',
        'height',
        'marital_status',
        'mother_tongue',
        'physical_status',
        'eating_habits',
        'smoking_habits',
        'drinking_habits',
        'religion',
        'community',
        'caste',
        'star',
        'dosh',
        'education_category',
        'employed_in',
        'occupation',
        'annual_income',
        'country',
        'state',
        'city',
        'special_preference'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
