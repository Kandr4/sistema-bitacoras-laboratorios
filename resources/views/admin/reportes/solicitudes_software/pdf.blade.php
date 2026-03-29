<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Solicitudes de Software</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 10px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2b6cb0; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { color: #2a4365; font-size: 18px; margin: 0; }
        .header p { color: #718096; font-size: 12px; margin-top: 5px; }
        .date { text-align: right; font-size: 10px; color: #a0aec0; margin-bottom: -15px; }
        
        .report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .report-table th, .report-table td { padding: 6px 8px; border: 1px solid #e2e8f0; text-align: left; }
        .report-table th { background-color: #ebf8ff; color: #2b6cb0; font-weight: bold; }
        
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; font-size: 9px; color: #a0aec0; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 5px;}
        
        .status { padding: 2px 4px; border-radius: 4px; font-weight: bold; font-size: 9px; }
        .status-pendiente { background: #fed7d7; color: #9b2c2c; }
        .status-atendida { background: #c6f6d5; color: #22543d; }
        .status-otro { background: #e2e8f0; color: #4a5568; }
    </style>
</head>
<body>

    <div class="date">
        Generado en: {{ now()->format('d/m/Y H:i A') }}
    </div>

    <div class="header">
        <h1>Sistema de Bitácoras de Laboratorio</h1>
        <p>Reporte Detallado Mensual: Solicitudes de Instalación de Software</p>
    </div>

    <div style="margin-bottom: 10px; font-weight: bold; color: #2b6cb0;">
        Total de peticiones filtradas: {{ $solicitudes->count() }}
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 10%;">Fecha Envío</th>
                <th style="width: 15%;">Docente Solicitante</th>
                <th style="width: 15%;">Software Requerido</th>
                <th style="width: 15%;">Laboratorio Destino</th>
                <th style="width: 9%;">Estado</th>
                <th style="width: 36%;">Observaciones Técnicas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($solicitudes as $sol)
            <tr>
                <td>{{ $sol->fecsolicitud ? date('d/m/Y', strtotime($sol->fecsolicitud)) : '' }}</td>
                <td>{{ $sol->usuario ? trim($sol->usuario->nombre . ' ' . $sol->usuario->paterno) : 'N/A' }}</td>
                <td style="font-weight: bold;">{{ $sol->software }}</td>
                <td>{{ $sol->laboratorio ? $sol->laboratorio->nombre : 'N/A' }}</td>
                <td>
                    @if(strtolower($sol->estado) == 'pendiente')
                        <span class="status status-pendiente">Pendiente</span>
                    @elseif(strtolower($sol->estado) == 'atendida' || strtolower($sol->estado) == 'instalado')
                        <span class="status status-atendida">Instalado</span>
                    @else
                        <span class="status status-otro">{{ $sol->estado }}</span>
                    @endif
                </td>
                <td>{{ $sol->comentario ?: '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">No existen solicitudes vigentes bajo estos parámetros de búsqueda.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Área de Inteligencia de Negocio y Reportería (Software) - {{ url('/') }}
    </div>

</body>
</html>
