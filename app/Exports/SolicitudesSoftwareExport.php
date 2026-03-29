<?php

namespace App\Exports;

use App\Models\SolicitudSoftware;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class SolicitudesSoftwareExport implements FromCollection, WithHeadings, WithMapping
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
        $query = SolicitudSoftware::with(['usuario', 'laboratorio']);

        if ($this->request->filled('fecha_inicio')) {
            $query->whereDate('fecsolicitud', '>=', $this->request->fecha_inicio);
        }
        if ($this->request->filled('fecha_fin')) {
            $query->whereDate('fecsolicitud', '<=', $this->request->fecha_fin);
        }
        if ($this->request->filled('estado')) {
            $query->where('estado', $this->request->estado);
        }
        if ($this->request->filled('idlab')) {
            $query->where('idlab', $this->request->idlab);
        }
        if ($this->request->filled('idusuario')) {
            $query->where('idusuario', $this->request->idusuario);
        }

        return $query->orderBy('fecsolicitud', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Docente/Solicitante',
            'Software Solicitado',
            'Laboratorio Destino',
            'Fecha Solicitud',
            'Fecha Instalación (Estimada/Real)',
            'Estado',
            'Observaciones Adicionales',
        ];
    }

    public function map($sol): array
    {
        return [
            $sol->idsolSoftware,
            $sol->usuario ? trim($sol->usuario->nombre . ' ' . $sol->usuario->paterno) : 'N/A',
            $sol->software,
            $sol->laboratorio ? $sol->laboratorio->nombre : 'N/A',
            $sol->fecsolicitud ? date('d/m/Y', strtotime($sol->fecsolicitud)) : '',
            $sol->fecinstalacion ? date('d/m/Y', strtotime($sol->fecinstalacion)) : 'Sin instalar',
            $sol->estado,
            $sol->comentario,
        ];
    }
}
