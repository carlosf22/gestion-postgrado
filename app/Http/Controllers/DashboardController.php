<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'students_count' => Student::count(),
            'courses_count' => Course::where('active', true)->count(),
            'active_enrollments' => Enrollment::where('status', 'active')->count(),
            'total_collected' => Payment::where('status', 'paid')->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'recent_payments' => Payment::with('paymentPlan.enrollment.student')
                ->where('status', 'paid')
                ->latest('payment_date')
                ->take(8)
                ->get(),
        ];

        return view('dashboard', $data);
    }
}