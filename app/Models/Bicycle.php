<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BicycleTimeSlot;

class Bicycle extends Model
{
    protected $fillable = ['bicycle_id', 'name', 'color', 'status'];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($bicycle) {
            // Generate a unique 4-digit ID if not provided
            if (!$bicycle->bicycle_id) {
                do {
                    $bicycle_id = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                } while (static::where('bicycle_id', $bicycle_id)->exists());
                
                $bicycle->bicycle_id = $bicycle_id;
            }
        });
    }

    public function timeSlots()
{
    return $this->hasMany(BicycleTimeSlot::class);
}

}