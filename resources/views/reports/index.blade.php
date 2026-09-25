@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Reportes</h2>
        <p class="text-sm text-gray-500 mt-1">Genera reportes en PDF.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-slate-900">Pagos por rango de fechas</h3>
            <p class="text-sm text-gray-500 mt-1">Genera un PDF con todos los pagos realizados entre dos fechas.</p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('reports.payments') }}" class="mt-4 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="from" class="block text-sm font-medium text-gray-700 mb-1">Desde *</label>
                        <input type="date" name="from" id="from" value="{{ old('from', now()->startOfMonth()->toDateString()) }}" required
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="to" class="block text-sm font-medium text-gray-700 mb-1">Hasta *</label>
                        <input type="date" name="to" id="to" value="{{ old('to', now()->toDateString()) }}" required
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Descargar reporte
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-slate-900">Saldos pendientes</h3>
            <p class="text-sm text-gray-500 mt-1">Genera un PDF con los saldos pendientes de todos los planes de pago.</p>
            <a href="{{ route('reports.pending') }}" class="mt-4 inline-block rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                Descargar reporte
            </a>
        </div>
    </div>
@endsection