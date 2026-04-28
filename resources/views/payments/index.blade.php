<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Payment History</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="px-4 py-3 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter --}}
            <form method="GET" class="flex gap-3">
                <select name="status"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
                <x-primary-button>Filter</x-primary-button>
                @if(request('status'))
                    <a href="{{ route('payments.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded hover:bg-gray-200">
                        Clear
                    </a>
                @endif
            </form>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($payments as $payment)
                                <tr>
                                    <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $payments->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $payment->appointment->customer_name }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $payment->appointment->service->name }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-gray-800 dark:text-gray-200">&#8369;{{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $payment->payment_method }}</td>
                                    <td class="px-6 py-3 text-sm">
                                        @include('partials.status-badge', ['status' => $payment->status])
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $payment->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-3 text-sm">
                                        <a href="{{ route('payments.show', $payment) }}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No payment records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($payments->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
