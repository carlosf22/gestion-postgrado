@extends('layouts.app')

@section('title', 'Cursos')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Cursos</h2>
            <p class="text-sm text-gray-500 mt-1">Postgrados, diplomados y especializaciones.</p>
        </div>
        <a href="{{ route('courses.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            Crear curso
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Curso</th>
                    <th class="px-4 py-3">Edición</th>
                    <th class="px-4 py-3">Versión</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Costo</th>
                    <th class="px-4 py-3">Cupos</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($courses as $course)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $course->name }}</td>
                        <td class="px-4 py-3">{{ $course->edition }}</td>
                        <td class="px-4 py-3">{{ $course->version }}</td>
                        <td class="px-4 py-3">{{ $course->type }}</td>
                        <td class="px-4 py-3">Bs. {{ number_format($course->cost, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $course->availableSlots() }} / {{ $course->capacity }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $course->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $course->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:underline">Ver</a>
                            <a href="{{ route('courses.edit', $course) }}" class="ml-3 text-amber-600 hover:underline">Editar</a>
                            @if ($course->active)
                                <form method="POST" action="{{ route('courses.destroy', $course) }}" class="inline" onsubmit="return confirm('¿Desactivar este curso?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-3 text-red-600 hover:underline">Desactivar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">No hay cursos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
@endsection