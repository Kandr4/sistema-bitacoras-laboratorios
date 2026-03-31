<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialBackup extends Model
{
    protected $fillable = [
        'user_id',
        'tipo_operacion',
        'archivo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
