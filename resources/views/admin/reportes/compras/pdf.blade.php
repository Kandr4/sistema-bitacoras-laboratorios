<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Solicitudes de Compras</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; margin: 10px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #059669; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { color: #065f46; font-size: 18px; margin: 0; }
        .header p { color: #718096; font-size: 12px; margin-top: 5px; }
        .date { text-align: right; font-size: 10px; color: #a0aec0; margin-bottom: -15px; }
        
        .report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .report-table th, .report-table td { padding: 6px 8px; border: 1px solid #e2e8f0; text-align: left; }
        .report-table th { background-color: #ecfdf5; color: #047857; font-weight: bold; }
        
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; font-size: 9px; color: #a0aec0; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 5px;}
        
        .status { padding: 2px 4px; border-radius: 4px; font-weight: bold; font-size: 9px; }
        .status-pendiente { background: #fefcbf; color: #744210; }
        .status-aprobado { background: #c6f6d5; color: #1c4532; }
        .status-rechazado { background: #fed7d7; color: #822727; }
        .status-otro { background: #e2e8f0; color: #4a5568; }
    </style>
</head>
<body>

    <div class="date">
        Generado en: {{ now()->format('d/m/Y H:i A') }}
    </div>

    <div class="header">
        <h1>Sistema de Bitácoras de Laboratorio</h1>
        <p>Reporte Financiero y Operativo de Presupuestos y Compras</p>
    </div>

    <div style="margin-bottom: 5px; font-weight: bold; color: #047857;">
        Total de presupuesto estimado: ${{ number_format($compras->sum('costo_unitario'), 2) }}
    </div>
    <div style="font-size: 10px; color: #718096; margin-bottom: 10px;">
        Mostrando {{ $compras->count() }} órdenes de compra en este filtro.
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 8%;">Fecha</th>
                <th style="width: 14%;">Requisitor</th>
                <th style="width: 16%;">Producto y Características</th>
                <th style="width: 4%;">Ud.</th>
                <th style="width: 12%;">Destino</th>
                <th style="width: 9%;">Costo U.</th>
                <th style="width: 8%;">Estado</th>
                <th style="width: 29%;">Justificación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($compras as $com)
            <tr>
                <td>{{ $com->fecha_solicitud ? date('d/m/Y', strtotime($com->fecha_solicitud)) : '' }}</td>
                <td>{{ $com->tecnico ? trim($com->tecnico->nombre . ' ' . $com->tecnico->paterno) : 'N/A' }}</td>
                <td>
                    <div style="font-weight: bold;">{{ $com->descripcion }}</div>
                    <div style="font-size: 8px; color: #718096;">Chars: {{ \Illuminate\Support\Str::limit($com->caracteristicas, 60) }}</div>
                </td>
                <td style="text-align: center; font-weight: bold;">{{ $com->cantidad }}</td>
                <td>{{ $com->laboratorio ? $com->laboratorio->nombre : 'N/A' }}</td>
                <td style="font-weight: bold;">${{ number_format($com->costo_unitario, 2) }}</td>
                <td>
                    @if(strtolower($com->estado) == 'pendiente')
                        <span class="status status-pendiente">Pendiente</span>
                    @elseif(strtolower($com->estado) == 'aprobada' || strtolower($com->estado) == 'aprobado' || strtolower($com->estado) == 'comprado')
                        <span class="status status-aprobado">Aprobado</span>
                    @elseif(strtolower($com->estado) == 'rechazada' || strtolower($com->estado) == 'cancelada')
                        <span class="status status-rechazado">Rechazado</span>
                    @else
                        <span class="status status-otro">{{ $com->estado }}</span>
                    @endif
                </td>
                <td style="font-size: 9px;">{{ $com->justificacion ?: '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">No existen compras registradas bajo estos parámetros de búsqueda.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Área de Inteligencia de Negocio y Reportería (Compras) - {{ url('/') }}
    </div>

</body>
</html>
