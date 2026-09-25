<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Gestión') - {{ config('app.name', 'Gestion Postgrado') }}</title>

    <!-- Bootstrap Icons para los íconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        {{--  SIDEBAR PREMIUM  --}}
        <aside class="w-72 shrink-0 bg-white border-r border-gray-200 flex flex-col p-4">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-3 py-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center text-white text-lg">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-gray-900">{{ config('app.name', 'PostGrado') }}</h1>
                    <p class="text-xs text-gray-500">Gestión Académica</p>
                </div>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 space-y-1 text-sm">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 h-12 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg shadow-blue-900/25' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="bi bi-grid-1x2-fill text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                {{-- Estudiantes --}}
                <a href="{{ route('students.index') }}"
                   class="flex items-center gap-3 px-4 h-12 rounded-xl transition-all duration-300 {{ request()->routeIs('students.*') ? 'bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg shadow-blue-900/25' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="bi bi-people-fill text-lg"></i>
                    <span class="font-medium">Estudiantes</span>
                </a>

                {{-- Cursos --}}
                <a href="{{ route('courses.index') }}"
                   class="flex items-center gap-3 px-4 h-12 rounded-xl transition-all duration-300 {{ request()->routeIs('courses.*') ? 'bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg shadow-blue-900/25' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="bi bi-book-fill text-lg"></i>
                    <span class="font-medium">Cursos</span>
                </a>

                {{-- Inscripciones --}}
                <a href="{{ route('enrollments.index') }}"
                   class="flex items-center gap-3 px-4 h-12 rounded-xl transition-all duration-300 {{ request()->routeIs('enrollments.*') ? 'bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg shadow-blue-900/25' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="bi bi-pencil-square text-lg"></i>
                    <span class="font-medium">Inscripciones</span>
                </a>

                {{-- Pagos con badge --}}
                <a href="{{ route('payments.index') }}"
                   class="flex items-center gap-3 px-4 h-12 rounded-xl transition-all duration-300 {{ request()->routeIs('payments.*') ? 'bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg shadow-blue-900/25' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="bi bi-cash-coin text-lg"></i>
                    <span class="font-medium">Pagos</span>
                    @php $pendingCount = \App\Models\Payment::where('status', 'pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto text-[11px] font-semibold px-2 py-0.5 rounded-full {{ request()->routeIs('payments.*') ? 'bg-white/25 text-white' : 'bg-blue-900 text-white' }}">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                {{-- Reportes con dropdown --}}
                <div>
                    <button type="button" onclick="toggleReportDropdown(this)"
                            class="w-full flex items-center gap-3 px-4 h-12 rounded-xl transition-all duration-300 text-gray-700 hover:bg-gray-100">
                        <i class="bi bi-file-earmark-bar-graph-fill text-lg"></i>
                        <span class="font-medium">Reportes</span>
                        <i class="bi bi-chevron-right ml-auto text-xs transition-transform duration-300 arrow-icon"></i>
                    </button>
                    <div class="report-dropdown hidden pl-4 mt-1 space-y-1">
                        <a href="{{ route('reports.index') }}"
                           class="flex items-center gap-3 px-4 h-10 rounded-xl text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <i class="bi bi-list-ul"></i>
                            <span>Todos los reportes</span>
                        </a>
                        <a href="{{ route('reports.pending') }}"
                           class="flex items-center gap-3 px-4 h-10 rounded-xl text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <i class="bi bi-exclamation-circle"></i>
                            <span>Cuentas por cobrar</span>
                        </a>
                    </div>
                </div>

                {{-- Usuarios (solo admin) --}}
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}"
                       class="flex items-center gap-3 px-4 h-12 rounded-xl transition-all duration-300 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-blue-900 to-blue-700 text-white shadow-lg shadow-blue-900/25' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="bi bi-shield-lock-fill text-lg"></i>
                        <span class="font-medium">Usuarios</span>
                    </a>
                @endif
            </nav>

            {{-- Perfil de usuario abajo --}}
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-900 to-blue-700 text-white flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->isAdmin() ? 'Administrador' : 'Operador' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="p-1.5 rounded-lg text-gray-500 hover:bg-gray-200 hover:text-red-600 transition" title="Cerrar sesión">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">@yield('title', 'Panel')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</span>
                </div>
            </header>

            <main class="flex-1 px-8 py-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

{-- Script para el dropdown de reportes --}
    <script>
        function toggleReportDropdown(btn) {
            const dropdown = btn.nextElementSibling;
            const icon = btn.querySelector('.arrow-icon');
            dropdown.classList.toggle('hidden');
            icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
        }
    </script>
</body>
</html>
