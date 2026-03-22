<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Add this import


class MantenimientoController extends Controller
{

    public function index()
    {
        $mantenimientos = Mantenimiento::where('estado', 1)
            ->with(['usuario', 'laboratorio'])
            ->get();
        return view('tecnico.mantenimiento.index', compact('mantenimientos'));
    }
    public function adminIndex(Request $request)
{
    $query = Mantenimiento::with(['usuario', 'laboratorio']);

    // 🔍 FILTRO POR LABORATORIO
    if ($request->idlab) {
        $query->where('idlab', $request->idlab);
    }

    // 🔍 FILTRO POR TÉCNICO
    if ($request->tecnico) {
        $query->whereHas('usuario', function($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->tecnico . '%');
        });
    }

    // 🔍 FILTRO POR FECHA
    if ($request->fecha) {
        $query->whereDate('fechaHora', $request->fecha);
    }

    // 🔍 FILTRO POR ESTADO (ejemplo: equipos en reparación)
    if ($request->estado) {
        if ($request->estado == 'operativo') {
            $query->where('equiposreparacion', 0);
        }

        if ($request->estado == 'reparacion') {
            $query->where('equiposreparacion', '>', 0);
        }
    }

    $mantenimientos = $query->get();
    $laboratorios = Laboratorio::all();

    return view('admin.mantenimiento.index', compact('mantenimientos', 'laboratorios'));
}
    public function create()
    {
        $laboratorios = Laboratorio::all();
        return view('tecnico.mantenimiento.create', compact('laboratorios'));
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(401, 'Usuario no autenticado');
        }

        // ✅ VALIDACIONES COMPLETAS
        $request->validate([
            'idlab' => 'required',
            'totalequipos' => 'required|integer|min:1',
            'equiposoperativos' => 'required|integer|min:0',
            'equiposreparacion' => 'required|integer|min:0',
            'preventivos' => 'required|integer|min:0',
            'correctivos' => 'required|integer|min:0',
            'reprogramados' => 'required|integer|min:0',
        ]);

        // 🚨 EVITAR DUPLICADOS (MISMO LAB + MISMO DÍA)
        $existe = Mantenimiento::where('idlab', $request->idlab)
            ->whereDate('fechaHora', now()->toDateString())
            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'Ya existe un mantenimiento registrado hoy para este laboratorio']);
        }

        // ✅ GUARDAR
        Mantenimiento::create([
            'idusuario' => Auth::id(),
            'idlab' => $request->idlab,
            'fechaHora' => now(),
            'totalequipos' => $request->totalequipos,
            'equiposoperativos' => $request->equiposoperativos,
            'equiposreparacion' => $request->equiposreparacion,
            'preventivos' => $request->preventivos,
            'correctivos' => $request->correctivos,
            'reprogramados' => $request->reprogramados,
            'estado' => 1 
        ]);

        // 🔁 REDIRECCIÓN CORRECTA
        return redirect()->route('tecnico.mantenimiento.index')
            ->with('success', 'Mantenimiento registrado correctamente');
    }
    public function edit($id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);
        $laboratorios = Laboratorio::all();

        return view('tecnico.mantenimiento.edit', compact('mantenimiento', 'laboratorios'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'idlab' => 'required',
            'totalequipos' => 'required|integer|min:1',
            'equiposoperativos' => 'required|integer|min:0',
            'equiposreparacion' => 'required|integer|min:0',
            'preventivos' => 'required|integer|min:0',
            'correctivos' => 'required|integer|min:0',
            'reprogramados' => 'required|integer|min:0',
        ]);

        $mantenimiento = Mantenimiento::findOrFail($id);

        $mantenimiento->update($request->all());

        return redirect()->route('tecnico.mantenimiento.index')
            ->with('success', 'Mantenimiento actualizado');
    }

    public function destroy($id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);

        $mantenimiento->estado = 0;
        $mantenimiento->save();

        return redirect()->back()->with('success', 'Registro eliminado');
    }
}