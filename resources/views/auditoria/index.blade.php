@extends('layouts.main')

@section('content')

<h2>Auditoría del Sistema</h2>

<form method="GET" class="row mb-3">
    <!-- Cantidad -->
    <div class="col-6 col-sm-6 col-md-2">
        <label class="form-label mb-1 text-white">Registros:</label>
        <select name="cantidad" class="form-select bg-dark text-white border-secondary small-select"
            onchange="this.form.submit()">
            <option value="10" {{ request('cantidad')==10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ request('cantidad')==20 ? 'selected' : '' }}>20</option>
            <option value="30" {{ request('cantidad')==30 ? 'selected' : '' }}>30</option>
        </select>
    </div>

    <!-- Filtro por tabla -->
    <!-- Filtro por tabla con select -->
    <div class="col-6 col-sm-6 col-md-3">
        <label class="form-label mb-1 text-white">Tabla:</label>
        <select name="tabla" class="form-select bg-dark text-white border-secondary" onchange="this.form.submit()">
            <option value="">Todos</option>
            <option value="users" {{ request('tabla')=='users' ? 'selected' : '' }}>Users</option>
            <option value="clientes" {{ request('tabla')=='clientes' ? 'selected' : '' }}>Clientes</option>
            <option value="pagos" {{ request('tabla')=='pagos' ? 'selected' : '' }}>Pagos</option>
            <option value="zona" {{ request('tabla')=='zona' ? 'selected' : '' }}>Zona</option>
            <option value="direcciones" {{ request('tabla')=='direcciones' ? 'selected' : '' }}>Direcciones</option>
            <!-- Agrega más tablas aquí si las necesitas -->
        </select>
    </div>

    <!-- Filtro por ID de registro -->
    <div class="col-6 col-sm-6 col-md-2">
        <label class="form-label mb-1 text-white">ID Registro:</label>
        <input type="number" name="registro_id" class="form-control bg-dark text-white border-secondary"
            value="{{ request('registro_id') }}" onchange="this.form.submit()">
    </div>
</form>
<div>
    <table class="darkmode">
        <thead class="table-dark text-center">
            <tr>
                
                <th>Acción</th>
                <th>Tabla</th>
                <th>ID Registro</th>
                <th>Usuario</th>
                <th>Descripcion</th>
                <th>Fecha</th>

            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($logs as $log)
            <tr>
                
                <td>{{ $log->accion }}</td>
                <td>{{ $log->tabla }}</td>
                <td>{{ $log->registro_id }}</td>
                <td>{{ $log->user->name ?? 'Desconocido' }}</td>
                <td class="text-start">{{ $log->descripcion }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Paginación -->
    <div class="flex justify-content-between align-items-center mt-3">
        <div>
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


<style>
    /* Estilos originales para la tabla PC */


    /* Modo oscuro para tabla */
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
</style>
@endsection