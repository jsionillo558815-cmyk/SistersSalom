<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Appointment</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')

                    <div>
                        <x-input-label for="service_id" value="Service" />
                        <select id="service_id" name="service_id" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Select a service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} &mdash; &#8369;{{ number_format($service->price, 2) }} ({{ $service->duration_label }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('service_id')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="customer_name" value="Customer Name" />
                            <x-text-input id="customer_name" name="customer_name" type="text"
                                class="mt-1 block w-full" value="{{ old('customer_name', $appointment->customer_name) }}" required />
                            <x-input-error :messages="$errors->get('customer_name')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="customer_phone" value="Phone Number" />
                            <x-text-input id="customer_phone" name="customer_phone" type="text"
                                class="mt-1 block w-full" value="{{ old('customer_phone', $appointment->customer_phone) }}" />
                            <x-input-error :messages="$errors->get('customer_phone')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="customer_email" value="Email Address" />
                        <x-text-input id="customer_email" name="customer_email" type="email"
                            class="mt-1 block w-full" value="{{ old('customer_email', $appointment->customer_email) }}" required />
                        <x-input-error :messages="$errors->get('customer_email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="scheduled_at" value="Date and Time" />
                        <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local"
                            class="mt-1 block w-full"
                            value="{{ old('scheduled_at', $appointment->scheduled_at->format('Y-m-d\TH:i')) }}" required />
                        <x-input-error :messages="$errors->get('scheduled_at')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                <option value="{{ $s }}" {{ old('status', $appointment->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Notes (optional)" />
                        <textarea id="notes" name="notes" rows="3"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $appointment->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                    </div>

                    <div class="flex gap-3 pt-2">
                        <x-primary-button>Update Appointment</x-primary-button>
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
