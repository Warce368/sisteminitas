<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\Auditoria;

class RegistrarCierreSesion
{
    public function handle(Logout $event): void
    {
        Auditoria::create([
            'user_id'     => $event->user->id,
            'accion'      => 'logout',
            'tabla'       => 'ninguna',
            'registro_id' => $event->user->id,
            'descripcion' => 'Cierre de sesión',
        ]);
    }
}
