@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl rounded-xl">
            <div class="p-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Confirm Payment</h2>
                
                <div class="space-y-6">
                    <div class="border-b pb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Booking Details</h3>
                        <div class="mt-4 space-y-2">
                            <p><span class="text-gray-600">Bicycle:</span> {{ $booking->bicycle->name }}</p>
                            <p><span class="text-gray-600">Date:</span> {{ $booking->start_time->format('Y-m-d') }}</p>
                            <p><span class="text-gray-600">Time:</span> {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="border-b pb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Payment Summary</h3>
                        <div class="mt-4">
                            <p class="flex justify-between items-center text-lg">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-semibold">RM 3.00</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <form action="{{ route('student.stripe.session', $booking) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-200 ease-in-out hover:scale-105 flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Proceed to Payment</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection