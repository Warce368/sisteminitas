<?php

use App\Models\Zona;
use App\Models\Servicio;
use App\Models\Cliente;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AntenaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditoriaController;


// Rutas públicas para login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/inicio');
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden.',
    ]);
});

// Ruta para vista de inicio, protegida con autenticación
Route::get('/inicio', function () {
    return view('Inicio.index');
})->middleware('auth');

// Ruta para logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Rutas exclusivas para ADMINISTRADOR
    Route::middleware('role:ADMINISTRADOR')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');
        // Más rutas para administrador aquí
    });

    // Rutas exclusivas para OPERADOR (vacío por ahora)
    Route::middleware('role:OPERADOR')->group(function () {
        // Rutas solo para operador si las hubiera
    });

    // Rutas accesibles para ambos roles (ADMINISTRADOR y OPERADOR)
    Route::resource('zonas', ZonaController::class);
    Route::resource('direcciones', DireccionController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('antenas', AntenaController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('pagos', PagoController::class);
    Route::get('historial', [PagoController::class, 'mostrarHistorial']);
    Route::get('historial/cliente', [PagoController::class, 'mostrarHistorialAño']);

    Route::get('/imagen-mapa', [MapaController::class, 'mostrar'])->name('imagen.mapa');
    Route::get('/mapa-antenas', function () {
        return view('antenasmapa.index'); // Carga tu vista normal con layout
    });
    



    // Rutas específicas para pagos
    Route::delete('/pagos-mes', [PagoController::class, 'destroyMes'])->name('pagos.destroyMes');
    Route::post('/pagos/guardar-todo', [PagoController::class, 'guardarTodo'])->name('pagos.guardarTodo');
    Route::post('/pagos/sincronizar', [PagoController::class, 'sincronizarClientesMesActual'])->name('pagos.sincronizar');

    // Ruta raíz redirige a vista de inicio
    
});
