@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
            Payment History
        </h2>
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

            {{-- Filter --}}
            <form method="GET" class="flex gap-3 items-center flex-wrap">
                <select name="status" class="salon-filter-select">
                    <option value="">All Statuses</option>
                    <option value="paid"   {{ request('status') === 'paid'   ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
                <button type="submit" class="salon-btn-primary px-5 py-2.5 text-sm">Filter</button>
                @if(request('status'))
                    <a href="{{ route('payments.index') }}" class="salon-btn-secondary text-sm">Clear</a>
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
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="salon-table-body">
                            @forelse($payments as $payment)
                                <tr class="salon-table-row">
                                    <td class="salon-text-muted">
                                        {{ $payments->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="salon-avatar w-9 h-9 text-sm">
                                                {{ substr($payment->appointment->customer_name, 0, 1) }}
                                            </div>
                                            <span class="salon-text-bold">{{ $payment->appointment->customer_name }}</span>
                                        </div>
                                    </td>
                                    <td class="salon-text-muted">
                                        {{ $payment->appointment->service?->name ?? '(Service removed)' }}
                                    </td>
                                    <td class="salon-text-bold">
                                        &#8369;{{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td class="salon-text-muted">{{ $payment->payment_method }}</td>
                                    <td>
                                        @include('partials.status-badge', ['status' => $payment->status])
                                    </td>
                                    <td class="salon-text-muted">
                                        {{ $payment->created_at->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('payments.show', $payment) }}" class="salon-link text-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="salon-empty-state">
                                            <p class="salon-empty-title">No payment records found.</p>
                                            <p class="salon-empty-subtitle">Process a payment from an appointment's detail page.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($payments->hasPages())
                    <div class="salon-pagination">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
