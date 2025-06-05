<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Campus Transport Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-500">CT Rental</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div class="flex space-x-1">
                                <a href="{{ route('admin.users.index') }}" 
                                   class="text-gray-700 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-md transition duration-300">
                                   Users
                                </a>
                                <a href="{{ route('admin.bicycles.index') }}" 
                                   class="text-gray-700 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-md transition duration-300">
                                   Bicycles
                                </a>
                                <a href="{{ route('admin.reports.bookings') }}" 
                                   class="text-gray-700 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-md transition duration-300">
                                   Reports
                                </a>
                            </div>
                        @else
                            <div class="flex space-x-1">
                                <a href="{{ route('student.bookings.create') }}" 
                                   class="text-gray-700 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-md transition duration-300">
                                   Book a Bicycle
                                </a>
                                <a href="{{ route('student.bookings.index') }}" 
                                   class="text-gray-700 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-md transition duration-300">
                                   My Bookings
                                </a>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition duration-300">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-md transition duration-300">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition duration-300">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>