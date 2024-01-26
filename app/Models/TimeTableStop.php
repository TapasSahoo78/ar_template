<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTableStop extends Model
{
    use HasFactory;
    protected $guarded  = [];

    public function getRoute()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
    public function getBus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
    public function getBusStop()
    {
        return $this->belongsTo(BusStop::class, 'bus_stop_id');
    }
}
