<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReligiousInformation extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'caste',
            'gotra',
            'zodiac',
            'star',
            'rassi',
            'dosh',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
