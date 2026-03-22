<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'incidencias';
    protected $primaryKey = 'idincidencia';
    
    protected $fillable = [
        'user_id',
        'idusuario',
        'idlab',
        'idequipo',
        'fechahora',
        'descripcion',
        'solucion',
        'observaciones',
        'firmadigital',
        'estado'
    ];

    public function tecnico() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function usuario() {
        return $this->belongsTo(User::class,'idusuario');
    }

    public function laboratorio() {
        return $this->belongsTo(Laboratorio::class,'idlab','idlab');
    }
}