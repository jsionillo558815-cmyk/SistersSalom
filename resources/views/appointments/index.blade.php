<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Appointments</h2>
            <a href="{{ route('appointments.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded">
                New Appointment
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="salon-alert-success px-6 py-4 mb-4 animate-fade-in-up">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <form method="GET" class="flex gap-3 flex-wrap">
                <x-text-input name="search" placeholder="Search customer..." value="{{ request('search') }}" class="w-56" />
                <select name="status"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    @foreach(['pending','confirmed','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <x-primary-button>Filter</x-primary-button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('appointments.index') }}"
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Schedule</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($appointments as $appt)
                                <tr>
                                    <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $appointments->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appt->customer_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $appt->customer_phone }}</div>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $appt->service->name }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $appt->scheduled_at->format('M d, Y h:i A') }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-800 dark:text-gray-200">&#8369;{{ number_format($appt->service->price, 2) }}</td>
                                    <td class="px-6 py-3 text-sm">
                                        @include('partials.status-badge', ['status' => $appt->status])
                                    </td>
                                    <td class="px-6 py-3 text-sm space-x-2">
                                        <a href="{{ route('appointments.show', $appt) }}" class="text-indigo-600 hover:underline">View</a>
                                        <a href="{{ route('appointments.edit', $appt) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        <form action="{{ route('appointments.destroy', $appt) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete this appointment?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No appointments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($appointments->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $appointments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
