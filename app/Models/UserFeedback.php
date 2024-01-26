<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'rating',
        'comment',
        'is_active'
    ];

    public function getUser() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
