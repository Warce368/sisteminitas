@extends('layouts.main')

@section('content')
<h1>PAGOS</h1>
<button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#create">
    AGREGAR
</button>

<button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#delete">
    BORRAR MES
</button>

<button type="submit" class="btn bg-success mb-2  " form="form-pagos" style="color: white;">
    ACTUALIZAR
</button>
<form action="{{ route('pagos.sincronizar') }}" method="POST" style="display:inline-block;">
    @csrf
    <button type="submit" class="btn btn-warning mb-2  d-none" style="color: white;">
        SINCRONIZAR
    </button>
</form>

<!-- Filtro y cantidad por página -->
<!-- Filtros con diseño compacto, responsive y modo oscuro -->
<form method="GET" class="row gy-2 gx-2 align-items-center mb-3 text-white">

    <!-- Filtro de mes y año -->
    <div class="col-12 col-sm-6 col-md-3">
        <label class="form-label mb-1 text-white">Hasta:</label>
        @php

            \Carbon\Carbon::setLocale('es');
            
        @endphp
        <select name="mes" class="form-select bg-dark text-white border-secondary small-select"
            onchange="this.form.submit()">
            @foreach ($mesesAnios as $item)
            <option value="{{ $item->mes }}" {{ $mesFiltro==$item->mes && $anioFiltro == $item->anio ? 'selected' : ''
                }}>
                {{ \Carbon\Carbon::create()->month($item->mes)->locale('es')->translatedFormat('F') }} {{ $item->anio }}
            </option>
            @endforeach
        </select>
    </div>

    <!-- Filtro por cantidad -->
    <div class="col-6 col-sm-6 col-md-2">
        <label class="form-label mb-1 text-white">Registros:</label>
        <select name="cantidad" class="form-select bg-dark text-white border-secondary small-select"
            onchange="this.form.submit()">
            <option value="10" {{ request('cantidad')==10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ request('cantidad')==20 ? 'selected' : '' }}>20</option>
            <option value="30" {{ request('cantidad')==30 ? 'selected' : '' }}>30</option>
        </select>
    </div>

    <!-- Filtro por nombre -->
    <div class="col-12 col-sm-8 col-md-4">
        <label class="form-label mb-1 text-white">Buscar:</label>
        <input type="text" name="buscar" class="form-control bg-dark text-white border-secondary"
            placeholder="Buscar por nombre" value="{{ request('buscar') }}">
    </div>

    <!-- Botón -->
    <div class="col-12 col-sm-4 col-md-3 d-grid align-self-end">
        <button type="submit" class="btn btn-outline-light w-100">
            <i class="bi bi-search"></i> Buscar
        </button>
    </div>
</form>


<div class="table-responsive d-none d-lg-block">
    <!-- Mensajes de éxito y error -->
    @if(session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>¡Atención!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    <!-- TABLASA -->

    <form method="POST" action="{{ route('pagos.guardarTodo') }}" id="form-pagos">
        @csrf

        <input type="hidden" name="mes" value="{{ $mesFiltro }}">
        <input type="hidden" name="anio" value="{{ $anioFiltro }}">
        <table class="table-hover align-middle table-bordered darkmode">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">PLAN</th>

                    <th scope="col">
                        Total hasta el 1 de
                        {{ \Carbon\Carbon::createFromDate($anioFiltro,
                        $mesFiltro)->addMonth()->locale('es')->translatedFormat('F \d\e Y') }}
                    </th>
                    <th scope="col">MONTO PAGADO</th>
                    <th scope="col">FECHA_CANCELADA</th>
                    <th scope="col">DESCRIPCION</th>

                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($pagos as $pago)
                @php
                $resta = $pago->monto_debe - $pago->monto_pagado;
                @endphp

                <tr>
                    <td>{{ $pago->id_pago }}
                    </td>

                    <td style="
    background-color: {{ $resta <= 0 ? '#d4edda' : ($resta > 0 ? '#f8d7da' : 'transparent') }};
    color: {{ $resta <= 0 ? '#155724' : ($resta > 0 ? '#721c24' : 'black') }};
    font-weight: bold;
    font-size: 1.1em;
">
                        {{ $pago->cliente->nombre }}</td>


                    <td>{{ $pago->cliente->servicio->descripcion}}</td>


                    <!-- Campos editables fuera del form principal -->
                    <td>
                        <input type="number" step="0.01" name="monto_debe_{{ $pago->id_pago }}" class="sin-borde"
                            value="{{ old('monto_debe_'.$pago->id_pago, $pago->monto_debe ?? $pago->cliente->servicio->valor_servicio) }}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="monto_pagado_{{ $pago->id_pago }}" class="sin-borde"
                            value="{{ $pago->monto_pagado }}">
                    </td>
                    <td>
                        <input type="date" name="fecha_cancelada_{{ $pago->id_pago }}" class="sin-borde"
                            value="{{ $pago->fecha_cancelada }}">
                    </td>
                    <td>
                        <input type="text" name="descripcion_pago_{{ $pago->id_pago }}" class="sin-borde"
                            value="{{ $pago->descripcion_pago }}">
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="12">No hay pagos registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </form>
</div>

<!-- Versión Móvil (tarjetas colapsables) -->
<div class="d-block d-lg-none">
    <input type="hidden" name="mes" value="{{ $mesFiltro }}">
    <input type="hidden" name="anio" value="{{ $anioFiltro }}">

    <div class="accordion" id="pagosAccordion">
        @forelse ($pagos as $pago)
        @php
        $resta = $pago->monto_debe - $pago->monto_pagado;
        $collapseId = 'collapse' . $pago->id_pago;
        $fechaFormateada = $pago->fecha_cancelada ? \Carbon\Carbon::parse($pago->fecha_cancelada)->format('Y-m-d') : '';
        @endphp

        <div class="card mb-3 bg-dark text-white border-secondary">
            <div class="card-header d-flex justify-content-between align-items-center py-2" style="background-color: {{ $resta <= 0 ? '#d4edda' : ($resta > 0 ? '#f8d7da' : '#343a40') }};
                        color: {{ $resta <= 0 ? '#155724' : ($resta > 0 ? '#721c24' : 'white') }};"
                data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false"
                aria-controls="{{ $collapseId }}">
                <div class="d-flex align-items-center">
                    <span class="me-2">{{ $pago->cliente->nombre }}</span>
                    @if($resta <= 0) <span class="badge bg-success ms-2">✅</span> @endif
                </div>
                <div>
                    <span class="badge bg-primary">ID: {{ $pago->id_pago }}</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </div>
            </div>

            <div id="{{ $collapseId }}" class="collapse" data-bs-parent="#pagosAccordion">
                <div class="card-body">
                    <form method="POST" action="{{ route('pagos.update', $pago->id_pago) }}"
                        class="form-pago-individual">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="mes" value="{{ $mesFiltro }}">
                        <input type="hidden" name="anio" value="{{ $anioFiltro }}">

                        <div class="row mb-3">
                            <div class="col-12 mb-2">
                                <label class="small text-info fw-bold">PLAN DE SERVICIO</label>
                                <div class="fw-bold text-white">{{ $pago->cliente->servicio->descripcion }}</div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="small text-info fw-bold">PERIODO</label>
                                <div class="fw-bold text-white">
                                    Hasta el 1 {{ \Carbon\Carbon::createFromDate($anioFiltro,
                                    $mesFiltro)->addMonth()->locale('es')->translatedFormat('F \d\e Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- MONTO DEBE -->
                            <div class="col-12 col-md-6">
                                <label class="d-block mb-2 fw-bold text-success" style="font-size: 0.85rem;">
                                    <i class="bi bi-cash-stack me-1"></i> MONTO DEBE
                                </label>
                                <input type="number" step="0.01" name="monto_debe_{{ $pago->id_pago }}"
                                    class="form-control bg-dark text-white border-secondary py-2"
                                    style="min-height: 48px; font-size: 1.1rem;" value="{{ $pago->monto_debe }}">
                            </div>

                            <!-- MONTO PAGADO -->
                            <div class="col-12 col-md-6">
                                <label class="d-block mb-2 fw-bold text-success" style="font-size: 0.85rem;">
                                    <i class="bi bi-cash-coin me-1"></i> MONTO PAGADO
                                </label>
                                <input type="number" step="0.01" name="monto_pagado_{{ $pago->id_pago }}"
                                    class="form-control bg-dark text-white border-secondary py-2"
                                    style="min-height: 48px; font-size: 1.1rem;" value="{{ $pago->monto_pagado }}">
                            </div>

                            <!-- FECHA CANCELADA -->
                            <div class="col-12 col-md-6">
                                <label class="d-block mb-2 fw-bold text-warning" style="font-size: 0.85rem;">
                                    <i class="bi bi-calendar-date me-1"></i> FECHA CANCELADA
                                </label>
                                <input type="date" name="fecha_cancelada_{{ $pago->id_pago }}"
                                    class="form-control bg-dark text-white border-secondary py-2"
                                    style="min-height: 48px; font-size: 1.1rem;" value="{{ $fechaFormateada }}">

                            </div>

                            <!-- DESCRIPCIÓN -->
                            <div class="col-12 col-md-6">
                                <label class="d-block mb-2 fw-bold text-primary" style="font-size: 0.85rem;">
                                    <i class="bi bi-card-text me-1"></i> DESCRIPCIÓN
                                </label>
                                <input type="text" name="descripcion_pago_{{ $pago->id_pago }}"
                                    class="form-control bg-dark text-white border-secondary py-2"
                                    style="min-height: 48px; font-size: 1.1rem;" value="{{ $pago->descripcion_pago }}">
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-success py-2" style="font-size: 1.1rem;">
                                <i class="bi bi-save-fill me-2"></i> ACTUALIZAR PAGO
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info">No hay pagos registrados</div>
        @endforelse
    </div>
</div>

<!-- Paginación -->
<div class="d-flex justify-content-center mt-3">
    {{ $pagos->links('pagination::bootstrap-5') }}
</div>

@include('pagos.create')
@include('pagos.delete')
@endsection

<style>
    /* Estilos generales */
    .small-select {
        padding: 0.4rem 0.5rem;
        font-size: 0.9rem;
    }

    /* Estilos para el acordeón */
    .card-header {
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .card-header:hover {
        filter: brightness(90%);
    }

    .card-header .bi-chevron-down {
        transition: transform 0.3s;
    }

    .card-header[aria-expanded="true"] .bi-chevron-down {
        transform: rotate(180deg);
    }

    /* Estilos para inputs en modo oscuro */
    .form-control,
    .form-select {
        background-color: #1a1a1a !important;
        color: white !important;
        border-color: #444 !important;
    }

    .form-control:focus {
        background-color: #222 !important;
        color: white !important;
        border-color: #555 !important;
        box-shadow: 0 0 0 0.25rem rgba(100, 100, 100, 0.25);
    }

    /* Estilos para desktop (tabla normal) */
    @media (min-width: 992px) {
        input.sin-borde {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0.25rem 0.5rem !important;
            margin: 0 !important;
            width: 100%;
            height: 2.5rem;
            text-align: center;
            font-size: 1rem;
            font-family: inherit;
        }

        input.sin-borde:focus {
            background: #161616 !important;
            color: #fff !important;
        }

        table.darkmode {
            background-color: #121212 !important;
            color: #eee !important;
            border-collapse: collapse !important;
            width: 100%;
            border: 1px solid #333 !important;
        }

        table.darkmode th,
        table.darkmode td {
            border: 1px solid #333 !important;
            padding: 0.5rem !important;
        }

        table.darkmode thead {
            background-color: #222 !important;
            color: #eee !important;
        }

        table.darkmode tbody tr:hover {
            background-color: #333 !important;
        }
    }
</style>




<!-- HASTA ACA CREA,  GUARDA ,ACTUALIZA , BORRA POR FECHA  |  OBJETIVO : GUARDAR EN MASA -->