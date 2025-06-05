@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Manage Ride</h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $booking->status === 'in_use' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $booking->status === 'returned' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Booking Details</h3>
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Bicycle</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->bicycle->name }} ({{ $booking->bicycle->bicycle_id }})</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Color</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->bicycle->color }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Scheduled Start</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->start_time->format('Y-m-d H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Scheduled End</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->end_time->format('Y-m-d H:i') }}</dd>
                    </div>
                </dl>
            </div>

            @if($booking->status === 'pending')
                <form id="startRideForm" method="POST" action="{{ route('student.bookings.start-ride', $booking) }}" class="mb-6">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Start Ride
                    </button>
                </form>
            @endif

            @if($booking->status === 'in_use')
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Ride in Progress</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Started at: {{ $booking->actual_start_time->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('student.bookings.complete-ride', $booking) }}" class="mb-6">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Complete Ride
                    </button>
                </form>
            @endif

            @if($booking->status === 'returned')
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Ride Summary</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Actual Start Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->actual_start_time->format('Y-m-d H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Actual End Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->actual_end_time->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                @if(!$booking->feedback)
                    <form method="POST" action="{{ route('student.bookings.submit-feedback', $booking) }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                            <select id="rating" name="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                <option value="4">⭐⭐⭐⭐ Very Good</option>
                                <option value="3">⭐⭐⭐ Good</option>
                                <option value="2">⭐⭐ Fair</option>
                                <option value="1">⭐ Poor</option>
                            </select>
                        </div>

                        <div>
                            <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                            <textarea id="feedback" name="feedback" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Share your experience..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Submit Feedback
                        </button>
                    </form>
                @else
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Your Feedback</h3>
                        <div class="mb-4">
                            <div class="text-yellow-400">
                                @for($i = 0; $i < $booking->rating; $i++)
                                    ⭐
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $booking->feedback }}</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Add SweetAlert2 CDN in the head section or before closing body tag -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('startRideForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (body.error) {
                Swal.fire({
                    title: 'Error',
                    text: body.error,
                    icon: 'error',
                    confirmButtonColor: '#3B82F6'
                });
            } else if (body.success) {
                Swal.fire({
                    title: 'Success',
                    text: body.message,
                    icon: 'success',
                    confirmButtonColor: '#3B82F6'
                }).then(() => {
                    window.location.reload();
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'An unexpected error occurred. Please try again.',
                icon: 'error',
                confirmButtonColor: '#3B82F6'
            });
        });
    });
</script>
@endsection