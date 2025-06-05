@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Add New Bicycle</h2>
            <p class="mt-1 text-sm text-gray-600">Create a new bicycle with a unique identifier</p>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('admin.bicycles.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="bicycle_id" class="block text-sm font-medium text-gray-700">Bicycle ID</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="bicycle_id" id="bicycle_id" 
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md border border-gray-300 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                                   @error('bicycle_id') border-red-500 @enderror"
                            value="{{ old('bicycle_id') }}"
                            placeholder="Auto-generated if left empty"
                        >
                    </div>
                    @error('bicycle_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">4-digit unique identifier (e.g., 9452). Will be auto-generated if not provided.</p>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" 
                            class="block w-full px-3 py-2 rounded-md border border-gray-300 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                                   @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" required>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                    <div class="mt-1">
                        <input type="text" name="color" id="color" 
                            class="block w-full px-3 py-2 rounded-md border border-gray-300 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                                   @error('color') border-red-500 @enderror"
                            value="{{ old('color') }}" required>
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-1">
                        <select id="status" name="status" 
                            class="block w-full px-3 py-2 rounded-md border border-gray-300 
                                   focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                                   @error('status') border-red-500 @enderror" required>
                            <option value="available">Available</option>
                            <option value="in_use">In Use</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.bicycles.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Bicycle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection