<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = 'laboratorio';
    protected $primaryKey = 'idlab';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'ubicacion',
        'estado',
        'qr_token'
    ];
}