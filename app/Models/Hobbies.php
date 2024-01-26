<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobbies extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hobbies',
        'music',
        'reading',
        'moving_and_tv_shows',
        'sports_and_fitness',
        'food',
        'spoken_languages',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
