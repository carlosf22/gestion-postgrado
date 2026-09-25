@extends('layouts.app')

@section('title', 'Matrículas')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Matrículas</h2>
            <p class="text-sm text-gray-500 mt-1">Inscripciones de estudiantes a cursos.</p>
        </div>
        <a href="{{ route('enrollments.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            Nueva matrícula
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Estudiante</th>
                    <th class="px-4 py-3">Curso</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($enrollments as $enrollment)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $enrollment->student->fullName() }}</td>
                        <td class="px-4 py-3">{{ $enrollment->course->name }}</td>
                        <td class="px-4 py-3">{{ $enrollment->enrollment_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $enrollment->status === 'active' ? 'bg-green-100 text-green-700' : ($enrollment->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('enrollments.show', $enrollment) }}" class="text-indigo-600 hover:underline">Ver</a>
                            @if ($enrollment->status === 'active')
                                <form method="POST" action="{{ route('enrollments.destroy', $enrollment) }}" class="inline" onsubmit="return confirm('¿Cancelar esta matrícula?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-3 text-red-600 hover:underline">Cancelar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay matrículas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $enrollments->links() }}
    </div>
@endsection