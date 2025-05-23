@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1>Zona</h1>
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
                    <th scope="col">NOMBRE DE ZONA</th>
                    <th scope="col">ACCION</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($zonas as $zona)
                <tr>
                    <td>{{ $zona->id_zona }}</td>
                    <td>{{ $zona->nombre_zona }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm me-1 mb-1" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $zona->id_zona }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal"
                            data-bs-target="#delete{{ $zona->id_zona }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No hay zonas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Versión móvil (cards colapsables) -->
    <div class="d-block d-md-none">
        @forelse ($zonas as $zona)
        <div class="card mb-3 bg-dark text-white border-secondary">
            <div class="card-header d-flex justify-content-between align-items-center py-2" data-bs-toggle="collapse"
                data-bs-target="#collapseDireccion{{$zona->id_zona}}" aria-expanded="false" style="cursor: pointer">
                <h5 class="mb-0">{{$zona->nombre_zona}}</h5>
                <i class="bi bi-chevron-down transition-all"></i>
            </div>

            <div class="collapse" id="collapseDireccion{{$zona->id_zona}}">
                <div class="card-body pt-2">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <small class="text-muted">ID</small>
                            <p class="mb-0">{{$zona->id_zona}}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Nombre de zona</small>
                            <p class="mb-0">{{ $zona->nombre_zona ?? 'No asignado' }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $zona->id_zona }}">
                            <i class="bi bi-pencil-square"></i> Editar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete{{ $zona->id_zona }}">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card bg-dark text-white">
            <div class="card-body text-center">
                No hay zonas registradas
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="flex justify-content-between align-items-center mt-3">
        <div>
            {{ $zonas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Incluir modales -->
@include('zonas.create')

@foreach ($zonas as $zona)
@include('zonas.edite', ['zona' => $zona])
@include('zonas.delete', ['zona' => $zona])
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