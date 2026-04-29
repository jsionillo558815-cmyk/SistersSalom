@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-3">
            <a href="{{ route('appointments.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors font-medium text-sm">
                &larr; Back
            </a>
            <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
                Appointment Details
            </h2>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('appointments.edit', $appointment) }}" class="salon-btn-primary px-5 py-2.5 text-sm">
                Edit
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="salon-alert-success px-6 py-4 animate-fade-in-up">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Customer Information --}}
            <div class="salon-card">
                <div class="salon-card-header">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Customer Information
                    </h3>
                </div>
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach([
                        ['Customer Name', $appointment->customer_name],
                        ['Email',         $appointment->customer_email],
                        ['Phone',         $appointment->customer_phone ?? '—'],
                    ] as [$label, $value])
                        <div class="px-8 py-4 flex justify-between text-sm">
                            <dt class="salon-text-muted">{{ $label }}</dt>
                            <dd class="salon-text-bold text-right">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Booking Details --}}
            <div class="salon-card">
                <div class="salon-card-header">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Booking Details
                    </h3>
                </div>
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Service</dt>
                        <dd class="salon-text-bold text-right">{{ $appointment->service?->name ?? '(Service removed)' }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Price</dt>
                        <dd class="salon-text-bold text-right">&#8369;{{ number_format($appointment->service?->price ?? 0, 2) }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Schedule</dt>
                        <dd class="salon-text-bold text-right">{{ $appointment->scheduled_at->format('F d, Y h:i A') }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm items-center">
                        <dt class="salon-text-muted">Status</dt>
                        <dd>@include('partials.status-badge', ['status' => $appointment->status])</dd>
                    </div>
                    @if($appointment->notes)
                        <div class="px-8 py-4 flex justify-between text-sm">
                            <dt class="salon-text-muted">Notes</dt>
                            <dd class="salon-text-bold text-right max-w-xs">{{ $appointment->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Payment Section --}}
            <div class="salon-card">
                <div class="salon-card-header">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Payment
                    </h3>
                    @if(!$appointment->payment)
                        <a href="{{ route('payments.create', $appointment) }}" class="salon-btn-primary px-5 py-2 text-sm">
                            Process Payment
                        </a>
                    @endif
                </div>
                @if($appointment->payment)
                    <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                        <div class="px-8 py-4 flex justify-between text-sm">
                            <dt class="salon-text-muted">Amount</dt>
                            <dd class="salon-text-bold text-right">&#8369;{{ number_format($appointment->payment->amount, 2) }}</dd>
                        </div>
                        <div class="px-8 py-4 flex justify-between text-sm">
                            <dt class="salon-text-muted">Method</dt>
                            <dd class="salon-text-bold text-right">{{ $appointment->payment->payment_method }}</dd>
                        </div>
                        <div class="px-8 py-4 flex justify-between text-sm items-center">
                            <dt class="salon-text-muted">Payment Status</dt>
                            <dd>@include('partials.status-badge', ['status' => $appointment->payment->status])</dd>
                        </div>
                        @if($appointment->payment->paid_at)
                            <div class="px-8 py-4 flex justify-between text-sm">
                                <dt class="salon-text-muted">Paid At</dt>
                                <dd class="salon-text-bold text-right">{{ $appointment->payment->paid_at->format('F d, Y h:i A') }}</dd>
                            </div>
                        @endif
                        <div class="px-8 py-4">
                            <a href="{{ route('payments.show', $appointment->payment) }}" class="salon-link text-sm">
                                View Payment Details
                            </a>
                        </div>
                    </dl>
                @else
                    <div class="px-8 py-6 salon-text-muted text-sm">
                        No payment recorded yet.
                    </div>
                @endif
            </div>

            {{-- Delete --}}
            <div class="flex justify-end">
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                      onsubmit="return confirm('Delete this appointment? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-semibold text-rose-600 border border-rose-300 rounded-lg hover:bg-rose-50 transition-colors">
                        Delete Appointment
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
