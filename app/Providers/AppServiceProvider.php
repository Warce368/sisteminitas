<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\RegistrarInicioSesion;
use App\Listeners\RegistrarCierreSesion;
use Illuminate\Auth\Events\Failed;
use App\Listeners\RegistrarIntentoFallido;

use Illuminate\Support\ServiceProvider;
use App\Models\Zona;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Antena;
use App\Models\Pago;
use App\Models\Direccion;
use App\Observers\AuditoriaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Zona::observe(AuditoriaObserver::class);
        Servicio::observe(AuditoriaObserver::class);
        Cliente::observe(AuditoriaObserver::class);
        Direccion::observe(AuditoriaObserver::class);

        Antena::observe(AuditoriaObserver::class);
    }
    protected $listen = [
        Login::class => [
            RegistrarInicioSesion::class,
        ],
        Logout::class => [
            RegistrarCierreSesion::class,
        ],
        Failed::class => [
            RegistrarIntentoFallido::class,
        ],
    ];
}
