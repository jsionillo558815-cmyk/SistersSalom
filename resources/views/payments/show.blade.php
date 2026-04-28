<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Payment Details</h2>
            <a href="{{ route('payments.index') }}"
               class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm px-4 py-2 rounded hover:bg-gray-200">
                Back to Payments
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div class="px-4 py-3 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-700">
                <div class="px-6 py-4">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment Information</h3>
                </div>
                <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Customer</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $payment->appointment->customer_name }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Service</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $payment->appointment->service->name }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Schedule</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $payment->appointment->scheduled_at->format('F d, Y h:i A') }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Amount</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-semibold text-lg">&#8369;{{ number_format($payment->amount, 2) }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm">
                        <dt class="text-gray-500 dark:text-gray-400">Payment Method</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $payment->payment_method }}</dd>
                    </div>
                    <div class="px-6 py-3 flex justify-between text-sm items-center">
                        <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>@include('partials.status-badge', ['status' => $payment->status])</dd>
                    </div>
                    @if($payment->paid_at)
                        <div class="px-6 py-3 flex justify-between text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">Paid At</dt>
                            <dd class="text-gray-900 dark:text-gray-100">{{ $payment->paid_at->format('F d, Y h:i A') }}</dd>
                        </div>
                    @endif
                    @if($payment->notes)
                        <div class="px-6 py-3 flex justify-between text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">Notes</dt>
                            <dd class="text-gray-900 dark:text-gray-100">{{ $payment->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Toggle Status --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Update Payment Status</h3>
                <form action="{{ route('payments.updateStatus', $payment) }}" method="POST" class="flex gap-3 items-center">
                    @csrf @method('PATCH')
                    <select name="status"
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ $payment->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                    <x-primary-button>Update</x-primary-button>
                </form>
            </div>

            <div>
                <a href="{{ route('appointments.show', $payment->appointment) }}"
                   class="text-indigo-600 hover:underline text-sm">
                    View Appointment
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
