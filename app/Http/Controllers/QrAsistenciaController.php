<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Laboratorio;
use App\Models\Asistencia;

class QrAsistenciaController extends Controller
{
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
        //$url = 'http://192.168.1.65:8000/asistencia/registrar/' . $laboratorio->qr_token;

        return view('admin.laboratorios.qr', compact('laboratorio', 'url'));
    }

    /**
     * Registra la asistencia al escanear el QR.
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

        // Crear registro de asistencia
        $asistencia = Asistencia::create([
            'idusuario' => $user->id,
            'idlaboratorio' => $laboratorio->idlab,
            'entrada' => now(),
            'fecha' => now()->toDateString(),
        ]);

        return view('asistencia.confirmacion', [
            'exito' => true,
            'mensaje' => '¡Asistencia registrada correctamente!',
            'asistencia' => $asistencia,
            'laboratorio' => $laboratorio,
            'usuario' => $user,
        ]);
    }
}
