<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de pagos</title>
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
        <p>Reporte de pagos del {{ \Carbon\Carbon::parse($data['from'])->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($data['to'])->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Cuota</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->paymentPlan->enrollment->student->fullName() }}</td>
                    <td>{{ $payment->paymentPlan->enrollment->course->name }}</td>
                    <td>{{ $payment->installment_number }}</td>
                    <td>Bs. {{ number_format($payment->amount, 2, ',', '.') }}</td>
                    <td>{{ $payment->payment_date?->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6">No se encontraron pagos en el rango indicado.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="total">Total: Bs. {{ number_format($total, 2, ',', '.') }}</p>
</body>
</html>