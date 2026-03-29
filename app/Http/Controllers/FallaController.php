<?php

namespace App\Http\Controllers;

use App\Models\Falla;
use App\Models\Laboratorio;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificacionService;

class FallaController extends Controller
{
    // Solo docentes y técnicos pueden crear
    public function __construct()
{
    $this->middleware('auth'); // Solo usuarios autenticados
}

    public function index(Request $request)
    {
        // Filtrado por laboratorio, tipo, estado o usuario
        $fallas = Falla::with(['usuario','laboratorio','equipo'])
            ->when($request->laboratorio_id, fn($q) => $q->where('laboratorio_id', $request->laboratorio_id))
            ->when($request->tipo_falla, fn($q) => $q->where('tipo_falla', $request->tipo_falla))
            ->when($request->estado, fn($q) => $q->where('estado', $request->estado))
            ->when($request->usuario_id, fn($q) => $q->where('usuario_id', $request->usuario_id))
            ->paginate(10);

        $laboratorios = Laboratorio::all();
        $usuarios = \App\Models\User::whereIn('rol', ['Profesor','Técnico'])->get();

        return view('fallas.index', compact('fallas','laboratorios','usuarios'));
    }

    public function create()
    {
        $laboratorios = Laboratorio::all();
        $equipos = Equipo::all(); // Podrías filtrar por laboratorio con JS en el formulario
        return view('fallas.create', compact('laboratorios','equipos'));
    }

   public function store(Request $request)
{
    $request->validate([
        'laboratorio_id' => 'required|exists:laboratorio,idlab',
        'equipo_id' => 'required|exists:equipos,id',
        'tipo_falla' => 'required|in:hardware,software,red,perifericos,otros',
        'descripcion' => 'required|string',
    ]);

    Falla::create([
        'usuario_id' => Auth::id(),
        'laboratorio_id' => $request->laboratorio_id,
        'equipo_id' => $request->equipo_id,
        'tipo_falla' => $request->tipo_falla,
        'descripcion' => $request->descripcion,
        'estado' => 'pendiente'
    ]);

    // 🔥 REDIRECCIÓN SEGÚN ROL
    if (Auth::user()->rol === 'Profesor') {
        return redirect()->route('profesor.fallas.index')
            ->with('success','Falla registrada correctamente.');
    }

    return redirect()->route('fallas.index')
        ->with('success','Falla registrada correctamente.');
}
    public function indexProfesor()
{
    $fallas = Falla::with(['laboratorio','equipo'])
        ->where('usuario_id', Auth::id()) // 🔥 SOLO SUS FALLAS
        ->latest()
        ->paginate(10);

    return view('profesor.fallas.index', compact('fallas'));
}

    public function edit(Falla $falla)
    {
        $laboratorios = Laboratorio::all();
        $equipos = Equipo::all();
        return view('fallas.edit', compact('falla','laboratorios','equipos'));
    }

    public function update(Request $request, Falla $falla)
    {
        $request->validate([
            'tipo_falla' => 'required|in:hardware,software,red,perifericos,otros',
            'descripcion' => 'required|string',
            'estado' => 'required|in:pendiente,en revision,resuelto',
        ]);

        $estadoAnterior = $falla->estado;

        $falla->update($request->all());

        // Notificar al usuario si la falla fue marcada como resuelta
        if ($request->estado === 'resuelto' && $estadoAnterior !== 'resuelto') {
            NotificacionService::crear(
                $falla->usuario_id,
                'falla_resuelta',
                'Tu reporte de falla ha sido marcado como resuelto.'
            );
        }

        return redirect()->route('fallas.index')->with('success','Falla actualizada correctamente.');
    }

    public function destroy(Falla $falla)
    {
        $falla->delete();
        return redirect()->route('fallas.index')->with('success','Falla eliminada correctamente.');
    }
}