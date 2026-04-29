@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('appointments.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors font-medium text-sm">
            &larr; Back
        </a>
        <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
            New Appointment
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="salon-form-container">
                <form action="{{ route('appointments.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div class="space-y-1">
                        <label for="service_id" class="salon-label">Service</label>
                        <select id="service_id" name="service_id" required
                                class="salon-input px-4 py-2.5">
                            <option value="">-- Select a service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} &mdash; &#8369;{{ number_format($service->price, 2) }} ({{ $service->duration_label }})
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label for="customer_name" class="salon-label">Customer Name</label>
                            <input id="customer_name" name="customer_name" type="text" required
                                   value="{{ old('customer_name') }}" placeholder="e.g. Maria Santos"
                                   class="salon-input px-4 py-2.5 block w-full">
                            @error('customer_name')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="customer_phone" class="salon-label">Phone Number</label>
                            <input id="customer_phone" name="customer_phone" type="text"
                                   value="{{ old('customer_phone') }}" placeholder="e.g. 09XX-XXX-XXXX"
                                   class="salon-input px-4 py-2.5 block w-full">
                            @error('customer_phone')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="customer_email" class="salon-label">Email Address</label>
                        <input id="customer_email" name="customer_email" type="email" required
                               value="{{ old('customer_email') }}" placeholder="email@example.com"
                               class="salon-input px-4 py-2.5 block w-full">
                        @error('customer_email')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="scheduled_at" class="salon-label">Date &amp; Time</label>
                        <input id="scheduled_at" name="scheduled_at" type="datetime-local" required
                               value="{{ old('scheduled_at') }}"
                               class="salon-input px-4 py-2.5 block w-full">
                        @error('scheduled_at')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="notes" class="salon-label">Notes <span class="font-normal text-gray-400">(optional)</span></label>
                        <textarea id="notes" name="notes" rows="3"
                                  placeholder="Any special requests or notes..."
                                  class="salon-input px-4 py-2.5 block w-full resize-none">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="salon-form-actions">
                        <button type="submit" class="salon-btn-primary px-6 py-3">
                            Book Appointment
                        </button>
                        <a href="{{ route('appointments.index') }}" class="salon-btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
