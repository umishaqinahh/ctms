<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BicycleTimeSlot extends Model
{
    protected $fillable = ['bicycle_id', 'date', 'start_time', 'end_time', 'status'];

    public function bicycle()
    {
        return $this->belongsTo(Bicycle::class);
    }
}
