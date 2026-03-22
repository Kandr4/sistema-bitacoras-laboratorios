<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Laboratorio;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    // Solo el administrador puede usar este CRUD
    public function __construct()
    {
        $this->middleware('auth'); // o 'role:Administrador' si implementas roles
    }

    // Mostrar todos los equipos
    public function index()
    {
        $equipos = Equipo::with('laboratorio')->paginate(10);
        return view('admin.equipos.index', compact('equipos'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        $laboratorios = Laboratorio::all();
        return view('admin.equipos.create', compact('laboratorios'));
    }

    // Guardar nuevo equipo
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'laboratorio_id' => 'required|exists:laboratorio,idlab', // o tabla/campo correctos
        'descripcion' => 'nullable|string',
    ]);

    Equipo::create($request->all());
    return redirect()->route('admin.equipos.index')->with('success', 'Equipo creado correctamente.');
}

    

    // Mostrar detalle de un equipo
    public function show(Equipo $equipo)
    {
        return view('admin.equipos.show', compact('equipo'));
    }

    // Mostrar formulario para editar
    public function edit(Equipo $equipo)
    {
        $laboratorios = Laboratorio::all();
        return view('admin.equipos.edit', compact('equipo', 'laboratorios'));
    }

    // Actualizar equipo
    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'laboratorio_id' => 'required|exists:laboratorio,idlab',
            'descripcion' => 'nullable|string',
        ]);

        $equipo->update($request->all());

        return redirect()->route('admin.equipos.index')->with('success', 'Equipo actualizado correctamente.');
    }

    // Eliminar equipo
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('admin.equipos.index')->with('success', 'Equipo eliminado correctamente.');
    }
}