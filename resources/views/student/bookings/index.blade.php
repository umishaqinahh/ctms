@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold">My Bookings</h2>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bicycle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($bookings as $booking)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->bicycle->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->start_time->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->end_time->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $booking->status === 'in_use' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $booking->status === 'returned' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if(in_array($booking->status, ['pending', 'in_use']))
                            <a href="{{ route('student.bookings.manage-ride', $booking) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-4">Manage Ride</a>
                        @endif
                        
                        @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('student.bookings.cancel', $booking) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-red-600 hover:text-red-900">Cancel</button>
                            </form>
                        @endif

                        @if($booking->status === 'returned' && !$booking->feedback)
                            <a href="{{ route('student.bookings.manage-ride', $booking) }}" 
                               class="text-green-600 hover:text-green-900">Leave Feedback</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection