<?php

namespace App\Exports;

use App\Models\Asistencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class AsistenciasExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Asistencia::with(['usuario', 'laboratorio']);

        if ($this->request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $this->request->fecha_inicio);
        }
        if ($this->request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $this->request->fecha_fin);
        }
        if ($this->request->filled('idusuario')) {
            $query->where('idusuario', $this->request->idusuario);
        }
        if ($this->request->filled('idlaboratorio')) {
            $query->where('idlaboratorio', $this->request->idlaboratorio);
        }
        if ($this->request->filled('carrera')) {
            $query->where('carrera', 'like', '%' . $this->request->carrera . '%');
        }
        if ($this->request->filled('grupo')) {
            $query->where('grupo', 'like', '%' . $this->request->grupo . '%');
        }
        if ($this->request->filled('cuatrimestre')) {
            $query->where('cuatrimestre', 'like', '%' . $this->request->cuatrimestre . '%');
        }
        if ($this->request->filled('asignatura')) {
            $query->where('asignatura', 'like', '%' . $this->request->asignatura . '%');
        }

        return $query->orderBy('fecha', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Docente',
            'Laboratorio',
            'Fecha',
            'Entrada',
            'Salida',
            'Permanencia',
            'Carrera',
            'Cuatrimestre',
            'Grupo',
            'Asignatura',
            'Práctica'
        ];
    }

    public function map($asistencia): array
    {
        $permanencia = "Sin registrar";
        
        if ($asistencia->entrada && $asistencia->salida) {
            $minutos = $asistencia->entrada->diffInMinutes($asistencia->salida);
            $horas = floor($minutos / 60);
            $min = $minutos % 60;
            $permanencia = "{$horas}h {$min}m";
        }

        return [
            $asistencia->idasistencia,
            $asistencia->usuario ? trim($asistencia->usuario->nombre . ' ' . $asistencia->usuario->paterno) : 'N/A',
            $asistencia->laboratorio ? $asistencia->laboratorio->nombre : 'N/A',
            $asistencia->fecha ? $asistencia->fecha->format('d/m/Y') : '',
            $asistencia->entrada ? $asistencia->entrada->format('H:i') : '',
            $asistencia->salida ? $asistencia->salida->format('H:i') : 'Sin salida',
            $permanencia,
            $asistencia->carrera,
            $asistencia->cuatrimestre,
            $asistencia->grupo,
            $asistencia->asignatura,
            $asistencia->nombre_practica,
        ];
    }
}
