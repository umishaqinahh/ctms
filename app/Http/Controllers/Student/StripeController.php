<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;  // Add this line
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Payment;
use App\Models\Booking;

class StripeController extends Controller
{
    public function checkout()
    {
        return view('stripe.checkout');
    }

    public function session(Booking $booking)
    {
        // Remove this line since we're using route model binding
        // $booking = Booking::findOrFail($request->booking_id);
        
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[                
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => 'Bicycle Booking - ' . $booking->bicycle->name,
                        'description' => 'Booking for ' . $booking->start_time->format('Y-m-d H:i:s'),
                    ],
                    'unit_amount' => 300, // RM3.00 in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('student.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('student.stripe.cancel'),
            'metadata' => [
                'booking_id' => $booking->id
            ]
        ]);

        // Create payment record
        Payment::create([
            'user_id' => auth()->id(),
            'booking_id' => $booking->id,
            'amount' => 300, // RM3.00 in cents
            'currency' => 'myr',
            'payment_status' => 'pending',
            'payment_method' => 'stripe',
            'stripe_session_id' => $session->id
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $payment = Payment::where('stripe_session_id', $request->session_id)->firstOrFail();
        $payment->update([
            'payment_status' => 'succeeded',
            'paid_at' => now()
        ]);

        return redirect()->route('student.bookings.index')
            ->with('success', 'Payment successful! Your booking has been confirmed.');
    }

    public function cancel()
    {
        return redirect()->route('student.bookings.index')
            ->with('error', 'Payment was cancelled.');
    }
}