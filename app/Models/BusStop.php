<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusStop extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function route()
    {
        return $this->hasOne(Route::class, 'id', 'route_id');
    }

    public function timeTableStops()
    {
        return $this->hasMany(TimeTableStop::class, 'bus_stop_id');
    }
}
