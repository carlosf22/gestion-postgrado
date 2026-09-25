@extends('layouts.app')

@section('title', 'Pagos')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Pagos registrados</h2>
        <p class="text-sm text-gray-500 mt-1">Historial de pagos confirmados.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Cuota</th>
                    <th class="px-4 py-3">Estudiante</th>
                    <th class="px-4 py-3">Curso</th>
                    <th class="px-4 py-3">Monto</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Referencia</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($payments as $payment)
                    @php
                        $enrollment = $payment->paymentPlan->enrollment;
                    @endphp
                    <tr>
                        <td class="px-4 py-3">Cuota N° {{ $payment->installment_number }}</td>
                        <td class="px-4 py-3 font-medium">{{ $enrollment->student->fullName() }}</td>
                        <td class="px-4 py-3">{{ $enrollment->course->name }}</td>
                        <td class="px-4 py-3">Bs. {{ number_format($payment->amount, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $payment->payment_date?->format('d/m/Y') ?: '—' }}</td>
                        <td class="px-4 py-3">{{ $payment->reference_number ?: '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('payments.receipt', $payment) }}" class="text-indigo-600 hover:underline">Comprobante</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Aún no hay pagos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $payments->links() }}
    </div>
@endsection