<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimiento';
    protected $primaryKey = 'idmantenimiento';


    protected $fillable = [
        'idusuario',
        'idlab',
        'fechaHora',
        'totalequipos',
        'equiposoperativos',
        'equiposreparacion',
        'preventivos',
        'correctivos',
        'reprogramados',
        'estado'
    ];
    
    public function usuario(){
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class, 'idlab');
    }
}
