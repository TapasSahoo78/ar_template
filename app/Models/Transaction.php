<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function passCodePlan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}



// transaction_no
