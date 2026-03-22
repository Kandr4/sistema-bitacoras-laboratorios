<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\Laboratorio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::with(['tecnico','usuario','laboratorio'])
                  ->latest()
                  ->get();
        return view('tecnico.incidencias.index', compact('incidencias'));
    }

    public function create()
    {
        $laboratorios = Laboratorio::all();
       $usuarios = \App\Models\User::whereIn('rol', ['Técnico', 'Profesor'])->get();;
        return view('tecnico.incidencias.create', compact('laboratorios','usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idlab' => 'required|exists:laboratorio,idlab',
            'fechahora' => 'required|date',
            'descripcion' => 'required|string',
            'firmadigital' => 'required|string',
        ]);

        Incidencia::create([
            'user_id' => Auth::id(),         
            'idusuario' => $request->idusuario,
            'idlab' => $request->idlab,
            'idequipo' => $request->idequipo,
            'fechahora' => $request->fechahora,
            'descripcion' => $request->descripcion,
            'solucion' => $request->solucion,
            'observaciones' => $request->observaciones,
            'firmadigital' => $request->firmadigital,
            'estado' => "pendiente",
        ]);

        return redirect()->route('tecnico.incidencias.index')->with('success', 'Incidencia registrada correctamente.');
    }

public function show(Incidencia $incidencia)
{
    // Solo permitir que el técnico que creó la incidencia la vea
    if(Auth::user()->rol === 'tecnico' && Auth::id() !== $incidencia->user_id) {
        abort(403, 'Acción no autorizada.');
    }

    // Obtener datos necesarios para el formulario
    $laboratorios = \App\Models\Laboratorio::all();
    $usuarios = \App\Models\User::where('rol','!=','admin')->get();

    return view('tecnico.incidencias.show', compact('incidencia','laboratorios','usuarios'));
}

public function update(Request $request, Incidencia $incidencia)
{
    $this->authorize('update', $incidencia);

    $data = $request->validate([
        'idlab' => 'required|exists:laboratorio,idlab',
        'idusuario' => 'nullable|exists:users,id',
        'fechahora' => 'required|date',
        'idequipo' => 'nullable|string|max:255',
        'descripcion' => 'required|string',
        'solucion' => 'nullable|string',
        'observaciones' => 'nullable|string',
        'firmadigital' => 'nullable|string',
    ]);

    $incidencia->update($data);

    return redirect()->route('tecnico.incidencias.index')
                     ->with('success', 'Incidencia actualizada correctamente.');
}

public function destroy(Incidencia $incidencia)
{
    $this->authorize('delete', $incidencia); // valida la política

    $incidencia->delete();

    return redirect()->route('tecnico.incidencias.index')
                     ->with('success', 'Incidencia eliminada correctamente.');
}
}