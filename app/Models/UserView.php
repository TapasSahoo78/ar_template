<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserView extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'viewed_user_id',
        'visit_count',
        'is_active'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getViewedUser()
    {
        return $this->belongsTo(User::class, 'viewed_user_id');
    }
}
