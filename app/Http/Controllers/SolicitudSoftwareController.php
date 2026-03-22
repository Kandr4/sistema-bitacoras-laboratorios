<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudSoftware;
use App\Models\Laboratorio;
use Illuminate\Support\Facades\Auth;


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
        SolicitudSoftware::create([
            'idusuario' => Auth::id(),
            'idlab' => $request->idlab,
            'software' => $request->software,
            'fecsolicitud' => now(),
            'estado' => 'Pendiente',
            'comentario' => $request->comentario
        ]);

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
        return redirect('/admin/solicitudes')->with('success', 'Solicitud enviada');
    }
    public function destroy($id)
    {
        $solicitud = SolicitudSoftware::findOrFail($id);
        $solicitud->delete();

        return redirect()->back()->with('success', 'Solicitud eliminada');
    }

}
