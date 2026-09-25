@extends('layouts.app')

@section('title', 'Crear curso')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Crear curso</h2>
        <a href="{{ route('courses.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Volver</a>
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

        <form method="POST" action="{{ route('courses.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del curso *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="edition" class="block text-sm font-medium text-gray-700 mb-1">Edición *</label>
                    <input type="number" name="edition" id="edition" min="1" value="{{ old('edition') }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="version" class="block text-sm font-medium text-gray-700 mb-1">Versión *</label>
                    <input type="number" name="version" id="version" min="1" value="{{ old('version') }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                    <select name="type" id="type" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Selecciona...</option>
                        <option value="Postgrado" {{ old('type') === 'Postgrado' ? 'selected' : '' }}>Postgrado</option>
                        <option value="Diplomado" {{ old('type') === 'Diplomado' ? 'selected' : '' }}>Diplomado</option>
                        <option value="Especialidad" {{ old('type') === 'Especialidad' ? 'selected' : '' }}>Especialidad</option>
                        <option value="Maestría" {{ old('type') === 'Maestría' ? 'selected' : '' }}>Maestría</option>
                        <option value="Doctorado" {{ old('type') === 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">Costo (Bs.) *</label>
                    <input type="number" name="cost" id="cost" min="0" step="0.01" value="{{ old('cost') }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Cupo máximo *</label>
                    <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', 30) }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
@endsection