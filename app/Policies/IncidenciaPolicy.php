<?php

namespace App\Policies;

use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncidenciaPolicy
{
    use HandlesAuthorization;

    // Ver incidencia
    public function view(User $user, Incidencia $incidencia)
    {
        if ($user->rol === 'admin') return true;
        return $user->id === $incidencia->idtecnico;
    }

    // Editar incidencia
    public function update(User $user, Incidencia $incidencia)
    {
        if ($user->rol === 'admin') return true;
        return $user->id === $incidencia->idtecnico;
    }

    // Permitir eliminar
    public function delete(User $user, Incidencia $incidencia)
    {
        // Admin puede eliminar todo
        if ($user->rol === 'admin') return true;

        // Técnico solo puede eliminar si es su incidencia **y aún está pendiente**
        return $user->id === $incidencia->user_id && $incidencia->estado === 'pendiente';
    }
}