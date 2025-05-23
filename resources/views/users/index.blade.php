@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1>USUARIOS</h1>
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#create">
        AGREGAR
    </button>

    <!-- Filtro y cantidad por página -->


    <!-- Tabla  -->
    <div class="table-responsive d-none d-md-block">
        <table class="darkmode table-hover align-middle table-bordered">
            <thead class="table-dark text-center">
                <tr>

                    <th scope="col">NOMBRE DE USUARIOS</th>
                    <th scope="col">ROL</th>
                    <th scope="col">ACCION</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($users as $user)
                <tr>

                    <td>{{ $user->name}}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm me-1 mb-1" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $user->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal"
                            data-bs-target="#delete{{ $user->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No hay zonas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>




    <!-- Versión móvil (cards colapsables) -->
    <div class="d-block d-md-none">
        @forelse ($users as $user)
        <div class="card mb-3 bg-dark text-white border-secondary">
            <div class="card-header d-flex justify-content-between align-items-center py-2" data-bs-toggle="collapse"
                data-bs-target="#collapseDireccion{{$user->id}}" aria-expanded="false"
                style="cursor: pointer">
                <h5 class="mb-0">{{$user->name}}</h5>
                <i class="bi bi-chevron-down transition-all"></i>
            </div>

            <div class="collapse" id="collapseDireccion{{$user->id}}">
                <div class="card-body pt-2">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <small class="text-muted">NOMBRE DE USUARIO</small>
                            <p class="mb-0">{{$user->name}}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">ROL</small>
                            <p class="mb-0">{{ $user->role}}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $user->id }}">
                            <i class="bi bi-pencil-square"></i> Editar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete{{ $user->id }}">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card bg-dark text-white">
            <div class="card-body text-center">
                No hay direcciones registradas
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->

</div>

<!-- Incluir modales -->
@include('users.create')

@foreach ($users as $user)
@include('users.edite', ['user' => $user])
@include('users.delete', ['user' => $user])
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
