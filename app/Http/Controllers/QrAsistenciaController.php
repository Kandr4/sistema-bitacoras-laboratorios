<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Laboratorio;
use App\Models\Asistencia;

class QrAsistenciaController extends Controller
{
    // Catálogo de asignaturas predefinidas
    public const ASIGNATURAS = [
        'Programación Estructurada',
        'Programación Orientada a Objetos',
        'Estructura de Datos',
        'Base de Datos',
        'Redes',
        'Sistemas Operativos',
        'Ingeniería de Software',
    ];

    // Catálogo de carreras predefinidas
    public const CARRERAS = [
        'Ingeniería en Tecnologías de la Información e Innovación Digital',
        'Ingeniería en Sistemas Electrónicos',
        'Ingeniería en Biotecnología',
        'Ingeniería Industrial',
        'Ingeniería Financiera',
        'Licenciatura en Administración',
    ];

    // Cuatrimestres del 1 al 15
    public const CUATRIMESTRES = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];

    // Grupos de la A a la F
    public const GRUPOS = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

    /**
     * Genera (o regenera) el qr_token UUID del laboratorio y muestra la vista del QR.
     * POST admin/laboratorios/{idlab}/qr
     */
    public function generarQr($idlab)
    {
        $laboratorio = Laboratorio::findOrFail($idlab);

        // Generar nuevo token UUID
        $laboratorio->qr_token = Str::uuid()->toString();
        $laboratorio->save();

        return redirect()->route('admin.laboratorios.qr.ver', $idlab)
            ->with('success', 'Código QR generado correctamente.');
    }

    /**
     * Muestra el QR ya generado para imprimir/descargar.
     * GET admin/laboratorios/{idlab}/qr
     */
    public function mostrarQr($idlab)
    {
        $laboratorio = Laboratorio::findOrFail($idlab);

        if (!$laboratorio->qr_token) {
            return redirect()->route('admin.laboratorios.index')
                ->with('error', 'Este laboratorio aún no tiene un código QR. Genera uno primero.');
        }

        // URL que el profesor escaneará
        $url = route('asistencia.registrar', $laboratorio->qr_token);

        return view('admin.laboratorios.qr', compact('laboratorio', 'url'));
    }

    /**
     * Registra la asistencia al escanear el QR y redirige al formulario de datos de práctica.
     * GET /asistencia/registrar/{token}
     */
    public function registrar($token)
    {
        // Buscar laboratorio por token
        $laboratorio = Laboratorio::where('qr_token', $token)->first();

        if (!$laboratorio) {
            return view('asistencia.confirmacion', [
                'exito' => false,
                'mensaje' => 'El código QR no es válido o ha sido regenerado.',
            ]);
        }

        // Verificar que el usuario sea Profesor
        $user = Auth::user();

        if ($user->rol !== 'Profesor') {
            return view('asistencia.confirmacion', [
                'exito' => false,
                'mensaje' => 'Solo los profesores pueden registrar asistencia mediante código QR.',
            ]);
        }

        // Crear registro de asistencia (sin datos de práctica aún)
        $asistencia = Asistencia::create([
            'idusuario' => $user->id,
            'idlaboratorio' => $laboratorio->idlab,
            'entrada' => now(),
            'fecha' => now()->toDateString(),
        ]);

        // Redirigir a la página de confirmación con formulario
        return redirect()->route('asistencia.confirmar', $asistencia->idasistencia);
    }

    /**
     * Muestra la página de confirmación con el formulario de datos de práctica.
     * GET /asistencia/confirmar/{idasistencia}
     */
    public function confirmar($idasistencia)
    {
        $asistencia = Asistencia::findOrFail($idasistencia);
        $user = Auth::user();

        // Verificar que la asistencia pertenece al usuario actual
        if ($asistencia->idusuario !== $user->id) {
            abort(403, 'No tienes permiso para acceder a esta asistencia.');
        }

        $laboratorio = $asistencia->laboratorio;

        return view('asistencia.confirmacion', [
            'exito' => true,
            'mensaje' => '¡Asistencia registrada correctamente!',
            'asistencia' => $asistencia,
            'laboratorio' => $laboratorio,
            'usuario' => $user,
            'asignaturas' => self::ASIGNATURAS,
            'carreras' => self::CARRERAS,
            'cuatrimestres' => self::CUATRIMESTRES,
            'grupos' => self::GRUPOS,
        ]);
    }

    /**
     * Guarda los datos de práctica en la asistencia.
     * POST /asistencia/confirmar/{idasistencia}
     */
    public function guardarDatosPractica(Request $request, $idasistencia)
    {
        $asistencia = Asistencia::findOrFail($idasistencia);
        $user = Auth::user();

        // Verificar que la asistencia pertenece al usuario actual
        if ($asistencia->idusuario !== $user->id) {
            abort(403, 'No tienes permiso para modificar esta asistencia.');
        }

        $validated = $request->validate([
            'asignatura' => 'required|string|in:' . implode(',', self::ASIGNATURAS),
            'cuatrimestre' => 'required|integer|min:1|max:15',
            'grupo' => 'required|string|in:' . implode(',', self::GRUPOS),
            'carrera' => 'required|string|in:' . implode(',', self::CARRERAS),
            'nombre_practica' => 'required|string|max:255',
        ]);

        $asistencia->update($validated);

        return redirect()->route('asistencia.confirmar', $asistencia->idasistencia)
            ->with('success', 'Datos de la práctica guardados correctamente.');
    }
}
