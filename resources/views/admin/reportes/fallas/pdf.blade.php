<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Fallas - Equipos</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 10px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #9b2c2c; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { color: #742a2a; font-size: 18px; margin: 0; }
        .header p { color: #718096; font-size: 12px; margin-top: 5px; }
        .date { text-align: right; font-size: 10px; color: #a0aec0; margin-bottom: -15px; }
        
        .report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .report-table th, .report-table td { padding: 6px 8px; border: 1px solid #e2e8f0; text-align: left; }
        .report-table th { background-color: #f7fafc; color: #4a5568; font-weight: bold; }
        
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; font-size: 9px; color: #a0aec0; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 5px;}
        
        .status { padding: 2px 5px; border-radius: 4px; font-weight: bold; font-size: 9px; }
        .status-pendiente { background: #fed7d7; color: #9b2c2c; }
        .status-atendida { background: #c6f6d5; color: #22543d; }
        .status-otro { background: #fefcbf; color: #744210; }
    </style>
</head>
<body>

    <div class="date">
        Generado en: {{ now()->format('d/m/Y H:i A') }}
    </div>

    <div class="header">
        <h1>Sistema de Bitácoras de Laboratorio</h1>
        <p>Reporte Detallado Multidimensional de Fallas</p>
    </div>

    <div style="margin-bottom: 10px; font-weight: bold;">
        Total de registros consultados: {{ $fallas->count() }}
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 12%;">Fecha / Hora</th>
                <th style="width: 15%;">Equipo</th>
                <th style="width: 15%;">Laboratorio</th>
                <th style="width: 12%;">Tipo Falla</th>
                <th style="width: 25%;">Descripción</th>
                <th style="width: 8%;">Estado</th>
                <th style="width: 13%;">Reportó</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fallas as $falla)
            <tr>
                <td>{{ $falla->created_at ? $falla->created_at->format('d/m/Y H:i') : '' }}</td>
                <td>{{ $falla->equipo ? $falla->equipo->nombre : 'N/A' }}</td>
                <td>{{ $falla->laboratorio ? $falla->laboratorio->nombre : 'N/A' }}</td>
                <td>{{ $falla->tipo_falla }}</td>
                <td>{{ \Illuminate\Support\Str::limit($falla->descripcion, 70) }}</td>
                <td>
                    @if(strtolower($falla->estado) == 'pendiente')
                        <span class="status status-pendiente">Pendiente</span>
                    @elseif(strtolower($falla->estado) == 'atendida')
                        <span class="status status-atendida">Atendida</span>
                    @else
                        <span class="status status-otro">{{ $falla->estado }}</span>
                    @endif
                </td>
                <td>{{ $falla->usuario ? trim($falla->usuario->nombre . ' ' . $falla->usuario->paterno) : 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">No se encontraron registros de fallas para los criterios estipulados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Reporte exportado desde el Módulo de Inteligencia de Negocio - {{ url('/') }}
    </div>

</body>
</html>
