<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Dashboard - Administrador</title>
    <style>
        body { font-family: sans-serif; margin: 30px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2d3748; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #1a202c; font-size: 24px; margin: 0; }
        .header p { color: #718096; font-size: 14px; margin-top: 5px; }
        .date { text-align: right; font-size: 12px; color: #a0aec0; margin-bottom: -15px; }
        
        .report-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        .report-table th, .report-table td { padding: 12px 15px; border: 1px solid #e2e8f0; text-align: left; }
        .report-table th { background-color: #f7fafc; color: #4a5568; font-weight: 600; }
        
        .total-row td { font-weight: bold; background-color: #edf2f7; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; font-size: 10px; color: #a0aec0; text-align: center; }
    </style>
</head>
<body>

    <div class="date">
        Generado en: {{ now()->format('d/m/Y H:i A') }}
    </div>

    <div class="header">
        <h1>Sistema de Bitácoras de Laboratorio</h1>
        <p>Reporte Numérico de Resumen Operativo</p>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 70%;">Métrica</th>
                <th style="width: 30%; text-align: right;">Total Histórico</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total de Asistencias Registradas</td>
                <td style="text-align: right;">{{ number_format($stats['asistencias']) }}</td>
            </tr>
            <tr>
                <td>Número de Fallas Reportadas</td>
                <td style="text-align: right;">{{ number_format($stats['fallas']) }}</td>
            </tr>
            <tr>
                <td>Número de Solicitudes de Software</td>
                <td style="text-align: right;">{{ number_format($stats['solicitudesSoftware']) }}</td>
            </tr>
            <tr>
                <td>Total de Reparaciones (Mantenimientos)</td>
                <td style="text-align: right;">{{ number_format($stats['reparaciones']) }}</td>
            </tr>
            <tr>
                <td>Número de Solicitudes de Compra</td>
                <td style="text-align: right;">{{ number_format($stats['compras']) }}</td>
            </tr>
            <tr class="total-row">
                <td style="text-align: right;">Suma Total de Movimientos</td>
                <td style="text-align: right;">
                    {{ number_format(array_sum($stats)) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Este es un reporte descriptivo auto-generado por el sistema.
    </div>

</body>
</html>
