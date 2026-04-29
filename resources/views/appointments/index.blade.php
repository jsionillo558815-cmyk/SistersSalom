@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
            Appointments
        </h2>
        <a href="{{ route('appointments.create') }}" class="salon-btn-primary px-5 py-2.5 text-sm">
            New Appointment
        </a>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="salon-alert-success px-6 py-4 animate-fade-in-up">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <form method="GET" class="flex gap-3 flex-wrap items-center">
                <input name="search" type="text" placeholder="Search customer..."
                       value="{{ request('search') }}"
                       class="salon-filter-input">
                <select name="status" class="salon-filter-select">
                    <option value="">All Statuses</option>
                    @foreach(['pending','confirmed','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="salon-btn-primary px-5 py-2.5 text-sm">Filter</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('appointments.index') }}" class="salon-btn-secondary text-sm">
                        Clear
                    </a>
                @endif
            </form>

            <div class="salon-card">
                <div class="salon-table-container">
                    <table class="salon-table">
                        <thead class="salon-table-header">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Schedule</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="salon-table-body">
                            @forelse($appointments as $appt)
                                <tr class="salon-table-row">
                                    <td class="salon-text-muted">
                                        {{ $appointments->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="salon-avatar w-9 h-9 text-sm">
                                                {{ substr($appt->customer_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="salon-text-bold">{{ $appt->customer_name }}</div>
                                                <div class="salon-text-muted text-xs mt-0.5">{{ $appt->customer_phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="salon-text-muted">
                                        {{ $appt->service?->name ?? '(Service removed)' }}
                                    </td>
                                    <td class="salon-text-muted">
                                        {{ $appt->scheduled_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="salon-text-bold">
                                        &#8369;{{ number_format($appt->service?->price ?? 0, 2) }}
                                    </td>
                                    <td>
                                        @include('partials.status-badge', ['status' => $appt->status])
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('appointments.show', $appt) }}" class="salon-link text-sm">
                                                View
                                            </a>
                                            <a href="{{ route('appointments.edit', $appt) }}"
                                               class="p-2 text-amber-600 hover:text-amber-900 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/30 rounded-lg transition-colors font-medium text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('appointments.destroy', $appt) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Delete this appointment?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-rose-600 hover:text-rose-900 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-900/30 rounded-lg transition-colors font-medium text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="salon-empty-state">
                                            <p class="salon-empty-title">No appointments found.</p>
                                            <a href="{{ route('appointments.create') }}"
                                               class="mt-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 font-medium hover:underline inline-flex items-center gap-1">
                                                Create your first appointment
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($appointments->hasPages())
                    <div class="salon-pagination">
                        {{ $appointments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
