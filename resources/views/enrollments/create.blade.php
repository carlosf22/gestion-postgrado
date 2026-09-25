@extends('layouts.app')

@section('title', 'Nueva matrícula')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Nueva matrícula</h2>
        <a href="{{ route('enrollments.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Volver</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('enrollments.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Estudiante *</label>
                <select name="student_id" id="student_id" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Selecciona un estudiante...</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->fullName() }} ({{ $student->ci }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Curso *</label>
                <select name="course_id" id="course_id" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Selecciona un curso...</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }} — Bs. {{ number_format($course->cost, 2, ',', '.') }} ({{ $course->availableSlots() }} cupos)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="enrollment_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de inscripción *</label>
                    <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', now()->toDateString()) }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="installments" class="block text-sm font-medium text-gray-700 mb-1">N° de cuotas *</label>
                    <select name="installments" id="installments" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('installments', 1) == $i ? 'selected' : '' }}>
                                {{ $i === 1 ? 'Pago único' : $i . ' cuotas' }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="rounded-lg bg-gray-50 border border-gray-200 px-4 py-3 text-sm text-gray-600">
                Al guardar se generará automáticamente el plan de pagos con las cuotas correspondientes.
            </div>

            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Registrar matrícula
                </button>
            </div>
        </form>
    </div>
@endsection