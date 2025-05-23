@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1>HISTORIAL</h1>

    <!-- Filtro y cantidad por página -->
    <!-- Filtros con diseño compacto, responsive y modo oscuro -->
    <form method="GET" class="row gy-2 gx-2 align-items-center mb-3 text-white">

        <!-- Filtro de mes y año -->
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label mb-1 text-white">Hasta:</label>
            @php\Carbon\Carbon::setLocale('es');@endphp
            <select name="mes" class="form-select bg-dark text-white border-secondary small-select"
                onchange="this.form.submit()">
                @foreach ($mesesAnios as $item)
                <option value="{{ $item->mes }}" {{ $mesFiltro==$item->mes && $anioFiltro == $item->anio ? 'selected' :
                    ''
                    }}>
                    {{ \Carbon\Carbon::create()->month($item->mes)->locale('es')->translatedFormat('F') }} {{
                    $item->anio }}
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
        <!-- Filtro por zona -->
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label mb-1 text-white">Zona:</label>
            <select name="id_zona" class="form-select bg-dark text-white border-secondary small-select"
                onchange="this.form.submit()">
                <option value="">TODOS</option>
                @foreach ($zonas as $zona)
                <option value="{{ $zona->id_zona }}" {{ $zonaId==$zona->id_zona ? 'selected' : '' }}>
                    {{ $zona->nombre_zona }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Filtro por tipo de documento -->
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label mb-1 text-white">Tipo Documento:</label>
            <select name="tipo_documento" class="form-select bg-dark text-white border-secondary small-select"
                onchange="this.form.submit()">
                <option value="">-- Todos --</option>
                <option value="DNI" {{ $tipoDocumento=='DNI' ? 'selected' : '' }}>DNI</option>
                <option value="RUC" {{ $tipoDocumento=='RUC' ? 'selected' : '' }}>RUC</option>
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
    <div class="col-12 col-sm-6 col-md-3">
        @php
        $sumaTotalDebe = 0;
        $sumaTotalPagado = 0;
        foreach ($pagos as $pago) {
        $sumaTotalDebe += $pago->monto_debe;
        $sumaTotalPagado += $pago->monto_pagado;
        }
        @endphp

        <div class="d-flex justify-content-between align-items-center text-white">
            <div class="me-3">
                <label class="form-label mb-1">TOTAL FALTA PAGAR</label>
                <h2>{{$sumaTotalDebe}}</h2>
            </div>
            <div>
                <label class="form-label mb-1">TOTAL PAGADO</label>
                <h2>{{$sumaTotalPagado}}</h2>
            </div>
        </div>
    </div>

    <!-- Tabla  -->
    <div class="table-responsive d-none d-md-block">
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

        <input type="hidden" name="mes" value="{{ $mesFiltro }}">
        <input type="hidden" name="anio" value="{{ $anioFiltro }}">
        <table class="darkmode table-hover align-middle table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">TIPO DOCUMENTO</th>
                    <th scope="col">PLAN</th>
                    <th scope="col">DIRECCION</th>
                    <th scope="col">ZONA</th>
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

                    <td>{{ $pago->cliente->tipo_documento}}</td>
                    <td>{{ $pago->cliente->servicio->descripcion}}</td>
                    <td>{{ $pago->cliente->direccion->nombre_direccion}}</td>
                    <td>{{ $pago->cliente->direccion->zona->nombre_zona}}</td>

                    <!-- Campos editables fuera del form principal -->
                    <td>
                        {{ $pago->monto_debe }}
                    </td>
                    <td>
                        {{ $pago->monto_pagado }}
                    </td>
                    <td>
                        {{ $pago->fecha_cancelada }}
                    </td>
                    <td>
                        {{ $pago->descripcion_pago }}
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="12">No hay pagos registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Versión Móvil (tarjetas colapsables) -->
    <div class="d-block d-md-none">
        @forelse ($pagos as $pago)
        @php
        $resta = $pago->monto_debe - $pago->monto_pagado;
        @endphp

        <div class="card mb-3 bg-dark text-white border-secondary">
            <div class="card-header d-flex justify-content-between align-items-center py-2" data-bs-toggle="collapse"
                data-bs-target="#collapseDireccion{{$pago->id_pago}}" aria-expanded="false" style="cursor: pointer">
                <h5 class="mb-0">{{$pago->cliente->nombre}}


                    @if($resta <= 0) <span class="badge bg-success ms-2">✅</span> @endif
                </h5>
                <i class="bi bi-chevron-down transition-all"></i>
            </div>

            <div class="collapse" id="collapseDireccion{{$pago->id_pago}}">
                <div class="card-body pt-2">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <small class="text-muted">ID</small>
                            <p class="mb-0">{{$pago->id_pago ?? 'Sin nombre' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">nombre</small>
                            <p class="mb-0">{{ $pago->cliente->nombre ?? 'Sin telefono' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">descripcion</small>
                            <p class="mb-0">{{ $pago->cliente->servicio->descripcion ?? 'Sin telefono' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">monto_debe</small>
                            <p class="mb-0">{{ $pago->monto_debe ?? 'Sin telefono' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">monto_pagado</small>
                            <p class="mb-0">{{ $pago->monto_pagado ?? 'Sin telefono' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">fecha_cancelada</small>
                            <p class="mb-0">{{ $pago->fecha_cancelada ?? 'Sin telefono' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">descripcion_pago</small>
                            <p class="mb-0">{{ $pago->descripcion_pago ?? 'Sin telefono' }}</p>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card bg-dark text-white">
            <div class="card-body text-center">
                No hay clientes registradas
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-3">
        {{ $pagos->links('pagination::bootstrap-5') }}
    </div>

</div>


<style>
    /* Estilos originales para la tabla PC */
    td {
        padding: 0.5rem !important;
        vertical-align: middle !important;
    }

    th,
    td {
        font-size: 0.95rem;
    }

    .table th {
        vertical-align: middle !important;
        white-space: nowrap;
    }

    .btn {
        margin-right: 0.5rem;
    }

    td.estado {
        height: 2.5rem;
        vertical-align: middle !important;
        padding: 0.25rem !important;
    }

    /* Modo oscuro para tabla */
    table.darkmode {
        background-color: #121212 !important;
        color: #eee !important;
        border-collapse: collapse !important;
        width: 100%;
        min-width: 600px !important;
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

    /* Estilos para móvil */
    .card {
        border: 1px solid #444;
        border-radius: 8px;
        overflow: hidden;
    }

    .card-header {
        background-color: #222;
        border-bottom: 1px solid #444;
        transition: background-color 0.2s;
    }

    .card-header:hover {
        background-color: #2a2a2a;
    }

    .card-header h5 {
        font-size: 1rem;
        font-weight: 500;
    }

    .card-body {
        padding: 1rem;
        background-color: #1e1e1e;
    }

    .bi-chevron-down {
        transition: transform 0.3s;
    }

    .card-header[aria-expanded="true"] .bi-chevron-down {
        transform: rotate(180deg);
    }

    small.text-muted {
        font-size: 0.75rem;
        color: #aaa !important;
    }

    /* Estilos para modales en móvil */
    .modal-content {
        background-color: #1e1e1e;
        color: #fff;
    }

    .modal-header {
        border-bottom: 1px solid #444;
    }

    .modal-footer {
        border-top: 1px solid #444;
    }
</style>

@endsection