@extends('layouts.app')

@section('title', 'Detalle del curso')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900">{{ $course->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('courses.edit', $course) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Editar</a>
                <a href="{{ route('courses.index') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">Volver</a>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-1">
            Edición {{ $course->edition }} &middot; Versión {{ $course->version }} &middot; {{ $course->type }}
            &middot; Costo <strong>Bs. {{ number_format($course->cost, 2, ',', '.') }}</strong>
            &middot; Cupos: {{ $course->availableSlots() }} / {{ $course->capacity }}
        </p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="font-semibold">Matriculados ({{ $course->enrollments->where('status', '!=', 'cancelled')->count() }})</h3>
            <a href="{{ route('enrollments.create') }}" class="text-sm text-indigo-600 hover:underline">Nueva matrícula</a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Estudiante</th>
                    <th class="px-4 py-3">CI</th>
                    <th class="px-4 py-3">Fecha de inscripción</th>
                    <th class="px-4 py-3">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($course->enrollments as $enrollment)
                    <tr>
                        <td class="px-4 py-3 font-medium">
                            <a href="{{ route('students.show', $enrollment->student) }}" class="text-indigo-600 hover:underline">
                                {{ $enrollment->student->fullName() }}
                            </a>
                        </td>
                        <td class="px-4 py-3">{{ $enrollment->student->ci }}</td>
                        <td class="px-4 py-3">{{ $enrollment->enrollment_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $enrollment->status === 'active' ? 'bg-green-100 text-green-700' : ($enrollment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Sin estudiantes matriculados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection