<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'bicycle_id',
        'start_time',
        'end_time',
        'status',
        'actual_start_time',
        'actual_end_time',
        'feedback',
        'rating'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'actual_start_time' => 'datetime',
        'actual_end_time' => 'datetime',
        'rating' => 'integer'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_IN_USE = 'in_use';
    const STATUS_RETURNED = 'returned';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bicycle()
    {
        return $this->belongsTo(Bicycle::class);
    }
}