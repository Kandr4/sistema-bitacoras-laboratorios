<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratorio; 
class LaboratorioController extends Controller
{
    public function index()
    {
        $laboratorios = Laboratorio::all();
        return view('admin.laboratorios.index', compact('laboratorios'));
    }

    public function create()
    {
        return view('admin.laboratorios.create');
    }

    public function store(Request $request)
    {
        Laboratorio::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
        ]);

        return redirect()->route('admin.laboratorios.index')
            ->with('success', 'Laboratorio creado correctamente');
    }

    public function edit(Laboratorio $laboratorio)
    {
        return view('admin.laboratorios.edit', compact('laboratorio'));
    }

    public function update(Request $request, Laboratorio $laboratorio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        $laboratorio->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'estado' => $request->has('estado') ? 'Activo' : 'Inactivo',
        ]);

        return redirect()->route('admin.laboratorios.index')
            ->with('success', 'Laboratorio actualizado correctamente');
    }

    public function destroy(Laboratorio $laboratorio)
    {
        // El laboratorio no tiene soft-deletes, así que se elimina totalmente
        $laboratorio->delete();

        return redirect()->route('admin.laboratorios.index')
            ->with('success', 'Laboratorio eliminado correctamente');
    }
}