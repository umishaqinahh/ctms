@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- User Management Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">User Management</h3>
                            <p class="text-sm text-gray-500">Manage system users and their roles</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                            Manage Users →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bicycle Management Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Bicycle Management</h3>
                            <p class="text-sm text-gray-500">Manage bicycle inventory and status</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.bicycles.index') }}" class="text-green-500 hover:text-green-700 font-medium">
                            Manage Bicycles →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Booking Reports Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Booking Reports</h3>
                            <p class="text-sm text-gray-500">View and analyze booking statistics</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.reports.bookings') }}" class="text-purple-500 hover:text-purple-700 font-medium">
                            View Reports →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection