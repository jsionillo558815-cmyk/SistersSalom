@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('appointments.show', $appointment) }}" class="text-gray-500 hover:text-indigo-600 transition-colors font-medium text-sm">
            &larr; Back
        </a>
        <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
            Process Payment
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Appointment Summary --}}
            <div class="salon-card">
                <div class="salon-card-header">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Appointment Summary
                    </h3>
                </div>
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Customer</dt>
                        <dd class="salon-text-bold text-right">{{ $appointment->customer_name }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Service</dt>
                        <dd class="salon-text-bold text-right">{{ $appointment->service?->name ?? '(Service removed)' }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Schedule</dt>
                        <dd class="salon-text-bold text-right">{{ $appointment->scheduled_at->format('F d, Y h:i A') }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Service Price</dt>
                        <dd class="salon-text-bold text-right">&#8369;{{ number_format($appointment->service?->price ?? 0, 2) }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Payment Form --}}
            <div class="salon-form-container">
                <form action="{{ route('payments.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                    <div class="space-y-1">
                        <label for="amount" class="salon-label">Amount (PHP)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-semibold">&#8369;</span>
                            <input id="amount" name="amount" type="number" step="0.01" min="0" required
                                   value="{{ old('amount', $appointment->service?->price ?? '') }}"
                                   placeholder="0.00"
                                   class="salon-input px-4 py-2.5 pl-8 block w-full">
                        </div>
                        @error('amount')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="payment_method" class="salon-label">Payment Method</label>
                        <select id="payment_method" name="payment_method" required
                                class="salon-input px-4 py-2.5">
                            @foreach(['Cash', 'GCash', 'Card'] as $method)
                                <option value="{{ $method }}" {{ old('payment_method', 'Cash') === $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="status" class="salon-label">Payment Status</label>
                        <select id="status" name="status" required
                                class="salon-input px-4 py-2.5">
                            <option value="paid"   {{ old('status') === 'paid'   ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @error('status')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="notes" class="salon-label">Notes <span class="font-normal text-gray-400">(optional)</span></label>
                        <textarea id="notes" name="notes" rows="2"
                                  class="salon-input px-4 py-2.5 block w-full resize-none">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="salon-form-actions">
                        <button type="submit" class="salon-btn-primary px-6 py-3">
                            Record Payment
                        </button>
                        <a href="{{ route('appointments.show', $appointment) }}" class="salon-btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
