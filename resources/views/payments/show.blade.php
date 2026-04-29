@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('payments.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors font-medium text-sm">
            &larr; Back
        </a>
        <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
            Payment Details
        </h2>
    </div>
@endsection

@section('content')
    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="salon-alert-success px-6 py-4 animate-fade-in-up">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Payment Information --}}
            <div class="salon-card">
                <div class="salon-card-header">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Payment Information
                    </h3>
                </div>
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Customer</dt>
                        <dd class="salon-text-bold text-right">{{ $payment->appointment->customer_name }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Service</dt>
                        <dd class="salon-text-bold text-right">{{ $payment->appointment->service?->name ?? '(Service removed)' }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Schedule</dt>
                        <dd class="salon-text-bold text-right">{{ $payment->appointment->scheduled_at->format('F d, Y h:i A') }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Amount</dt>
                        <dd class="font-bold text-lg text-indigo-600 dark:text-indigo-400">&#8369;{{ number_format($payment->amount, 2) }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm">
                        <dt class="salon-text-muted">Payment Method</dt>
                        <dd class="salon-text-bold text-right">{{ $payment->payment_method }}</dd>
                    </div>
                    <div class="px-8 py-4 flex justify-between text-sm items-center">
                        <dt class="salon-text-muted">Status</dt>
                        <dd>@include('partials.status-badge', ['status' => $payment->status])</dd>
                    </div>
                    @if($payment->paid_at)
                        <div class="px-8 py-4 flex justify-between text-sm">
                            <dt class="salon-text-muted">Paid At</dt>
                            <dd class="salon-text-bold text-right">{{ $payment->paid_at->format('F d, Y h:i A') }}</dd>
                        </div>
                    @endif
                    @if($payment->notes)
                        <div class="px-8 py-4 flex justify-between text-sm">
                            <dt class="salon-text-muted">Notes</dt>
                            <dd class="salon-text-bold text-right">{{ $payment->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Update Status --}}
            <div class="salon-form-container">
                <div class="p-6 space-y-4">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Update Payment Status
                    </p>
                    <form action="{{ route('payments.updateStatus', $payment) }}" method="POST"
                          class="flex gap-3 items-center flex-wrap">
                        @csrf @method('PATCH')
                        <select name="status" class="salon-input px-4 py-2.5 text-sm">
                            <option value="paid"   {{ $payment->status === 'paid'   ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ $payment->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        <button type="submit" class="salon-btn-primary px-5 py-2.5 text-sm">
                            Update
                        </button>
                    </form>
                </div>
            </div>

            <div>
                <a href="{{ route('appointments.show', $payment->appointment) }}" class="salon-link text-sm">
                    View Appointment
                </a>
            </div>

        </div>
    </div>
@endsection
