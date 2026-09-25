@extends('layouts.app')

@section('title', 'Detalle del estudiante')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900">{{ $student->fullName() }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('students.edit', $student) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Editar</a>
                <a href="{{ route('students.index') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">Volver</a>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-1">CI: {{ $student->ci }} &middot; Teléfono: {{ $student->phone ?: '—' }} &middot; Matrícula N° {{ $student->registration_number ?: '—' }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Enrollments --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-semibold">Matrículas</h3>
                <a href="{{ route('enrollments.create') }}" class="text-sm text-indigo-600 hover:underline">Nueva matrícula</a>
            </div>

            @forelse ($student->enrollments as $enrollment)
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="font-medium">{{ $enrollment->course->name }}</p>
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $enrollment->status === 'active' ? 'bg-green-100 text-green-700' : ($enrollment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Inscrito el {{ $enrollment->enrollment_date->format('d/m/Y') }}</p>

                    @if ($enrollment->paymentPlan)
                        @php
                            $totalPaid = $enrollment->paymentPlan->payments->where('status', 'paid')->sum('amount');
                            $grandTotal = $enrollment->paymentPlan->total_amount;
                        @endphp
                        <div class="mt-3 rounded-lg bg-gray-50 px-4 py-3">
                            <div class="flex items-center justify-between text-sm">
                                <span>Total: <strong>Bs. {{ number_format($grandTotal, 2, ',', '.') }}</strong></span>
                                <span>Pagado: <strong class="text-green-600">Bs. {{ number_format($totalPaid, 2, ',', '.') }}</strong></span>
                            </div>

                            <div class="mt-3 space-y-2">
                                @foreach ($enrollment->paymentPlan->payments as $payment)
                                    <div class="flex items-center justify-between text-sm border-t border-gray-200 pt-2">
                                        <span>Cuota {{ $payment->installment_number }} <span class="text-gray-400">· Bs. {{ number_format($payment->amount, 2, ',', '.') }}</span></span>
                                        @if ($payment->status === 'paid')
                                            <span class="inline-flex items-center gap-1 text-green-600">
                                                Pagado
                                                <a href="{{ route('payments.receipt', $payment) }}" class="text-xs text-indigo-600 hover:underline">Comprobante</a>
                                            </span>
                                        @else
                                            <button type="button" onclick="document.getElementById('payment-form-{{ $payment->id }}').classList.toggle('hidden')"
                                                    class="text-xs font-medium text-amber-600 hover:underline">Registrar pago</button>
                                        @endif
                                    </div>

                                    <form id="payment-form-{{ $payment->id }}" method="POST" action="{{ route('payments.store', $payment) }}" enctype="multipart/form-data" class="hidden bg-white border border-gray-200 rounded-lg p-3 space-y-2">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-0.5">Monto</label>
                                                <input type="number" name="amount" step="0.01" min="0.01" value="{{ old('amount', $payment->amount) }}" required
                                                       class="w-full rounded border border-gray-300 px-2 py-1 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-0.5">Fecha</label>
                                                <input type="date" name="payment_date" value="{{ old('payment_date', now()->toDateString()) }}" required
                                                       class="w-full rounded border border-gray-300 px-2 py-1 text-sm">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-0.5">N° de referencia</label>
                                            <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                                                   class="w-full rounded border border-gray-300 px-2 py-1 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-0.5">Comprobante (imagen, opcional)</label>
                                            <input type="file" name="receipt_image" accept="image/*"
                                                   class="w-full text-sm">
                                        </div>
                                        <button type="submit" class="w-full rounded bg-amber-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-amber-700">
                                            Confirmar pago
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <p class="px-6 py-8 text-center text-sm text-gray-500">Sin matrículas registradas.</p>
            @endforelse
        </div>

        {{-- Documents --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="font-semibold">Documentos</h3>
            </div>

            <form method="POST" action="{{ route('documents.store', $student) }}" enctype="multipart/form-data" class="px-6 py-4 border-b border-gray-100 space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <select name="type" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                            <option value="">Tipo de documento</option>
                            <option value="CI Front">Carnet de identidad (frente)</option>
                            <option value="CI Back">Carnet de identidad (reverso)</option>
                            <option value="Titulo">Título académico</option>
                            <option value="Diploma">Diploma de postgrado</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div>
                        <input type="file" name="file" accept=".pdf,image/jpeg,image/png,.jpg,.jpeg" required class="w-full text-sm">
                    </div>
                </div>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Subir documento</button>
            </form>

            <div class="divide-y divide-gray-100">
                @forelse ($student->documents as $document)
                    <div class="px-6 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium">{{ $document->type }}</p>
                            <p class="text-xs text-gray-500">{{ $document->original_name }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-sm text-indigo-600 hover:underline">Ver</a>
                            <form method="POST" action="{{ route('documents.destroy', $document) }}" onsubmit="return confirm('¿Eliminar este documento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-8 text-center text-sm text-gray-500">Sin documentos cargados.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection