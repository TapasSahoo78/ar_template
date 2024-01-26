<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $guarded  = [];


    public function getBus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
