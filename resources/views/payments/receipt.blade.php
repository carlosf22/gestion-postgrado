<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Comprobante de pago</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111; font-size: 13px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 2px 0; color: #555; }
        .section { margin-bottom: 16px; }
        .section h2 { font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        .label { width: 35%; background: #f5f5f5; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; color: #777; font-size: 11px; }
        .total { font-size: 16px; font-weight: bold; }
    </style>
</head>
<body>
    @php
        $enrollment = $payment->paymentPlan->enrollment;
        $student = $enrollment->student;
        $course = $enrollment->course;
    @endphp

    <div class="header">
        <h1>{{ config('app.name', 'Sistema de Gestión') }}</h1>
        <p>Comprobante de pago N° {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <table>
        <tr><td class="label">Fecha de emisión</td><td>{{ now()->format('d/m/Y H:i') }}</td></tr>
        <tr><td class="label">Docente/Estudiante</td><td>{{ $student->fullName() }}</td></tr>
        <tr><td class="label">CI</td><td>{{ $student->ci }}</td></tr>
        <tr><td class="label">Curso</td><td>{{ $course->name }}</td></tr>
        <tr><td class="label">Cuota</td><td>Cuota N° {{ $payment->installment_number }}</td></tr>
        <tr><td class="label">Fecha de pago</td><td>{{ $payment->payment_date?->format('d/m/Y') }}</td></tr>
        <tr><td class="label">Referencia</td><td>{{ $payment->reference_number ?: '—' }}</td></tr>
        <tr><td class="label">Monto pagado</td><td class="total">Bs. {{ number_format($payment->amount, 2, ',', '.') }}</td></tr>
    </table>

    <div class="footer">
        <p>Este comprobante es generado automáticamente por el sistema.</p>
    </div>
</body>
</html>