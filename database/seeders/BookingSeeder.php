<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Bicycle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users except admin
        $users = User::where('role', 'student')->get();
        $bicycles = Bicycle::all();
        
        // Create sample bookings
        foreach ($users as $user) {
            // Create 2 bookings for each user
            for ($i = 0; $i < 2; $i++) {
                $startTime = Carbon::now()->addDays(rand(1, 30))->setHour(rand(8, 17));
                $endTime = (clone $startTime)->addHours(rand(1, 3));
                
                Booking::create([
                    'user_id' => $user->id,
                    'bicycle_id' => $bicycles->random()->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => 'active'
                ]);
            }
        }
    }
}