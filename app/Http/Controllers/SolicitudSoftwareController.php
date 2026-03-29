<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudSoftware;
use App\Models\Laboratorio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\NotificacionService;
use App\Mail\NuevaSolicitudSoftwareMail;
use App\Mail\CambioEstadoSolicitudMail;


class SolicitudSoftwareController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudSoftware::where('idusuario', Auth::id())->get();

        return view('profesor.solicitudes.index', compact('solicitudes'));
    }

    public function create()
    {
      
        $laboratorios = Laboratorio::all();
        return view('profesor.solicitudes.create', compact('laboratorios'));
    }

    public function store(Request $request)
    {
        $solicitud = SolicitudSoftware::create([
            'idusuario' => Auth::id(),
            'idlab' => $request->idlab,
            'software' => $request->software,
            'fecsolicitud' => now(),
            'estado' => 'Pendiente',
            'comentario' => $request->comentario
        ]);

        // Cargar relaciones para el email
        $solicitud->load(['usuario', 'laboratorio']);

        // Notificar a todos los técnicos
        $tecnicos = User::where('rol', 'Técnico')->get();
        foreach ($tecnicos as $tecnico) {
            NotificacionService::crear(
                $tecnico->id,
                'solicitud_nueva',
                'Nueva solicitud de software: ' . $request->software . ' (por ' . Auth::user()->nombre . ')'
            );
            Mail::to($tecnico->email)->send(new NuevaSolicitudSoftwareMail($solicitud));
        }

        return redirect('/profesor')->with('success', 'Solicitud enviada');
    }
    public function all(Request $request)
    {
        // 🔒 Validación de rol
        if (!in_array(Auth::user()->rol, ['Admin', 'Técnico'])) {  // Changed to Auth::user()
            abort(403);
        }

        // 🔍 Consulta con relaciones
        $query = SolicitudSoftware::with(['usuario', 'laboratorio']);

        // 🔍 FILTROS
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->docente) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->docente . '%');
            });
        }

        if ($request->fecha) {
            $query->whereDate('fecsolicitud', $request->fecha);
        }

        $solicitudes = $query->get();

        // 🎯 Vista según rol
        if (Auth::user()->rol == 'Técnico') {  // Changed to Auth::user() and standardized role name
            return view('tecnico.solicitudes.index', compact('solicitudes'));
        }

        return view('admin.solicitudes.index', compact('solicitudes'));
    }
    public function edit($id)
    {
        $user = Auth::user();
        if (!$user || ($user->rol !== 'Admin' && $user->rol !== 'Técnico')) {
            abort(403);
        }

        $solicitud = SolicitudSoftware::findOrFail($id);
        return view('admin.solicitudes.edit', compact('solicitud'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || ($user->rol !== 'Admin' && $user->rol !== 'Técnico')) {
            abort(403);
        }

        $solicitud = SolicitudSoftware::findOrFail($id);

        $solicitud->update([
            'estado' => $request->estado,
            'comentario_tecnico' => $request->comentario_tecnico
        ]);

        // Notificar al docente del cambio de estado
        $solicitud->load('usuario');
        if ($solicitud->usuario) {
            NotificacionService::crear(
                $solicitud->idusuario,
                'solicitud_estado',
                'Tu solicitud de "' . $solicitud->software . '" fue ' . strtolower($request->estado) . '.'
            );
            Mail::to($solicitud->usuario->email)->send(
                new CambioEstadoSolicitudMail($solicitud, $request->estado, $request->comentario_tecnico)
            );
        }

        return redirect('/admin/solicitudes')->with('success', 'Solicitud actualizada');
    }
    public function destroy($id)
    {
        $solicitud = SolicitudSoftware::findOrFail($id);
        $solicitud->delete();

        return redirect()->back()->with('success', 'Solicitud eliminada');
    }

}
