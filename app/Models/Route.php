<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Booking;

class Route extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function getBus()
    {
        return $this->hasMany(Bus::class, 'route_id');
    }
    public function getBusStop()
    {
        return $this->hasMany(BusStop::class, 'route_id');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class, 'route_id');
    }
}
