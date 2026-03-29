<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Falla;
use App\Models\SolicitudSoftware;
use App\Models\Mantenimiento;
use App\Models\Solicitud;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminDashboardController extends Controller
{
    /**
     * Mostrar el dashboard de Aministrador con estadísticas y opciones.
     */
    public function index()
    {
        $stats = [
            'asistencias' => Asistencia::count(),
            'fallas' => Falla::count(),
            'solicitudesSoftware' => SolicitudSoftware::count(),
            'reparaciones' => Mantenimiento::count(),
            'compras' => Solicitud::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Generar y descargar reporte en PDF de las estadísticas globales.
     */
    public function exportPdf()
    {
        $stats = [
            'asistencias' => Asistencia::count(),
            'fallas' => Falla::count(),
            'solicitudesSoftware' => SolicitudSoftware::count(),
            'reparaciones' => Mantenimiento::count(),
            'compras' => Solicitud::count(),
        ];
        
        // Muestra en una vista preparada las estadísticas para el DOMPDF
        $pdf = Pdf::loadView('admin.pdf.dashboard', compact('stats'));
        
        return $pdf->download('reporte-dashboard-global.pdf');
    }
}
