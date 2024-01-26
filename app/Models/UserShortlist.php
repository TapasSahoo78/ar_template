<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShortlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shortlisted_user_id',
        'is_active'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getShortlistUser()
    {
        return $this->belongsTo(User::class, 'shortlisted_user_id');
    }
}
