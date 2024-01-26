<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'education_category' ,
        'college',
        'occupation',
        'organization',
        'employed_in',
        'annual_income',

    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
