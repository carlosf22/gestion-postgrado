<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('paymentPlan.enrollment.student', 'paymentPlan.enrollment.course')
            ->where('status', 'paid')
            ->latest('payment_date')
            ->paginate(15);
        return view('payments.index', compact('payments'));
    }

    public function store(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:50',
            'receipt_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('receipt_image')) {
            $data['receipt_image'] = $request->file('receipt_image')->store('receipts', 'public');
        }

        $data['status'] = 'paid';
        $payment->update($data);

        return redirect()->route('enrollments.show', $payment->paymentPlan->enrollment_id)
            ->with('success', 'Pago registrado.');
    }

    public function receipt(Payment $payment)
    {
        $payment->load('paymentPlan.enrollment.student', 'paymentPlan.enrollment.course');
        $pdf = Pdf::loadView('payments.receipt', compact('payment'));
        return $pdf->download("comprobante-{$payment->id}.pdf");
    }
}
