<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'idasistencia';

    protected $fillable = [
        'idusuario',
        'idlaboratorio',
        'entrada',
        'salida',
        'fecha',
        'asignatura',
        'cuatrimestre',
        'grupo',
        'carrera',
        'nombre_practica',
    ];

    protected $casts = [
        'entrada' => 'datetime',
        'salida' => 'datetime',
        'fecha' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'idlaboratorio', 'idlab');
    }
}
