<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudSoftware extends Model
{
    protected $table = 'solicitud_software';
    protected $primaryKey = 'idsolSoftware';
    public $timestamps = false;

    protected $fillable = [
        'idusuario',
        'idlab',
        'software',
        'fecsolicitud',
        'estado',
        'comentario',
        'fecinstalacion'
    ];

    public function usuario(){
    return $this->belongsTo(User::class, 'idusuario');
}

    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class, 'idlab');
    }
}