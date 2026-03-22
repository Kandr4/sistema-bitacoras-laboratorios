<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $fillable = [
    'user_id',
    'laboratorio_id',
    'cantidad',
    'descripcion',
    'caracteristicas',
    'costo_unitario',
    'justificacion',
    'imagen',
    'estado',
    'comentario_admin',
    'validado_por',
    'fecha_solicitud'
];

// 🔹 relaciones
public function tecnico()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function laboratorio()
{
    // 'laboratorio_id' = campo en solicitudes
    // 'idlab' = PK en laboratorio
    return $this->belongsTo(Laboratorio::class, 'laboratorio_id', 'idlab');
}

public function admin()
{
    return $this->belongsTo(User::class, 'validado_por');
}


}
