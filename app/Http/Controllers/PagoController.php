<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Pago;
use App\Models\Zona;
use Illuminate\Http\Request;
use  App\Models\Cliente; // 👈 Asegúrate de importar el modelo Cliente
use Carbon\Carbon; // Asegúrate de importar Carbon
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $buscar = $request->get('buscar');

        // Recibir filtro mes y año o usar mes y año actual por defecto


        $mesFiltro = (int) $request->get('mes', Carbon::now()->month);
        $anioFiltro = (int) $request->get('anio', Carbon::now()->year);

        $query = Pago::with('cliente.servicio', 'cliente.direccion.zona');

        if ($buscar) {
            $query->whereHas('cliente', function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%");
            });
        }

        if ($mesFiltro && $anioFiltro) {
            $query->whereMonth('fecha_plazo', $mesFiltro)
                ->whereYear('fecha_plazo', $anioFiltro);
        }

        $pagos = $query->paginate($cantidad);

        // Obtener meses y años únicos con pagos
        $mesesAnios = Pago::select(
            DB::raw('MONTH(fecha_plazo) as mes'),
            DB::raw('YEAR(fecha_plazo) as anio')
        )
            ->distinct()
            ->orderBy('anio', 'desc')
            ->orderBy('mes', 'desc')
            ->get();



        $clientes = Cliente::with('servicio')->get();

        return view('pagos.index', compact('pagos', 'clientes', 'mesesAnios', 'mesFiltro', 'anioFiltro'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(request $request)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_plazo' => 'required|date',
        ]);

        $fechaActual = \Carbon\Carbon::parse($request->fecha_plazo);
        $mesInput = $fechaActual->month;
        $anioInput = $fechaActual->year;

        $existeMes = Pago::whereMonth('fecha_plazo', $mesInput)
            ->whereYear('fecha_plazo', $anioInput)
            ->exists();

        if ($existeMes) {
            return redirect()->route('pagos.index')->with('error', 'Ya existen pagos creados para ese mes y año.');
        }

        $clientes = Cliente::with('servicio')->get();

        foreach ($clientes as $cliente) {
            if ($cliente->estado === 'ACTIVO') {
                $mesAnterior = $fechaActual->copy()->subMonth();
                $pagoAnterior = Pago::where('id_cliente', $cliente->id_cliente)
                    ->whereYear('fecha_plazo', $mesAnterior->year)
                    ->whereMonth('fecha_plazo', $mesAnterior->month)
                    ->first();

                $saldoPendiente = 0;

                if ($pagoAnterior) {
                    $debe = $pagoAnterior->monto_debe ?? 0;
                    $pagado = $pagoAnterior->monto_pagado ?? 0;
                    $saldoPendiente = $debe - $pagado;
                }

                // Obtener monto del plan mensual del servicio
                $montoPlan = $cliente->servicio->valor_servicio ?? 0;

                Pago::create([
                    'id_cliente' => $cliente->id_cliente,
                    'fecha_plazo' => $request->fecha_plazo,
                    'monto_debe' => $saldoPendiente + $montoPlan,
                    'monto_pagado' => null,
                    'descripcion_pago' => null,
                    'fecha_cancelada' => null,
                ]);
            }
        }
        return redirect()->route('pagos.index')->with('success', 'Pagos creados exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pago $pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);

        // Obtener valores del request con valores por defecto en caso de null
        $monto_debe = $request->input("monto_debe_{$id}", 0);
        $monto_pagado = $request->input("monto_pagado_{$id}", 0);
        $fecha_cancelada = $request->input("fecha_cancelada_{$id}", null);
        $descripcion_pago = $request->input("descripcion_pago_{$id}", '');

        // Asignar los valores al modelo
        $pago->monto_debe = $monto_debe;
        $pago->monto_pagado = $monto_pagado;
        $pago->fecha_cancelada = $fecha_cancelada;
        $pago->descripcion_pago = $descripcion_pago;

        $pago->save();

        // Solo actualiza, no realiza ninguna suma ni crea pagos nuevos

        return redirect()->route('pagos.index', [
            'mes' => \Carbon\Carbon::parse($pago->fecha_plazo)->month,
            'anio' => \Carbon\Carbon::parse($pago->fecha_plazo)->year
        ])->with('success', 'Pago actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pago $pago)
    {
        //
    }

    /**
     * Eliminar pagos del  mes actual en pantalla
     */

    public function destroyMes(Request $request)
    {
        $mes = $request->input('mes'); // número del mes, ej: 5
        $anio = $request->input('anio'); // año, ej: 2025

        if (!$mes || !$anio) {
            return redirect()->back()->with('error', 'Debe seleccionar mes y año.');
        }

        $pagosBorrados = Pago::whereYear('fecha_plazo', $anio)
            ->whereMonth('fecha_plazo', $mes)
            ->delete();

        if ($pagosBorrados > 0) {
            // Buscar el primer mes y año disponibles después de eliminar
            $nuevoMesAnio = Pago::select(
                DB::raw('MONTH(fecha_plazo) as mes'),
                DB::raw('YEAR(fecha_plazo) as anio')
            )
                ->distinct()
                ->orderBy('anio', 'desc')
                ->orderBy('mes', 'desc')
                ->first();

            if ($nuevoMesAnio) {
                return redirect()->route('pagos.index', [
                    'mes' => $nuevoMesAnio->mes,
                    'anio' => $nuevoMesAnio->anio
                ])->with('success', 'Se borraron los pagos del mes seleccionado.');
            } else {
                return redirect()->route('pagos.index')->with('success', 'Se borraron los pagos del mes seleccionado.');
            }
        }
    }




    public function guardarTodo(Request $request)
    {
        $mes  = $request->input('mes');
        $anio = $request->input('anio');

        $pagos = Pago::whereYear('fecha_plazo', $anio)
            ->whereMonth('fecha_plazo', $mes)
            ->get();

        foreach ($pagos as $pago) {
            $id = $pago->id_pago;

            // Guarda valores antiguos antes del update
            $montoDebeAnterior   = $pago->monto_debe;
            $montoPagadoAnterior = $pago->monto_pagado;
            $fechaAnterior       = $pago->fecha_cancelada;
            $descripcionAnterior = $pago->descripcion_pago;

            $nuevoDebe   = $request->input("monto_debe_{$id}");
            $nuevoPagado = $request->input("monto_pagado_{$id}");
            $nuevaFecha  = $request->input("fecha_cancelada_{$id}");
            $nuevaDesc   = $request->input("descripcion_pago_{$id}");

            // Formatea la fecha para que la comparación sea correcta
            $fechaAnteriorFormateada = $fechaAnterior ? Carbon::parse($fechaAnterior)->format('Y-m-d') : null;
            $nuevaFechaFormateada    = $nuevaFecha;

            // Verifica si hay algún cambio
            $hayCambios =
                $nuevoDebe   != $montoDebeAnterior ||
                $nuevoPagado != $montoPagadoAnterior ||
                $nuevaFechaFormateada != $fechaAnteriorFormateada ||
                $nuevaDesc   != $descripcionAnterior;

            if ($hayCambios) {
                $pago->update([
                    'monto_debe'       => $nuevoDebe,
                    'monto_pagado'     => $nuevoPagado,
                    'fecha_cancelada'  => $nuevaFecha,
                    'descripcion_pago' => $nuevaDesc,
                ]);

                $descripcion = "Cambios: ";
                $cambios = [];

                if ($nuevoDebe != $montoDebeAnterior) {
                    $cambios[] = "monto que debe de {$montoDebeAnterior} a {$nuevoDebe}";
                }

                if ($nuevoPagado != $montoPagadoAnterior) {
                    $cambios[] = "monto pagado de {$montoPagadoAnterior} a {$nuevoPagado}";
                }

                if ($nuevaFechaFormateada != $fechaAnteriorFormateada) {
                    $cambios[] = "fecha cancelada de {$fechaAnteriorFormateada} a {$nuevaFechaFormateada}";
                }

                if ($nuevaDesc != $descripcionAnterior) {
                    $cambios[] = "descripción de '{$descripcionAnterior}' a '{$nuevaDesc}'";
                }

                $descripcion .= implode(', ', $cambios);

                Auditoria::create([
                    'user_id'     => Auth::id(),
                    'accion'      => 'update',
                    'tabla'       => 'pagos',
                    'registro_id' => $id,
                    'descripcion' => $descripcion,
                ]);
            }
        }

        return redirect()->route('pagos.index', [
            'mes'  => $mes,
            'anio' => $anio,
        ])->with('success', 'Pagos actualizados correctamente');
    }


    public function sincronizarClientesMesActual(Request $request)
    {
        $mes  = $request->input('mes', date('m'));
        $anio = $request->input('anio', date('Y'));

        $clientesConPago = Pago::whereYear('fecha_plazo', $anio)
            ->whereMonth('fecha_plazo', $mes)
            ->pluck('id_cliente')
            ->toArray();

        $clientesNuevos = Cliente::with('servicio')
            ->whereNotIn('id_cliente', $clientesConPago)
            ->get();

        foreach ($clientesNuevos as $cliente) {
            $mesAnterior = \Carbon\Carbon::create($anio, $mes, 1)->subMonth();

            $pagoAnterior = Pago::where('id_cliente', $cliente->id_cliente)
                ->whereYear('fecha_plazo', $mesAnterior->year)
                ->whereMonth('fecha_plazo', $mesAnterior->month)
                ->first();

            $saldoPendiente = 0;

            if ($pagoAnterior) {
                $debe = $pagoAnterior->monto_debe ?? 0;
                $pagado = $pagoAnterior->monto_pagado ?? 0;
                $saldoPendiente = $debe - $pagado;
            }

            $montoPlan = $cliente->servicio->valor_servicio ?? 0;

            Pago::create([
                'id_cliente' => $cliente->id_cliente,
                'fecha_plazo' => \Carbon\Carbon::create($anio, $mes, 1),
                'monto_debe' => $saldoPendiente + $montoPlan,
                'monto_pagado' => 0,
                'descripcion_pago' => null,
                'fecha_cancelada' => null,
            ]);
        }

        return redirect()->route('pagos.index', ['mes' => $mes, 'anio' => $anio])
            ->with('success', 'Clientes sincronizados correctamente para el mes actual.');
    }














    public function mostrarHistorial(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $buscar = $request->get('buscar');
        $zonaId = $request->get('id_zona');
        $tipoDocumento = $request->get('tipo_documento');


        $mesFiltro = (int) $request->get('mes', Carbon::now()->month);
        $anioFiltro = (int) $request->get('anio', Carbon::now()->year);

        $query = Pago::with('cliente.servicio', 'cliente.direccion.zona');

        if ($buscar) {
            $query->whereHas('cliente', function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%");
            });
        }

        if ($zonaId) {
            $query->whereHas('cliente.direccion.zona', function ($q) use ($zonaId) {
                $q->where('id_zona', $zonaId);
            });
        }

        if ($tipoDocumento) {
            $query->whereHas('cliente', function ($q) use ($tipoDocumento) {
                $q->where('tipo_documento', $tipoDocumento);
            });
        }


        if ($mesFiltro && $anioFiltro) {
            $query->whereMonth('fecha_plazo', $mesFiltro)
                ->whereYear('fecha_plazo', $anioFiltro);
        }

        $pagos = $query->paginate($cantidad);

        $mesesAnios = Pago::select(
            DB::raw('MONTH(fecha_plazo) as mes'),
            DB::raw('YEAR(fecha_plazo) as anio')
        )
            ->distinct()
            ->orderBy('anio', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        $zonas = Zona::all();
        $clientes = Cliente::with('servicio')->get();

        return view('historial.index', compact(
            'pagos',
            'clientes',
            'mesesAnios',
            'mesFiltro',
            'anioFiltro',
            'zonas',
            'zonaId',
            'tipoDocumento'
        ));
    }


















    public function mostrarHistorialAño(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $zonaId = $request->get('id_zona');
        $tipoDocumento = $request->get('tipo_documento');
        $clienteId = $request->get('id_cliente'); // <-- nuevo filtro

        $anioFiltro = (int) $request->get('anio', Carbon::now()->year);

        $query = Pago::with('cliente.servicio', 'cliente.direccion.zona');

        if ($zonaId) {
            $query->whereHas('cliente.direccion.zona', function ($q) use ($zonaId) {
                $q->where('id_zona', $zonaId);
            });
        }

        if ($tipoDocumento) {
            $query->whereHas('cliente', function ($q) use ($tipoDocumento) {
                $q->where('tipo_documento', $tipoDocumento);
            });
        }

        if ($clienteId) {
            $query->where('id_cliente', $clienteId);
        }

        if ($anioFiltro) {
            $query->whereYear('fecha_plazo', $anioFiltro);
        }

        $pagos = $query->paginate($cantidad);

        $mesesAnios = Pago::select(
            DB::raw('MONTH(fecha_plazo) as mes'),
            DB::raw('YEAR(fecha_plazo) as anio')
        )
            ->distinct()
            ->orderBy('anio', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        $zonas = Zona::all();
        $clientes = Cliente::all();
        $mesFiltro = null;
        return view('historialcliente.index', compact(
            'pagos',
            'clientes',
            'mesesAnios',
            'anioFiltro',
            'zonas',
            'zonaId',
            'tipoDocumento',
            'clienteId',
            'mesFiltro' // <-- aquí lo agregas
        ));
    }
}

// HASTA ACA CREA,  GUARDA ,ACTUALIZA , BORRA POR FECHA  |  OBJETIVO -> GUARDAR EN MASA 
//        HASTA ACA  FUNCIONA TODO ,  CREA FECHA,  BORRA  PERO NO GUARDA;