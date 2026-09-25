<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de saldos pendientes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; }
        .total { text-align: right; font-size: 15px; font-weight: bold; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name', 'Sistema de Gestión') }}</h1>
        <p>Reporte de saldos pendientes — generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @php
        $granTotal = 0;
        $granPendiente = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Plan total</th>
                <th>Total pagado</th>
                <th>Saldo pendiente</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($plans as $plan)
                @php
                    $pagado = $plan->payments->where('status', 'paid')->sum('amount');
                    $pendiente = max(0, $plan->total_amount - $pagado);
                    $granTotal += $plan->total_amount;
                    $granPendiente += $pendiente;
                @endphp
                <tr>
                    <td>{{ $plan->enrollment->student->fullName() }}</td>
                    <td>{{ $plan->enrollment->course->name }}</td>
                    <td>Bs. {{ number_format($plan->total_amount, 2, ',', '.') }}</td>
                    <td>Bs. {{ number_format($pagado, 2, ',', '.') }}</td>
                    <td>Bs. {{ number_format($pendiente, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay planes de pago registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="total">Total planificado: Bs. {{ number_format($granTotal, 2, ',', '.') }}</p>
    <p class="total">Total pendiente: Bs. {{ number_format($granPendiente, 2, ',', '.') }}</p>
</body>
</html>