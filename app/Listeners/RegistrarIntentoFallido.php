<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\Auditoria;

class RegistrarIntentoFallido
{
    public function handle(Failed $event): void
    {
        Auditoria::create([
            'user_id'     => null,
            'accion'      => 'login_failed',
            'tabla'       => 'ninguna',
            'registro_id' => 0,
            'descripcion' => 'Intento de inicio de sesión fallido con email: ' . ($event->credentials['email'] ?? 'desconocido'),
        ]);
    }
}
