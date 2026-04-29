@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('services.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors font-medium text-sm">
            &larr; Back
        </a>
        <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
            Edit Service
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="salon-form-container">
                <form action="{{ route('services.update', $service) }}" method="POST" class="p-8 space-y-6">
                    @csrf @method('PUT')

                    <div class="space-y-1">
                        <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300 salon-label">
                            Service Name
                        </label>
                        <input id="name" name="name" type="text"
                               value="{{ old('name', $service->name) }}" required placeholder="e.g. Deluxe Haircut"
                               class="salon-input block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('name')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="description" class="block font-medium text-sm text-gray-700 dark:text-gray-300 salon-label">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  placeholder="Provide details about the service..."
                                  class="salon-input block w-full resize-none border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1 relative">
                            <label for="price" class="block font-medium text-sm text-gray-700 dark:text-gray-300 salon-label">
                                Price (PHP)
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-semibold">&#8369;</span>
                                <input id="price" name="price" type="number" step="0.01" min="0"
                                       value="{{ old('price', $service->price) }}" required placeholder="0.00"
                                       class="salon-input block w-full pl-8 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            @error('price')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="duration_minutes" class="block font-medium text-sm text-gray-700 dark:text-gray-300 salon-label">
                                Duration (minutes)
                            </label>
                            <div class="relative">
                                <input id="duration_minutes" name="duration_minutes" type="number" min="1"
                                       value="{{ old('duration_minutes', $service->duration_minutes) }}" required placeholder="60"
                                       class="salon-input block w-full pr-16 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 text-sm">min</span>
                            </div>
                            @error('duration_minutes')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4 pb-2">
                        <label for="is_active" class="salon-toggle-label p-4 w-full md:w-auto group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                       class="salon-toggle-input peer sr-only"
                                       {{ old('_token') ? (old('is_active') ? 'checked' : '') : ($service->is_active ? 'checked' : '') }}>
                                <div class="salon-toggle-track"></div>
                                <div class="salon-toggle-thumb"></div>
                            </div>
                            <span class="ml-3 font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-700 dark:group-hover:text-indigo-400 transition-colors">Service is Active</span>
                        </label>
                    </div>

                    <div class="salon-form-actions">
                        <button type="submit" class="salon-btn-primary px-6 py-3">
                            Update Service
                        </button>
                        <a href="{{ route('services.index') }}" class="salon-btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
