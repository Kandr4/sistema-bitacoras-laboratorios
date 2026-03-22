<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\Laboratorio;
use App\Models\User;

class AdminIncidenciaController extends Controller
{
        public function index(Request $request)
    {
        $query = Incidencia::with(['usuario','tecnico','laboratorio']);

        // Aplicar filtros
        if($request->fecha_inicio && $request->fecha_fin){
            $query->whereBetween('fechahora', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if($request->idusuario){
            $query->where('idusuario', $request->idusuario);
        }

        if($request->idlab){
            $query->where('idlab', $request->idlab);
        }

        if($request->tecnico_id){
            $query->where('user_id', $request->tecnico_id);
        }

        if($request->tipo){
            $query->where('tipo_incidencia', $request->tipo); // Asegúrate de tener esta columna
        }

        $incidencias = $query->latest()->paginate(20);

        // Para los selects de filtro
        $usuarios = User::where('rol','!=','admin')->get();
        $laboratorios = Laboratorio::all();
        $tecnicos = User::where('rol','Técnico')->get();

        return view('admin.incidencias.index', compact('incidencias','usuarios','laboratorios','tecnicos'));
    }

    public function edit(Incidencia $incidencia)
    {
        $laboratorios = Laboratorio::all();
        $usuarios = User::where('rol','!=','admin')->get();

        return view('admin.incidencias.edit', compact('incidencia','laboratorios','usuarios'));
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        $data = $request->validate([
            'idlab' => 'required|exists:laboratorio,idlab',
            'idusuario' => 'nullable|exists:users,id',
            'fechahora' => 'required|date',
            'idequipo' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'solucion' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'firmadigital' => 'nullable|string',
            'estado' => 'required|in:pendiente,en proceso,resuelto,inactivo', // agregar inactivo para baja lógica
        ]);

        $incidencia->update($data);

        return redirect()->route('admin.incidencias.index')
                         ->with('success', 'Incidencia actualizada correctamente.');
    }

    // Baja lógica: cambiar estado a "inactivo"
    public function inactivar(Incidencia $incidencia)
    {
        $incidencia->estado = 'inactivo';
        $incidencia->save();

        return redirect()->route('admin.incidencias.index')
                         ->with('success', 'Incidencia inactivada correctamente.');
    }
}