@extends('layouts.app')

@section('title', 'Detalle de matrícula')

@section('content')
    @php
        $plan = $enrollment->paymentPlan;
        $totalPaid = $plan ? $plan->payments->where('status', 'paid')->sum('amount') : 0;
        $grandTotal = $plan?->total_amount ?? 0;
    @endphp

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900">Matrícula #{{ $enrollment->id }}</h2>
            <a href="{{ route('enrollments.index') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">Volver</a>
        </div>
        <div class="mt-2 flex items-center gap-3 flex-wrap">
            <a href="{{ route('students.show', $enrollment->student) }}" class="text-sm text-indigo-600 hover:underline">
                {{ $enrollment->student->fullName() }} ({{ $enrollment->student->ci }})
            </a>
            <span class="text-sm text-gray-400">→</span>
            <a href="{{ route('courses.show', $enrollment->course) }}" class="text-sm text-indigo-600 hover:underline">
                {{ $enrollment->course->name }}
            </a>
            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $enrollment->status === 'active' ? 'bg-green-100 text-green-700' : ($enrollment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                {{ ucfirst($enrollment->status) }}
            </span>
        </div>
    </div>

    @if ($plan)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Total del plan</p>
                <p class="text-2xl font-bold mt-1">Bs. {{ number_format($grandTotal, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Pagado</p>
                <p class="text-2xl font-bold mt-1 text-green-600">Bs. {{ number_format($totalPaid, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <p class="text-sm text-gray-500">Saldo pendiente</p>
                <p class="text-2xl font-bold mt-1 text-red-600">Bs. {{ number_format(max(0, $grandTotal - $totalPaid), 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="font-semibold">Plan de pagos ({{ $plan->total_installments }} cuotas)</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Cuota</th>
                        <th class="px-4 py-3">Monto</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Fecha de pago</th>
                        <th class="px-4 py-3">Referencia</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($plan->payments as $payment)
                        <tr>
                            <td class="px-4 py-3">Cuota N° {{ $payment->installment_number }}</td>
                            <td class="px-4 py-3">Bs. {{ number_format($payment->amount, 2, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ $payment->type === 'total' ? 'Total' : 'Parcial' }}</td>
                            <td class="px-4 py-3">{{ $payment->payment_date?->format('d/m/Y') ?: '—' }}</td>
                            <td class="px-4 py-3">{{ $payment->reference_number ?: '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $payment->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $payment->status === 'paid' ? 'Pagado' : 'Pendiente' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if ($payment->status === 'paid')
                                    <a href="{{ route('payments.receipt', $payment) }}" class="text-indigo-600 hover:underline">Comprobante</a>
                                @else
                                    <a href="{{ route('students.show', $enrollment->student) }}" class="text-amber-600 hover:underline">Registrar pago</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection