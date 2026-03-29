<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Falla;
use App\Models\Equipo;
use App\Models\Laboratorio;
use App\Models\User;
use App\Models\SolicitudSoftware;
use App\Exports\AsistenciasExport;
use App\Exports\FallasExport;
use App\Exports\SolicitudesSoftwareExport;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /**
     * Mostrar el sub-panel principal de Reportes.
     */
    public function index()
    {
        return view('admin.reportes.index');
    }

    /**
     * Módulo de Reportes de Asistencia (Vista con Filtros, Tabla y Gráfica).
     */
    public function asistencias(Request $request)
    {
        $query = Asistencia::with(['usuario', 'laboratorio']);

        // Aplicar filtros
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }
        if ($request->filled('idusuario')) {
            $query->where('idusuario', $request->idusuario);
        }
        if ($request->filled('idlaboratorio')) {
            $query->where('idlaboratorio', $request->idlaboratorio);
        }
        if ($request->filled('carrera')) {
            $query->where('carrera', 'like', '%' . $request->carrera . '%');
        }
        if ($request->filled('grupo')) {
            $query->where('grupo', 'like', '%' . $request->grupo . '%');
        }
        if ($request->filled('cuatrimestre')) {
            $query->where('cuatrimestre', 'like', '%' . $request->cuatrimestre . '%');
        }
        if ($request->filled('asignatura')) {
            $query->where('asignatura', 'like', '%' . $request->asignatura . '%');
        }

        $asistencias = $query->orderBy('fecha', 'desc')->get();

        // Calcular permanencia dinámica y formatear fecha para display si es necesario
        $asistencias->each(function($asistencia) {
            if ($asistencia->entrada && $asistencia->salida) {
                // Calcular minutos
                $minutos = $asistencia->entrada->diffInMinutes($asistencia->salida);
                $horas = floor($minutos / 60);
                $minObtenidos = $minutos % 60;
                $asistencia->permanencia_calc = "{$horas}h {$minObtenidos}m";
            } else {
                $asistencia->permanencia_calc = "Sin registrar";
            }
        });

        // Configuración para Chart.js
        $agrupar = $request->input('agrupar_por', 'laboratorio'); // 'laboratorio' o 'docente'
        
        $graphData = [
            'labels' => [],
            'values' => [],
            'title' => $agrupar == 'laboratorio' ? 'Nivel de Actividad por Laboratorio' : 'Nivel de Actividad por Docente'
        ];

        if($agrupar == 'laboratorio') {
            $grouped = $asistencias->groupBy(function($item) {
                return $item->laboratorio ? $item->laboratorio->nombre : 'Desconocido';
            });
        } else {
            $grouped = $asistencias->groupBy(function($item) {
                return $item->usuario ? trim($item->usuario->nombre . ' ' . $item->usuario->paterno) : 'Desconocido';
            });
        }

        foreach($grouped as $key => $items) {
            $graphData['labels'][] = $key;
            $graphData['values'][] = $items->count();
        }

        // Catálogos para los selects de filtro
        $docentes = User::where('rol', 'Profesor')->get();
        $laboratorios = Laboratorio::all();

        return view('admin.reportes.asistencias.index', compact('asistencias', 'graphData', 'docentes', 'laboratorios', 'agrupar'));
    }

    /**
     * Lógica multifunción para recibir el Request y derivar a Dompdf o Maatwebsite.
     */
    public function exportarAsistencias(Request $request)
    {
        $tipoRespuesta = $request->input('export_type', 'pdf'); // pdf o excel

        if ($tipoRespuesta == 'excel') {
            // El Exportable recibe el propio query request para replicar los filtros adentro
            return Excel::download(new AsistenciasExport($request), 'reporte-asistencias.xlsx');
        }

        // --- LÓGICA DE PDF EXACTAMENTE IGUAL A LA VISTA WEB PARA MANTENER MISMA DATA --- //
        $query = Asistencia::with(['usuario', 'laboratorio']);

        if ($request->filled('fecha_inicio')) $query->whereDate('fecha', '>=', $request->fecha_inicio);
        if ($request->filled('fecha_fin')) $query->whereDate('fecha', '<=', $request->fecha_fin);
        if ($request->filled('idusuario')) $query->where('idusuario', $request->idusuario);
        if ($request->filled('idlaboratorio')) $query->where('idlaboratorio', $request->idlaboratorio);
        if ($request->filled('carrera')) $query->where('carrera', 'like', '%' . $request->carrera . '%');
        if ($request->filled('grupo')) $query->where('grupo', 'like', '%' . $request->grupo . '%');
        if ($request->filled('cuatrimestre')) $query->where('cuatrimestre', 'like', '%' . $request->cuatrimestre . '%');
        if ($request->filled('asignatura')) $query->where('asignatura', 'like', '%' . $request->asignatura . '%');

        $asistencias = $query->orderBy('fecha', 'desc')->get();

        $asistencias->each(function($asistencia) {
            if ($asistencia->entrada && $asistencia->salida) {
                $minutos = $asistencia->entrada->diffInMinutes($asistencia->salida);
                $horas = floor($minutos / 60);
                $min = $minutos % 60;
                $asistencia->permanencia_calc = "{$horas}h {$min}m";
            } else {
                $asistencia->permanencia_calc = "Sin registrar";
            }
        });

        // Para evitar problemas de timeout si el reporte en PDF es masivo
        ini_set('max_execution_time', 300);

        $pdf = Pdf::loadView('admin.reportes.asistencias.pdf', compact('asistencias'))->setPaper('a4', 'landscape');
        return $pdf->download('reporte-asistencias.pdf');
    }

    /**
     * Módulo de Reportes de Fallas (Vista con Filtros, Tabla y Gráfica).
     */
    public function fallas(Request $request)
    {
        $query = Falla::with(['usuario', 'laboratorio', 'equipo']);

        // Aplicar filtros
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }
        if ($request->filled('laboratorio_id')) {
            $query->where('laboratorio_id', $request->laboratorio_id);
        }
        if ($request->filled('tipo_falla')) {
            $query->where('tipo_falla', $request->tipo_falla);
        }
        if ($request->filled('equipo_id')) {
            $query->where('equipo_id', $request->equipo_id);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        $fallas = $query->orderBy('created_at', 'desc')->get();

        // Configuración para Chart.js
        $agrupar = $request->input('agrupar_por', 'laboratorio'); // 'laboratorio' o 'tipo_falla'
        
        $graphData = [
            'labels' => [],
            'values' => [],
            'title' => $agrupar == 'laboratorio' ? 'Fallas reportadas por Laboratorio' : 'Fallas reportadas por Tipo'
        ];

        if($agrupar == 'laboratorio') {
            $grouped = $fallas->groupBy(function($item) {
                return $item->laboratorio ? $item->laboratorio->nombre : 'Desconocido';
            });
        } else {
            $grouped = $fallas->groupBy('tipo_falla');
        }

        foreach($grouped as $key => $items) {
            $graphData['labels'][] = $key ?: 'Sin tipo';
            $graphData['values'][] = $items->count();
        }

        // Catálogos para los selects de filtro
        $usuarios = User::all();
        $laboratorios = Laboratorio::all();
        $equipos = Equipo::all();
        // Tipos de falla únicos extraídos de la BD
        $tipos_falla = Falla::select('tipo_falla')->whereNotNull('tipo_falla')->distinct()->pluck('tipo_falla');

        return view('admin.reportes.fallas.index', compact('fallas', 'graphData', 'usuarios', 'laboratorios', 'equipos', 'tipos_falla', 'agrupar'));
    }

    /**
     * Exportación de Fallas PDF o Excel
     */
    public function exportarFallas(Request $request)
    {
        $tipoRespuesta = $request->input('export_type', 'pdf');

        if ($tipoRespuesta == 'excel') {
            return Excel::download(new FallasExport($request), 'reporte-fallas.xlsx');
        }

        $query = Falla::with(['usuario', 'laboratorio', 'equipo']);

        if ($request->filled('fecha_inicio')) $query->whereDate('created_at', '>=', $request->fecha_inicio);
        if ($request->filled('fecha_fin')) $query->whereDate('created_at', '<=', $request->fecha_fin);
        if ($request->filled('laboratorio_id')) $query->where('laboratorio_id', $request->laboratorio_id);
        if ($request->filled('tipo_falla')) $query->where('tipo_falla', $request->tipo_falla);
        if ($request->filled('equipo_id')) $query->where('equipo_id', $request->equipo_id);
        if ($request->filled('estado')) $query->where('estado', $request->estado);
        if ($request->filled('usuario_id')) $query->where('usuario_id', $request->usuario_id);

        $fallas = $query->orderBy('created_at', 'desc')->get();

        ini_set('max_execution_time', 300);

        $pdf = Pdf::loadView('admin.reportes.fallas.pdf', compact('fallas'))->setPaper('a4', 'landscape');
        return $pdf->download('reporte-fallas.pdf');
    }

    /**
     * Módulo de Reportes de Solicitudes de Software (Vista con Filtros, Tabla y Gráfica Circular).
     */
    public function solicitudesSoftware(Request $request)
    {
        $query = SolicitudSoftware::with(['usuario', 'laboratorio']);

        // Aplicar filtros
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecsolicitud', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecsolicitud', '<=', $request->fecha_fin);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('idlab')) {
            $query->where('idlab', $request->idlab);
        }
        if ($request->filled('idusuario')) {
            $query->where('idusuario', $request->idusuario);
        }

        $solicitudes = $query->orderBy('fecsolicitud', 'desc')->get();

        // Agrupación obligatoria de la Gráfica de Pastel: proporciones por estado de solicitud
        $grouped = $solicitudes->groupBy('estado');
        
        $graphData = [
            'labels' => [],
            'values' => []
        ];

        foreach($grouped as $estado => $items) {
            $graphData['labels'][] = $estado ?: 'Sin definir';
            $graphData['values'][] = $items->count();
        }

        // Catálogos para los selects de filtro
        $docentes = User::where('rol', 'Profesor')->get();
        $laboratorios = Laboratorio::all();
        $estados = SolicitudSoftware::select('estado')->whereNotNull('estado')->distinct()->pluck('estado');

        return view('admin.reportes.solicitudes_software.index', compact('solicitudes', 'graphData', 'docentes', 'laboratorios', 'estados'));
    }

    /**
     * Exportación de Solicitudes PDF o Excel
     */
    public function exportarSolicitudesSoftware(Request $request)
    {
        $tipoRespuesta = $request->input('export_type', 'pdf');

        if ($tipoRespuesta == 'excel') {
            return Excel::download(new SolicitudesSoftwareExport($request), 'reporte-software.xlsx');
        }

        $query = SolicitudSoftware::with(['usuario', 'laboratorio']);

        if ($request->filled('fecha_inicio')) $query->whereDate('fecsolicitud', '>=', $request->fecha_inicio);
        if ($request->filled('fecha_fin')) $query->whereDate('fecsolicitud', '<=', $request->fecha_fin);
        if ($request->filled('estado')) $query->where('estado', $request->estado);
        if ($request->filled('idlab')) $query->where('idlab', $request->idlab);
        if ($request->filled('idusuario')) $query->where('idusuario', $request->idusuario);

        $solicitudes = $query->orderBy('fecsolicitud', 'desc')->get();

        ini_set('max_execution_time', 300);

        $pdf = Pdf::loadView('admin.reportes.solicitudes_software.pdf', compact('solicitudes'))->setPaper('a4', 'landscape');
        return $pdf->download('reporte-software.pdf');
    }
}
