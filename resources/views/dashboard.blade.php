@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Panel de control</h2>
        <p class="text-sm text-gray-500 mt-1">Bienvenido de nuevo, {{ auth()->user()->name }}.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Estudiantes</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($students_count) }}</p>
            <a href="{{ route('students.index') }}" class="text-sm text-indigo-600 hover:underline">Ver estudiantes</a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Cursos activos</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($courses_count) }}</p>
            <a href="{{ route('courses.index') }}" class="text-sm text-indigo-600 hover:underline">Ver cursos</a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Matrículas activas</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($active_enrollments) }}</p>
            <a href="{{ route('enrollments.index') }}" class="text-sm text-indigo-600 hover:underline">Ver matrículas</a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Total cobrado</p>
            <p class="text-3xl font-bold mt-2">Bs. {{ number_format($total_collected, 2, ',', '.') }}</p>
            <a href="{{ route('payments.index') }}" class="text-sm text-indigo-600 hover:underline">Ver pagos</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-900">Últimos pagos</h3>
                <a href="{{ route('payments.index') }}" class="text-sm text-indigo-600 hover:underline">Ver todos</a>
            </div>
            @if ($recent_payments->isEmpty())
                <p class="text-sm text-gray-500">Aún no hay pagos registrados.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-200">
                            <th class="py-2">Estudiante</th>
                            <th class="py-2">Monto</th>
                            <th class="py-2">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recent_payments as $payment)
                            <tr class="border-b border-gray-100">
                                <td class="py-2">{{ $payment->paymentPlan->enrollment->student->fullName() }}</td>
                                <td class="py-2">Bs. {{ number_format($payment->amount, 2, ',', '.') }}</td>
                                <td class="py-2">{{ $payment->payment_date?->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-slate-900 mb-4">Pagos pendientes</h3>
            <div class="flex items-center gap-4">
                <div>
                    <p class="text-4xl font-bold text-amber-600">{{ number_format($pending_payments) }}</p>
                    <p class="text-sm text-gray-500 mt-1">cuotas por cobrar</p>
                </div>
                <div class="flex-1">
                    <a href="{{ route('reports.pending') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        Descargar reporte de saldos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


