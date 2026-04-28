<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('appointment.service')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create(Appointment $appointment)
    {
        if ($appointment->payment) {
            return redirect()->route('payments.show', $appointment->payment)
                ->with('info', 'Payment already recorded for this appointment.');
        }

        $appointment->load('service');
        return view('payments.create', compact('appointment'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:Cash,GCash,Card',
            'status'         => 'required|in:paid,unpaid',
            'notes'          => 'nullable|string',
        ]);

        if ($data['status'] === 'paid') {
            $data['paid_at'] = now();
        }

        $payment = Payment::create($data);

        if ($data['status'] === 'paid') {
            Appointment::find($data['appointment_id'])->update(['status' => 'completed']);
        }

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('appointment.service');
        return view('payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate(['status' => 'required|in:paid,unpaid']);

        $payment->update([
            'status'  => $request->status,
            'paid_at' => $request->status === 'paid' ? now() : null,
        ]);

        if ($request->status === 'paid') {
            $payment->appointment->update(['status' => 'completed']);
        }

        return back()->with('success', 'Payment status updated.');
    }
}
