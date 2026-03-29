<?php

namespace App\Exports;

use App\Models\Falla;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class FallasExport implements FromCollection, WithHeadings, WithMapping
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
        $query = Falla::with(['usuario', 'laboratorio', 'equipo']);

        if ($this->request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $this->request->fecha_inicio);
        }
        if ($this->request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $this->request->fecha_fin);
        }
        if ($this->request->filled('laboratorio_id')) {
            $query->where('laboratorio_id', $this->request->laboratorio_id);
        }
        if ($this->request->filled('tipo_falla')) {
            $query->where('tipo_falla', $this->request->tipo_falla);
        }
        if ($this->request->filled('equipo_id')) {
            $query->where('equipo_id', $this->request->equipo_id);
        }
        if ($this->request->filled('estado')) {
            $query->where('estado', $this->request->estado);
        }
        if ($this->request->filled('usuario_id')) {
            $query->where('usuario_id', $this->request->usuario_id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Equipo',
            'Tipo de Falla',
            'Laboratorio',
            'Descripción',
            'Estado',
            'Reportante',
        ];
    }

    public function map($falla): array
    {
        return [
            $falla->id,
            $falla->created_at ? $falla->created_at->format('d/m/Y H:i') : '',
            $falla->equipo ? $falla->equipo->nombre : 'N/A',
            $falla->tipo_falla,
            $falla->laboratorio ? $falla->laboratorio->nombre : 'N/A',
            $falla->descripcion,
            $falla->estado,
            $falla->usuario ? trim($falla->usuario->nombre . ' ' . $falla->usuario->paterno) : 'N/A',
        ];
    }
}
