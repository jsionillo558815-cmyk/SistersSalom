<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Process Payment</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- Appointment Summary --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-6 py-4">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Appointment Summary</h3>
                </div>
                <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Customer</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $appointment->customer_name }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Service</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $appointment->service->name }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Schedule</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $appointment->scheduled_at->format('F d, Y h:i A') }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Service Price</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-semibold">&#8369;{{ number_format($appointment->service->price, 2) }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Payment Form --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('payments.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                    <div>
                        <x-input-label for="amount" value="Amount (PHP)" />
                        <x-text-input id="amount" name="amount" type="number" step="0.01" min="0"
                            class="mt-1 block w-full"
                            value="{{ old('amount', $appointment->service->price) }}" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="payment_method" value="Payment Method" />
                        <select id="payment_method" name="payment_method" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(['Cash', 'GCash', 'Card'] as $method)
                                <option value="{{ $method }}" {{ old('payment_method', 'Cash') === $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('payment_method')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="status" value="Payment Status" />
                        <select id="status" name="status" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Notes (optional)" />
                        <textarea id="notes" name="notes" rows="2"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                    </div>

                    <div class="flex gap-3 pt-2">
                        <x-primary-button>Record Payment</x-primary-button>
                        <a href="{{ route('appointments.show', $appointment) }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-200 dark:hover:bg-gray-600">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
