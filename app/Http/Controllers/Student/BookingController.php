<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Bicycle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BicycleTimeSlot;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
                          ->with('bicycle')
                          ->orderBy('start_time', 'desc')
                          ->get();

        return view('student.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $bicycles = Bicycle::where('status', 'available')->get();
        return view('student.bookings.create', compact('bicycles'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addDays(2)->format('Y-m-d')
            ],
            'time_slot' => 'required|date_format:H:i'
        ]);

        $date = $request->date;
        $timeSlot = $request->time_slot;
        
        // Calculate end time (1 hour after start time)
        $startTime = Carbon::parse($date . ' ' . $timeSlot);
        $endTime = $startTime->copy()->addHour();

        // Get all bicycles that are not booked for this time slot
        $availableBicycles = Bicycle::whereDoesntHave('timeSlots', function($query) use ($date, $startTime, $endTime) {
            $query->where('date', $date)
                  ->where('status', 'booked')
                  ->where(function($q) use ($startTime, $endTime) {
                      $q->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime]);
                  });
        })->where('status', 'available')
          ->get();

        return response()->json([
            'bicycles' => $availableBicycles->map(function($bicycle) {
                return [
                    'id' => $bicycle->id,
                    'name' => $bicycle->name,
                    'color' => $bicycle->color,
                    'bicycle_id' => $bicycle->bicycle_id
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bicycle_id' => 'required|exists:bicycles,id',
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addDays(2)->format('Y-m-d')
            ],
            'time_slot' => 'required|date_format:H:i'
        ]);

        $startTime = Carbon::parse($request->booking_date . ' ' . $request->time_slot);
        $endTime = $startTime->copy()->addHour();

        // Check daily booking limit (3 bicycles per day)
        $dailyBookingsCount = Booking::where('user_id', auth()->id())
            ->whereDate('start_time', $request->booking_date)
            ->whereIn('status', ['pending', 'in_use'])
            ->count();

        if ($dailyBookingsCount >= 3) {
            return back()->with('error', 'You have reached the maximum limit of 3 bicycle bookings for this day.');
        }

        // Check if bicycle is still available
        $bicycle = Bicycle::findOrFail($request->bicycle_id);
        if ($bicycle->status !== 'available') {
            return back()->with('error', 'This bicycle is no longer available.');
        }

        // Check for overlapping bookings
        $hasOverlap = BicycleTimeSlot::where('bicycle_id', $request->bicycle_id)
            ->where('date', $request->booking_date)
            ->where('status', 'booked')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })->exists();

        if ($hasOverlap) {
            return back()->with('error', 'This bicycle is already booked for the selected time slot.');
        }

        // Begin transaction to ensure both records are created
        DB::beginTransaction();

        try {
            // Create time slot booking
            $timeSlot = BicycleTimeSlot::create([
                'bicycle_id' => $request->bicycle_id,
                'date' => $request->booking_date,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'booked'
            ]);

            // Create booking
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'bicycle_id' => $request->bicycle_id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => Booking::STATUS_PENDING
            ]);

            DB::commit();

            // Redirect to the booking management page
            return redirect()->route('student.bookings.index')
                ->with('success', 'Booking created successfully. You can view your booking in the list below.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'An error occurred while creating your booking. Please try again.');
        }
    }

    public function manageRide(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('student.bookings.manage-ride', compact('booking'));
    }

    public function startRide(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== Booking::STATUS_PENDING) {
            return response()->json([
                'error' => 'You are not authorized to start this ride.'
            ], 403);
        }

        // Check if within the booked time slot
        $now = now();
        if ($now->lt($booking->start_time)) {
            return response()->json([
                'error' => 'You cannot start the ride before the scheduled time.'
            ], 400);
        }

        if ($now->gt($booking->end_time)) {
            return response()->json([
                'error' => 'This booking has expired.'
            ], 400);
        }

        try {
            $booking->update([
                'status' => Booking::STATUS_IN_USE,
                'actual_start_time' => $now
            ]);

            $booking->bicycle->update(['status' => 'in_use']);

            return response()->json([
                'success' => true,
                'message' => 'Ride started successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to start the ride. Please try again.'
            ], 500);
        }
    }

    public function completeRide(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== Booking::STATUS_IN_USE) {
            abort(403);
        }

        $now = now();
        $booking->update([
            'status' => Booking::STATUS_RETURNED,
            'actual_end_time' => $now
        ]);

        $booking->bicycle->update(['status' => 'available']);

        // Update time slot status
        BicycleTimeSlot::where('bicycle_id', $booking->bicycle_id)
            ->where('date', $booking->start_time->format('Y-m-d'))
            ->where('start_time', $booking->start_time)
            ->where('end_time', $booking->end_time)
            ->update(['status' => 'completed']);

        return back()->with('success', 'Ride completed successfully.');
    }

    public function submitFeedback(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== Booking::STATUS_RETURNED) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|max:500'
        ]);

        $booking->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }

    public function cancel(Booking $booking)
    {
        // Check if booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if booking can be cancelled
        if ($booking->status !== 'active') {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        // Delete the corresponding time slot
        BicycleTimeSlot::where('bicycle_id', $booking->bicycle_id)
            ->where('date', $booking->start_time->format('Y-m-d'))
            ->where('start_time', $booking->start_time)
            ->where('end_time', $booking->end_time)
            ->where('status', 'booked')
            ->delete();

        // Cancel booking
        $booking->update(['status' => 'cancelled']);

        // Update bicycle status
        $booking->bicycle->update(['status' => 'available']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}