@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gray-900 h-[600px]">
        <div class="absolute inset-0">
            <img src="{{ asset('images/bicycle-bg.gif') }}" alt="Bicycle riding background" class="w-full h-full object-cover opacity-70">
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Welcome to Campus Transport Rental</h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">Your convenient solution for getting around campus.</p>
            <p class="mt-4 text-xl text-gray-300">Only RM3 per hour!</p>
            <div class="mt-10 flex space-x-4">
                @auth
                    @if(auth()->user()->role === 'student')
                        <a href="{{ route('student.bookings.create') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-md text-lg font-medium transition duration-300">
                            Book Now
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-md text-lg font-medium transition duration-300">
                            Get Started
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-md text-lg font-medium transition duration-300">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-24 bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Why Choose Campus Transport Rental</h2>
                <p class="mt-4 text-xl text-gray-300">Everything you need for convenient campus transportation in one place.</p>
                <p class="mt-2 text-lg text-blue-400 font-semibold">Affordable rates at only RM3 per hour!</p>
            </div>

            <div class="mt-20 grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Easy Booking -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Easy Booking Process</h3>
                    <p class="mt-2 text-base text-gray-500">Book your bicycle with just a few clicks and start riding immediately.</p>
                </div>

                <!-- Flexible Schedule -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Flexible Schedule</h3>
                    <p class="mt-2 text-base text-gray-500">Choose your rental duration and return time that fits your schedule.</p>
                </div>

                <!-- Well-Maintained Bicycles -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Quality Bicycles</h3>
                    <p class="mt-2 text-base text-gray-500">All our bicycles are regularly maintained and kept in excellent condition.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('title', 'Welcome')