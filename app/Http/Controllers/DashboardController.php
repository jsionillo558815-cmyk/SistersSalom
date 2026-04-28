<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $totalServices     = Service::count();
        $totalAppointments = Appointment::count();
        $pendingCount      = Appointment::where('status', 'pending')->count();
        $totalRevenue      = Payment::where('status', 'paid')->sum('amount');

        $recentAppointments = Appointment::with('service')
            ->orderByDesc('scheduled_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalServices',
            'totalAppointments',
            'pendingCount',
            'totalRevenue',
            'recentAppointments'
        ));
    }
}
