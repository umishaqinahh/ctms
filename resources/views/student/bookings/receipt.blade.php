@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-2xl font-bold">Payment Receipt</h2>
        <button onclick="window.print()" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-print"></i> Print
        </button>
    </div>

    <div class="p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Booking Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Booking ID</p>
                    <p class="font-medium">{{ $booking->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Bicycle</p>
                    <p class="font-medium">{{ $booking->bicycle->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Start Time</p>
                    <p class="font-medium">{{ $booking->start_time->format('Y-m-d H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">End Time</p>
                    <p class="font-medium">{{ $booking->end_time->format('Y-m-d H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status</p>
                    <p class="font-medium">{{ ucfirst($booking->status) }}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Payment Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Payment ID</p>
                    <p class="font-medium">{{ $booking->payment->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Amount</p>
                    <p class="font-medium">RM {{ number_format($booking->payment->amount / 100, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Method</p>
                    <p class="font-medium">{{ ucfirst($booking->payment->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Status</p>
                    <p class="font-medium">{{ ucfirst($booking->payment->payment_status) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Date</p>
                    <p class="font-medium">{{ $booking->payment->paid_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="text-center text-gray-500 text-sm mt-8">
            <p>Thank you for using our bicycle rental service!</p>
            <p>For any questions, please contact support.</p>
        </div>
    </div>
</div>
@endsection