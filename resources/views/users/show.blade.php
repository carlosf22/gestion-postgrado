@extends('layouts.app')

@section('title', 'Detalle de usuario')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Editar</a>
                <a href="{{ route('users.index') }}" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">Volver</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-xl">
        <dl class="space-y-4 text-sm">
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <dt class="text-gray-500">Correo electrónico</dt>
                <dd class="font-medium">{{ $user->email }}</dd>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <dt class="text-gray-500">Rol</dt>
                <dd class="font-medium">{{ $user->role === 'admin' ? 'Administrador' : 'Operador' }}</dd>
            </div>
            <div class="flex justify-between border-b border-gray-100 pb-3">
                <dt class="text-gray-500">Estado</dt>
                <dd class="font-medium">{{ $user->active ? 'Activo' : 'Inactivo' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Se unió el</dt>
                <dd class="font-medium">{{ $user->created_at->format('d/m/Y') }}</dd>
            </div>
        </dl>
    </div>
@endsection