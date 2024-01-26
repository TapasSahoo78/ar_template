<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_values',
        'family_status',
        'family_type',
        'family_status',
        'fathers_occupation',
        'mothers_occupation',
        'about_my_family',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
