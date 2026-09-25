@extends('layouts.app')

@section('title', 'Estudiantes')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Estudiantes</h2>
            <p class="text-sm text-gray-500 mt-1">Registro de estudiantes inscritos.</p>
        </div>
        <a href="{{ route('students.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            Registrar estudiante
        </a>
    </div>

    <form method="GET" action="{{ route('students.index') }}" class="mb-6 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o CI..."
               class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
        <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">Buscar</button>
        @if (request('search'))
            <a href="{{ route('students.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Limpiar</a>
        @endif
    </form>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Nombre completo</th>
                    <th class="px-4 py-3">CI</th>
                    <th class="px-4 py-3">Teléfono</th>
                    <th class="px-4 py-3">Matrícula N°</th>
                    <th class="px-4 py-3">Descuento</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($students as $student)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $student->fullName() }}</td>
                        <td class="px-4 py-3">{{ $student->ci }}</td>
                        <td class="px-4 py-3">{{ $student->phone ?: '—' }}</td>
                        <td class="px-4 py-3">{{ $student->registration_number ?: '—' }}</td>
                        <td class="px-4 py-3">{{ $student->discount > 0 ? $student->discount . '%' : '—' }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('students.show', $student) }}" class="text-indigo-600 hover:underline">Ver</a>
                            <a href="{{ route('students.edit', $student) }}" class="ml-3 text-amber-600 hover:underline">Editar</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline" onsubmit="return confirm('¿Eliminar este estudiante?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No hay estudiantes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $students->links() }}
    </div>
@endsection