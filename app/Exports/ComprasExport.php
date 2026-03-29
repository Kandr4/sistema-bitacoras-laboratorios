<?php

namespace App\Exports;

use App\Models\Solicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class ComprasExport implements FromCollection, WithHeadings, WithMapping
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
        $query = Solicitud::with(['tecnico', 'laboratorio']);

        if ($this->request->filled('fecha_inicio')) {
            $query->whereDate('fecha_solicitud', '>=', $this->request->fecha_inicio);
        }
        if ($this->request->filled('fecha_fin')) {
            $query->whereDate('fecha_solicitud', '<=', $this->request->fecha_fin);
        }
        if ($this->request->filled('estado')) {
            $query->where('estado', $this->request->estado);
        }
        if ($this->request->filled('idlab')) {
            $query->where('laboratorio_id', $this->request->idlab);
        }
        if ($this->request->filled('idusuario')) {
            $query->where('user_id', $this->request->idusuario);
        }
        if ($this->request->filled('costo_min')) {
            $query->where('costo_unitario', '>=', $this->request->costo_min);
        }
        if ($this->request->filled('costo_max')) {
            $query->where('costo_unitario', '<=', $this->request->costo_max);
        }

        return $query->orderBy('fecha_solicitud', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha Solicitud',
            'Técnico / Requisitor',
            'Producto / Equipo',
            'Cantidad',
            'Costo Ud ($)',
            'Laboratorio Destino',
            'Estado',
            'Características',
            'Justificación'
        ];
    }

    public function map($compra): array
    {
        return [
            $compra->id,
            $compra->fecha_solicitud ? date('d/m/Y', strtotime($compra->fecha_solicitud)) : '',
            $compra->tecnico ? trim($compra->tecnico->nombre . ' ' . $compra->tecnico->paterno) : 'N/A',
            $compra->descripcion,
            $compra->cantidad,
            $compra->costo_unitario ? number_format($compra->costo_unitario, 2, '.', '') : '0.00',
            $compra->laboratorio ? $compra->laboratorio->nombre : 'N/A',
            $compra->estado,
            $compra->caracteristicas,
            $compra->justificacion,
        ];
    }
}
