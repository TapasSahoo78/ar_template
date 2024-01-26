<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocuments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'id_file_type',
        'id_file',
        'id_status',
        'photo_file',
        'photo_status',
        'salary_file',
        'salary_status'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
