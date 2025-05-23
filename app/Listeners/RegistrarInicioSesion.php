<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Auditoria;

class RegistrarInicioSesion
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        Auditoria::create([
            'user_id'     => $event->user->id,
            'accion'      => 'login',
            'tabla'       => 'ninguna',
            'registro_id' => $event->user->id,
            'descripcion' => 'Inicio de sesión',
        ]);
    }
}
