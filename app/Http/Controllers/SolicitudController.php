<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Laboratorio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    public function create()
    {
        $laboratorios = Laboratorio::all();
        return view('tecnico.solicitudesCompra.create', compact('laboratorios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'descripcion' => 'required',
            'caracteristicas' => 'required',
            'costo_unitario' => 'required|numeric',
            'justificacion' => 'required',
            'laboratorio_id' => 'required',
            'imagen' => 'nullable|image'
        ]);

        $imagen = $request->hasFile('imagen') ? $request->file('imagen')->store('solicitudes', 'public') : null;

        Solicitud::create([
            'user_id' => Auth::id(),
            'laboratorio_id' => $request->laboratorio_id,
            'cantidad' => $request->cantidad,
            'descripcion' => $request->descripcion,
            'caracteristicas' => $request->caracteristicas,
            'costo_unitario' => $request->costo_unitario,
            'justificacion' => $request->justificacion,
            'imagen' => $imagen,
            'estado' => 'pendiente'
        ]);

        return redirect()->route('tecnico.solicitudesCompra.index')
                         ->with('success', 'Solicitud creada');
    }

    public function index(Request $request)
    {
        $query = Solicitud::with(['laboratorio', 'tecnico', 'admin']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('laboratorio_id')) {
            $query->where('laboratorio_id', $request->laboratorio_id);
        }

        if ($request->filled('tecnico_id')) {
            $query->where('user_id', $request->tecnico_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $solicitudes = $query->latest()->get();

        // Datos para filtros en la vista
        $laboratorios = Laboratorio::all();
        $tecnicos = User::where('rol', 'tecnico')->get();

        return view('tecnico.solicitudesCompra.index', compact('solicitudes', 'laboratorios', 'tecnicos'));
    }

    public function show($id)
    {
        $solicitud = Solicitud::with(['tecnico', 'laboratorio', 'admin'])->findOrFail($id);
        return view('tecnico.solicitudesCompra.show', compact('solicitud'));
    }

   public function actualizarEstadoAdmin(Request $request, $id)
{
    $solicitud = Solicitud::findOrFail($id);

    $request->validate([
        'estado' => 'required|in:autorizada,rechazada,en_proceso',
        'comentario_admin' => 'nullable|string'
    ]);

    $solicitud->estado = $request->estado;
    $solicitud->comentario_admin = $request->comentario_admin;
    $solicitud->validado_por = Auth::id(); // Quién valida/actualiza

    $solicitud->save();

    return redirect()->route('admin.solicitudesCompra.index')
                     ->with('success', 'Estado actualizado correctamente.');
}

public function indexAdmin(Request $request)
{
    
    $query = Solicitud::with(['laboratorio','tecnico','admin']);

    if ($request->filled('estado')) $query->where('estado', $request->estado);
    if ($request->filled('laboratorio_id')) $query->where('laboratorio_id', $request->laboratorio_id);
    if ($request->filled('tecnico_id')) $query->where('user_id', $request->tecnico_id);
    if ($request->filled('fecha_desde')) $query->whereDate('created_at', '>=', $request->fecha_desde);
    if ($request->filled('fecha_hasta')) $query->whereDate('created_at', '<=', $request->fecha_hasta);

    $solicitudes = $query->latest()->get();
    //dd($solicitudes->first()->toArray());
    $laboratorios = \App\Models\Laboratorio::all();
    $tecnicos = \App\Models\User::where('rol','tecnico')->get();

    return view('admin.solicitudesCompra.index', compact('solicitudes','laboratorios','tecnicos'));
}

public function showAdmin($id)
{
    $solicitud = Solicitud::with(['laboratorio','tecnico','admin'])->findOrFail($id);
    return view('admin.solicitudesCompra.show', compact('solicitud'));
}
}