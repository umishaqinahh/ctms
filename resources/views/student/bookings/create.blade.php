@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="p-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Book a Bicycle</h2>
                    
                    <div class="space-y-8">
                        <!-- Date Selection -->
                        <!-- Date Selection -->
                        <div class="relative">
                            <label for="booking_date" class="block text-sm font-semibold text-gray-700 mb-2">Select Date</label>
                            <input type="date" id="booking_date" required
                                min="{{ date('Y-m-d') }}"
                                max="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        </div>

                        <!-- Time Slot Selection -->
                        <div class="relative">
                            <label for="time_slot" class="block text-sm font-semibold text-gray-700 mb-2">Select Time Slot</label>
                            <div class="relative">
                                <select id="time_slot" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition duration-200 bg-white">
                                    <option value="">Choose a time slot</option>
                                    <option value="08:00">8:00 AM - 9:00 AM</option>
                                    <option value="09:00">9:00 AM - 10:00 AM</option>
                                    <option value="10:00">10:00 AM - 11:00 AM</option>
                                    <option value="11:00">11:00 AM - 12:00 PM</option>
                                    <option value="12:00">12:00 PM - 1:00 PM</option>
                                    <option value="13:00">1:00 PM - 2:00 PM</option>
                                    <option value="14:00">2:00 PM - 3:00 PM</option>
                                    <option value="15:00">3:00 PM - 4:00 PM</option>
                                    <option value="16:00">4:00 PM - 5:00 PM</option>
                                    <option value="17:00">5:00 PM - 6:00 PM</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Check Availability Button -->
                        <div class="flex justify-center">
                            <button type="button" id="check_availability" 
                                    class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-200 ease-in-out hover:scale-105 flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>Check Availability</span>
                            </button>
                        </div>

                        <!-- Loading Indicator -->
                        <div id="loading_indicator" class="hidden flex justify-center items-center space-x-2">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                            <span class="text-gray-600">Checking availability...</span>
                        </div>

                        <!-- Available Bicycles Section -->
                        <div id="available_bicycles" class="hidden space-y-6">
                            <h3 class="text-xl font-bold text-gray-900 border-b pb-2">Available Bicycles</h3>
                            <form method="POST" action="{{ route('student.bookings.store') }}" class="space-y-6">
                                @csrf
                                <input type="hidden" name="booking_date" id="form_booking_date">
                                <input type="hidden" name="time_slot" id="form_time_slot">
                                
                                <div id="bicycle_list" class="grid gap-4"></div>
                                
                                <div class="flex justify-end pt-4 border-t">
                                    <button type="submit" 
                                            class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform transition-all duration-200 ease-in-out hover:scale-105 flex items-center space-x-2">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Confirm Booking</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('check_availability').addEventListener('click', function() {
            const date = document.getElementById('booking_date').value;
            const timeSlot = document.getElementById('time_slot').value;
            const loadingIndicator = document.getElementById('loading_indicator');
            const availableBicycles = document.getElementById('available_bicycles');

            if (!date || !timeSlot) {
                Swal.fire({
                    title: 'Required Fields',
                    text: 'Please select both date and time slot',
                    icon: 'warning',
                    confirmButtonColor: '#3B82F6'
                });
                return;
            }

            // Set form values
            document.getElementById('form_booking_date').value = date;
            document.getElementById('form_time_slot').value = timeSlot;

            // Show loading indicator
            loadingIndicator.classList.remove('hidden');
            availableBicycles.classList.add('hidden');

            // Fetch available bicycles
            fetch(`{{ route('student.bookings.check-availability') }}?date=${encodeURIComponent(date)}&time_slot=${encodeURIComponent(timeSlot)}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const bicycleList = document.getElementById('bicycle_list');
                    bicycleList.innerHTML = '';

                    if (data.error) {
                        Swal.fire({
                            title: 'Booking Limit Reached',
                            text: data.error,
                            icon: 'error',
                            confirmButtonColor: '#3B82F6'
                        });
                        loadingIndicator.classList.add('hidden');
                        return;
                    }

                    if (data.bicycles.length === 0) {
                        bicycleList.innerHTML = `
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No Bicycles Available</h3>
                                <p class="mt-1 text-sm text-gray-500">There are no bicycles available for this time slot.</p>
                            </div>
                        `;
                    } else {
                        bicycleList.innerHTML = `
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                ${data.bicycles.map(bicycle => `
                                    <div class="relative flex items-center p-4 border rounded-lg hover:border-blue-500 transition-colors duration-200">
                                        <input type="radio" name="bicycle_id" value="${bicycle.id}" required
                                               id="bicycle_${bicycle.id}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="bicycle_${bicycle.id}" class="ml-3 flex flex-col cursor-pointer">
                                            <span class="block text-sm font-medium text-gray-900">${bicycle.name}</span>
                                            <span class="block text-sm text-gray-500">${bicycle.color}</span>
                                        </label>
                                    </div>
                                `).join('')}
                            </div>
                        `;
                    }

                    loadingIndicator.classList.add('hidden');
                    availableBicycles.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to check bicycle availability. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#3B82F6'
                    });
                    loadingIndicator.classList.add('hidden');
                });
        });
    </script>
@endsection
