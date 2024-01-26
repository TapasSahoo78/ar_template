<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function getRoute(): BelongsTo
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function getDriver()
    {
        return $this->hasOne(Driver::class, 'bus_id');
    }
}
