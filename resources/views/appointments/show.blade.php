<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Appointment Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('appointments.edit', $appointment) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded">
                    Edit
                </a>
                <a href="{{ route('appointments.index') }}"
                   class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm px-4 py-2 rounded hover:bg-gray-200">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div class="salon-alert-success px-6 py-4 mb-4 animate-fade-in-up">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Appointment Info --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-6 py-4">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer Information</h3>
                </div>
                <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach([
                        ['Customer Name', $appointment->customer_name],
                        ['Email', $appointment->customer_email],
                        ['Phone', $appointment->customer_phone ?? '—'],
                    ] as [$label, $value])
                        <div class="px-6 py-3 flex justify-between text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-6 py-4">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Booking Details</h3>
                </div>
                <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Service</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $appointment->service->name }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Price</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium">&#8369;{{ number_format($appointment->service->price, 2) }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Schedule</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $appointment->scheduled_at->format('F d, Y h:i A') }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>@include('partials.status-badge', ['status' => $appointment->status])</dd>
                    </div>
                    @if($appointment->notes)
                        <div class="px-6 py-3 flex justify-between text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">Notes</dt>
                            <dd class="text-gray-900 dark:text-gray-100">{{ $appointment->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Payment Section --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment</h3>
                    @if(!$appointment->payment)
                        <a href="{{ route('payments.create', $appointment) }}"
                           class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded">
                            Process Payment
                        </a>
                    @endif
                </div>
                @if($appointment->payment)
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="px-6 py-3 flex justify-between text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">Amount</dt>
                            <dd class="text-gray-900 dark:text-gray-100 font-medium">&#8369;{{ number_format($appointment->payment->amount, 2) }}</dd>
                        </div>
                        <div class="px-6 py-3 flex justify-between text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">Method</dt>
                            <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $appointment->payment->payment_method }}</dd>
                        </div>
                        <div class="px-6 py-3 flex justify-between text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">Payment Status</dt>
                            <dd>@include('partials.status-badge', ['status' => $appointment->payment->status])</dd>
                        </div>
                        @if($appointment->payment->paid_at)
                            <div class="px-6 py-3 flex justify-between text-sm">
                                <dt class="text-gray-500 dark:text-gray-400">Paid At</dt>
                                <dd class="text-gray-900 dark:text-gray-100">{{ $appointment->payment->paid_at->format('F d, Y h:i A') }}</dd>
                            </div>
                        @endif
                        <div class="px-6 py-3">
                            <a href="{{ route('payments.show', $appointment->payment) }}"
                               class="text-indigo-600 hover:underline text-sm">View Payment Details</a>
                        </div>
                    </dl>
                @else
                    <p class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">No payment recorded yet.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
