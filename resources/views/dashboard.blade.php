<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
                Dashboard Overview
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="salon-stat-card salon-stat-indigo p-6">

                    <p class="salon-stat-label">Total Services</p>
                    <p class="salon-stat-value">{{ $totalServices }}</p>
                </div>

                <div class="salon-stat-card salon-stat-pink p-6">

                    <p class="salon-stat-label">Total Appointments</p>
                    <p class="salon-stat-value">{{ $totalAppointments }}</p>
                </div>

                <div class="salon-stat-card salon-stat-amber p-6">

                    <p class="salon-stat-label">Pending Appointments</p>
                    <p class="salon-stat-value">{{ $pendingCount }}</p>
                </div>

                <div class="salon-stat-card salon-stat-emerald p-6">

                    <p class="salon-stat-label">Total Revenue</p>
                    <p class="salon-stat-value">&#8369;{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>

           <div class="salon-card">
                <div class="salon-card-header">
                    <h3 class="text-xl font-bold salon-text-gradient">
                        Recent Appointments
                    </h3>
                    <a href="{{ route('appointments.create') }}" class="salon-btn-primary px-5 py-2.5 text-sm">
                        New Appointment
                    </a>
                </div>
                @if($recentAppointments->isEmpty())
                    <div class="salon-empty-state">
                        <p class="salon-empty-title">No appointments yet.</p>
                        <p class="salon-empty-subtitle">When you create appointments, they will appear here.</p>
                    </div>
                @else
                    <div class="salon-table-container">
                        <table class="salon-table">
                            <thead class="salon-table-header">
                                <tr>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="salon-table-body">
                                @foreach($recentAppointments as $appointment)
                                    <tr class="salon-table-row">
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="salon-avatar w-8 h-8 text-sm">
                                                    {{ substr($appointment->customer_name, 0, 1) }}
                                                </div>
                                                <span class="salon-text-bold">{{ $appointment->customer_name }}</span>
                                            </div>
                                        </td>
                                        <td class="salon-text-muted">
                                            {{ $appointment->service->name }}
                                        </td>
                                        <td class="salon-text-muted">
                                            <div class="flex items-center gap-2">
                                                {{ $appointment->scheduled_at->format('M d, Y h:i A') }}
                                            </div>
                                        </td>
                                        <td>
                                            @include('partials.status-badge', ['status' => $appointment->status])
                                        </td>
                                        <td>
                                            <a href="{{ route('appointments.show', $appointment) }}" class="salon-link">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>