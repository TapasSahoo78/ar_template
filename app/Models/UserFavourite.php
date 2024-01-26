<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavourite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'favourite_user_id',
        'is_active'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getFavouriteUser()
    {
        return $this->belongsTo(User::class, 'favourite_user_id');
    }
}
