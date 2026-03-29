<?php

namespace App\Services;

use App\Models\Notificacion;

class NotificacionService
{
    /**
     * Crear una notificación interna para un usuario.
     */
    public static function crear(int $userId, string $tipo, string $mensaje, ?string $url = null): void
    {
        Notificacion::create([
            'user_id' => $userId,
            'tipo' => $tipo,
            'mensaje' => $mensaje,
            'url' => $url,
        ]);
    }

    /**
     * Crear la misma notificación interna para múltiples usuarios.
     */
    public static function crearParaMultiples(array $userIds, string $tipo, string $mensaje, ?string $url = null): void
    {
        foreach ($userIds as $userId) {
            self::crear($userId, $tipo, $mensaje, $url);
        }
    }
}
