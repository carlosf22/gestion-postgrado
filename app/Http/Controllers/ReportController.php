<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function paymentsByDate(Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $payments = Payment::with('paymentPlan.enrollment.student', 'paymentPlan.enrollment.course')
            ->where('status', 'paid')
            ->whereBetween('payment_date', [$data['from'], $data['to']])
            ->get();

        $total = $payments->sum('amount');

        $pdf = Pdf::loadView('reports.payments-pdf', compact('payments', 'total', 'data'));
        return $pdf->download('reporte-pagos.pdf');
    }

    public function pendingBalances()
    {
        $plans = PaymentPlan::with('enrollment.student', 'enrollment.course')->get();
        $pdf = Pdf::loadView('reports.pending-pdf', compact('plans'));
        return $pdf->download('reporte-saldos.pdf');
    }
}
