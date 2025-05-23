@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <h1>SERVICIOS</h1>
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#create">
        AGREGAR
    </button>

    <!-- Filtro y cantidad por página -->
    <form method="GET" class="row mb-3">
        <!-- Formulario para filtrar y seleccionar cantidad de registros -->
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

    <!-- Tabla  -->
    <div class="table-responsive d-none d-md-block">
        <table class="darkmode table-hover align-middle table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">TIPO DE SERVICIO</th>
                    <th scope="col">DESCRIPCION DE SERVICIO</th>
                    <th scope="col">PRECIO DEL SERVICIO</th>
                    <th scope="col">VELOCIDAD SUBIDA(mbps)</th>
                    <th scope="col">VELOCIDAD BAJADA(mbps)</th>
                    <th scope="col">ULTIMA MODIFICACIÓN</th>
                    <th scope="col">ACCION</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($servicios as $servicio)
                <tr>
                    <td>{{$servicio->id_servicio}}</td>
                    <td>{{$servicio->nombre_servicio}}</td>
                    <td>{{$servicio->descripcion}}</td>
                    <td>{{$servicio->valor_servicio}}</td>
                    <td>{{$servicio->velocidad_subida}}</td>
                    <td>{{$servicio->velocidad_bajada}}</td>
                    <td>{{$servicio->fecha}}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm me-1 mb-1" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $servicio->id_servicio }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal"
                            data-bs-target="#delete{{ $servicio->id_servicio }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No hay zonas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>



    <!-- Versión móvil (cards colapsables) -->
    <div class="d-block d-md-none">
        @forelse ($servicios as $servicio)
        <div class="card mb-3 bg-dark text-white border-secondary">
            <div class="card-header d-flex justify-content-between align-items-center py-2" data-bs-toggle="collapse"
                data-bs-target="#collapseDireccion{{$servicio->id_servicio}}" aria-expanded="false"
                style="cursor: pointer">
                <h5 class="mb-0">{{$servicio->descripcion}}</h5>
                <i class="bi bi-chevron-down transition-all"></i>
            </div>

            <div class="collapse" id="collapseDireccion{{$servicio->id_servicio}}">
                <div class="card-body pt-2">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <small class="text-muted">ID</small>
                            <p class="mb-0">{{$servicio->nombre_servicio}}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">DESCRIPCION</small>
                            <p class="mb-0">{{ $servicio->descripcion ?? 'No asignado' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">VALOR DE SERVICIO</small>
                            <p class="mb-0">{{ $servicio->valor_servicio ?? 'No asignado' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">VELOCIDAD DE SUBIDA</small>
                            <p class="mb-0">{{ $servicio->velocidad_subida ?? 'No asignado' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">VELOCIDAD DE BAJADA</small>
                            <p class="mb-0">{{ $servicio->velocidad_bajada ?? 'No asignado' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">FECHA</small>
                            <p class="mb-0">{{ $servicio->fecha?? 'No asignado' }}</p>
                        </div>




                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $servicio->id_servicio }}">
                            <i class="bi bi-pencil-square"></i> Editar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete{{ $servicio->id_servicio }}">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card bg-dark text-white">
            <div class="card-body text-center">
                No hay servicios registradas
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="flex justify-content-between align-items-center mt-3">
        <div>
            {{ $servicios->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>




<!-- Incluir modales -->
@include('servicios.create')

@foreach ($servicios as $servicio)
@include('servicios.edite', ['servicio' => $servicio])
@include('servicios.delete', ['servicio' => $servicio])
@endforeach

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