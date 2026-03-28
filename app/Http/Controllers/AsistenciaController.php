<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asistencia;
use App\Models\Laboratorio;
use App\Models\User;

class AsistenciaController extends Controller
{
    // ──────────────────────────────────────────────
    // PROFESOR — Solo lectura de sus propias asistencias
    // ──────────────────────────────────────────────

    public function historialProfesor()
    {
        $user = Auth::user();

        if ($user->rol !== 'Profesor') {
            abort(403, 'Acceso no autorizado.');
        }

        $asistencias = Asistencia::where('idusuario', $user->id)
            ->where('estado', 'activa')
            ->with('laboratorio')
            ->orderBy('fecha', 'desc')
            ->orderBy('entrada', 'desc')
            ->paginate(15);

        return view('profesor.asistencias.index', compact('asistencias'));
    }

    public function registrarSalida($id)
    {
        $user = Auth::user();

        if ($user->rol !== 'Profesor') {
            abort(403, 'Acceso no autorizado.');
        }

        $asistencia = Asistencia::findOrFail($id);

        // Validar propiedad
        if ($asistencia->idusuario !== $user->id) {
            abort(403, 'No tienes permiso para modificar esta asistencia.');
        }

        // Validar que no tenga salida ya
        if ($asistencia->salida !== null) {
            return redirect()->route('profesor.asistencias.index')
                ->with('error', 'Esta asistencia ya tiene registrada una salida.');
        }

        // Validar que esté activa
        if ($asistencia->estado !== 'activa') {
            abort(404);
        }

        $asistencia->salida = now();
        $asistencia->save();

        return redirect()->route('profesor.asistencias.salida.confirmacion', $asistencia->idasistencia);
    }

    public function confirmacionSalida($id)
    {
        $user = Auth::user();

        if ($user->rol !== 'Profesor') {
            abort(403, 'Acceso no autorizado.');
        }

        $asistencia = Asistencia::with('laboratorio')->findOrFail($id);

        if ($asistencia->idusuario !== $user->id) {
            abort(403, 'No tienes permiso para ver esta asistencia.');
        }

        // Calcular permanencia
        $diff = $asistencia->entrada->diff($asistencia->salida);
        $permanencia = '';
        if ($diff->h > 0) {
            $permanencia .= $diff->h . 'h ';
        }
        $permanencia .= $diff->i . 'min';

        return view('profesor.asistencias.salida', compact('asistencia', 'permanencia'));
    }

    // ──────────────────────────────────────────────
    // TÉCNICO — Solo lectura de todas las asistencias con filtro
    // ──────────────────────────────────────────────

    public function indexTecnico(Request $request)
    {
        $user = Auth::user();

        if ($user->rol !== 'Técnico') {
            abort(403, 'Acceso no autorizado.');
        }

        $query = Asistencia::with(['usuario', 'laboratorio'])
            ->where('estado', 'activa');

        // Filtro por laboratorio
        if ($request->filled('idlaboratorio')) {
            $query->where('idlaboratorio', $request->idlaboratorio);
        }

        // Filtro por docente
        if ($request->filled('idusuario')) {
            $query->where('idusuario', $request->idusuario);
        }

        $asistencias = $query->orderBy('fecha', 'desc')->orderBy('entrada', 'desc')->paginate(15);

        // Datos para los selects de filtro
        $laboratorios = Laboratorio::all();
        $docentes = User::where('rol', 'Profesor')->get();

        return view('tecnico.asistencias.index', compact('asistencias', 'laboratorios', 'docentes'));
    }

    // ──────────────────────────────────────────────
    // ADMIN — Gestión completa
    // ──────────────────────────────────────────────

    public function indexAdmin(Request $request)
    {
        $user = Auth::user();

        if ($user->rol !== 'Admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $query = Asistencia::with(['usuario', 'laboratorio'])
            ->where('estado', 'activa');

        // Filtro por docente
        if ($request->filled('idusuario')) {
            $query->where('idusuario', $request->idusuario);
        }

        // Filtro por laboratorio
        if ($request->filled('idlaboratorio')) {
            $query->where('idlaboratorio', $request->idlaboratorio);
        }

        // Filtro por rango de fecha
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }

        // Filtro por asignatura
        if ($request->filled('asignatura')) {
            $query->where('asignatura', $request->asignatura);
        }

        // Filtro por grupo
        if ($request->filled('grupo')) {
            $query->where('grupo', $request->grupo);
        }

        $asistencias = $query->orderBy('fecha', 'desc')->orderBy('entrada', 'desc')->paginate(20);

        // Datos para los selects de filtro
        $laboratorios = Laboratorio::all();
        $docentes = User::where('rol', 'Profesor')->get();
        $asignaturas = QrAsistenciaController::ASIGNATURAS;
        $grupos = QrAsistenciaController::GRUPOS;

        return view('admin.asistencias.index', compact(
            'asistencias', 'laboratorios', 'docentes', 'asignaturas', 'grupos'
        ));
    }

    public function editAdmin($id)
    {
        $user = Auth::user();

        if ($user->rol !== 'Admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $asistencia = Asistencia::with(['usuario', 'laboratorio'])->findOrFail($id);
        $laboratorios = Laboratorio::all();
        $asignaturas = QrAsistenciaController::ASIGNATURAS;
        $carreras = QrAsistenciaController::CARRERAS;
        $cuatrimestres = QrAsistenciaController::CUATRIMESTRES;
        $grupos = QrAsistenciaController::GRUPOS;

        return view('admin.asistencias.edit', compact(
            'asistencia', 'laboratorios', 'asignaturas', 'carreras', 'cuatrimestres', 'grupos'
        ));
    }

    public function updateAdmin(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->rol !== 'Admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $asistencia = Asistencia::findOrFail($id);

        $validated = $request->validate([
            'idlaboratorio' => 'required|exists:laboratorio,idlab',
            'entrada' => 'required|date',
            'salida' => 'nullable|date|after_or_equal:entrada',
            'fecha' => 'required|date',
            'asignatura' => 'nullable|string|in:' . implode(',', QrAsistenciaController::ASIGNATURAS),
            'cuatrimestre' => 'nullable|integer|min:1|max:15',
            'grupo' => 'nullable|string|in:' . implode(',', QrAsistenciaController::GRUPOS),
            'carrera' => 'nullable|string|in:' . implode(',', QrAsistenciaController::CARRERAS),
            'nombre_practica' => 'nullable|string|max:255',
        ]);

        $asistencia->update($validated);

        return redirect()->route('admin.asistencias.index')
            ->with('success', 'Asistencia actualizada correctamente.');
    }

    public function inactivarAdmin($id)
    {
        $user = Auth::user();

        if ($user->rol !== 'Admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $asistencia = Asistencia::findOrFail($id);
        $asistencia->estado = 'inactiva';
        $asistencia->save();

        return redirect()->route('admin.asistencias.index')
            ->with('success', 'Registro de asistencia eliminado correctamente.');
    }
}
