@extends('layouts.app')

@section('title', 'Editar estudiante')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Editar estudiante</h2>
        <a href="{{ route('students.show', $student) }}" class="text-sm text-indigo-600 hover:underline">&larr; Volver</a>
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

        <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700 mb-1">CI *</label>
                    <input type="text" name="ci" id="ci" value="{{ old('ci', $student->ci) }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Primer nombre *</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellido paterno *</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="mother_last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellido materno</label>
                    <input type="text" name="mother_last_name" id="mother_last_name" value="{{ old('mother_last_name', $student->mother_last_name) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-1">N° de matrícula</label>
                    <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number', $student->registration_number) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">Descuento (%)</label>
                    <input type="number" name="discount" id="discount" min="0" max="100" step="0.01" value="{{ old('discount', $student->discount) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
@endsection