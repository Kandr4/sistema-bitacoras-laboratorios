<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencias Numérico</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 10px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2d3748; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { color: #1a202c; font-size: 18px; margin: 0; }
        .header p { color: #718096; font-size: 12px; margin-top: 5px; }
        .date { text-align: right; font-size: 10px; color: #a0aec0; margin-bottom: -15px; }
        
        .report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .report-table th, .report-table td { padding: 6px 8px; border: 1px solid #e2e8f0; text-align: left; }
        .report-table th { background-color: #f7fafc; color: #4a5568; font-weight: bold; }
        
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; font-size: 9px; color: #a0aec0; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 5px;}
    </style>
</head>
<body>

    <div class="date">
        Generado en: {{ now()->format('d/m/Y H:i A') }}
    </div>

    <div class="header">
        <h1>Sistema de Bitácoras de Laboratorio</h1>
        <p>Reporte Detallado de Asistencias Numérico</p>
    </div>

    <div style="margin-bottom: 10px; font-weight: bold;">
        Total de registros resultantes: {{ $asistencias->count() }}
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 8%;">Fecha</th>
                <th style="width: 17%;">Docente</th>
                <th style="width: 15%;">Laboratorio</th>
                <th style="width: 15%;">Carrera</th>
                <th style="width: 15%;">Asignatura</th>
                <th style="width: 7%;">C / G</th>
                <th style="width: 7%;">Entrada</th>
                <th style="width: 7%;">Salida</th>
                <th style="width: 9%;">Permanencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asistencias as $asistencia)
            <tr>
                <td>{{ $asistencia->fecha ? $asistencia->fecha->format('d/m/Y') : '' }}</td>
                <td>{{ $asistencia->usuario ? trim($asistencia->usuario->nombre . ' ' . $asistencia->usuario->paterno) : 'N/A' }}</td>
                <td>{{ $asistencia->laboratorio ? $asistencia->laboratorio->nombre : 'N/A' }}</td>
                <td>{{ $asistencia->carrera }}</td>
                <td>{{ $asistencia->asignatura }}</td>
                <td>{{ $asistencia->cuatrimestre }} / {{ $asistencia->grupo }}</td>
                <td>{{ $asistencia->entrada ? $asistencia->entrada->format('H:i') : '' }}</td>
                <td>{{ $asistencia->salida ? $asistencia->salida->format('H:i') : 'En curso' }}</td>
                <td style="font-weight: bold;">{{ $asistencia->permanencia_calc }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 20px;">No se encontraron registros para los criterios de búsqueda.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Reporte exportado desde el Módulo de Inteligencia de Negocio - {{ url('/') }}
    </div>

</body>
</html>
