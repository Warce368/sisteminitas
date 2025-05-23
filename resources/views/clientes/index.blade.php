@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1>CLIENTES</h1>
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#create">
        AGREGAR
    </button>

    <!-- Filtro y cantidad por página -->
    <form method="GET" class="row mb-3">
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


    <!-- Tabla -->

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>¡Atención!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif
    <div class="table-responsive d-none d-md-block">
        <table class="darkmode table-hover align-middle table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">TELEFONOS</th>
                    <th scope="col">TIPO CLIENTE</th>
                    <th scope="col">ZONA</th>
                    <th scope="col">SUB ZONA</th>
                    <th scope="col">IP</th>
                    <th scope="col">IP FIJA</th>
                    <th scope="col">COORDENADAS</th>
                    <th scope="col">PLAN</th>
                    <th scope="col">VELOCIDAD BAJADA</th>
                    <th scope="col">VELOCIDAD SUBIDA</th>
                    <th scope="col">MODO DE PAGO</th>
                    <th scope="col">EQUIPO PRESTADO</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">OPCIONES</th>
                    <th scope="col">CONTACTO</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- NESESITAMOS UN ID CLIENTE PARA RECIEN MOSTRAR ESTO -->
                <!-- FOR ESE PERMITE AGREGA EL EMPTY EN CASO NO HAYA NINGUN CLIENTE -->
                @forelse ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id_cliente }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono1 }} <br>{{ $cliente->telefono2 }}</td>
                    <td>{{ $cliente->tipo_persona }}</td>
                    <td>{{ $cliente->direccion->zona->nombre_zona}}</td>
                    <td>{{ $cliente->direccion->nombre_direccion}}</td>
                    <td>{{ $cliente->ip }}</td>
                    <td>{{ $cliente->ip_fija }}</td>
                    <td>{{ $cliente->coordenadas }}</td>
                    <td>{{ $cliente->servicio->descripcion }}</td>
                    <td>{{ $cliente->servicio->velocidad_bajada }}</td>
                    <td>{{ $cliente->servicio->velocidad_subida }}</td>
                    <td>{{ $cliente->modo_pago }}</td>
                    <td>{{ $cliente->prestado }}</td>
                    <td>{{ $cliente->estado }}</td>

                    <td>
                        <!-- ESPECIFICAMOS EL ID DEL CUAL QUEREMOS  EDITAR -->
                        <button type="button" class="btn btn-success btn-sm me-1 mb-1" data-bs-toggle="modal"
                            title="Editar"
                            data-bs-target="#edit{{ $cliente->id_cliente /*ESPECIFICAMOS EL ID DEL CUAL QUEREMOS  EDITAR*/ }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm me-1 mb-1" data-bs-toggle="modal" title="Borrar"
                            data-bs-target="#delete{{ $cliente->id_cliente /*ESPECIFICAMOS EL ID DEL CUAL QUEREMOS  ELIMINAR*/}}">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="btn btn-secondary btn-sm me-1 mb-1"
                            onclick="window.open('https://www.google.com/maps/search/?api=1&query={{ urlencode($cliente->coordenadas) }}', '_blank')"
                            title="Ver en Google Maps">
                            <i class="bi bi-geo-alt"></i> <!-- Ícono de mapa de Bootstrap Icons -->
                        </button>
                    </td>
                    <td>
                        @php
                        // Limpia el número: deja solo dígitos y el "+"
                        $telefonoLimpio = preg_replace('/[^0-9\+]/', '', $cliente->telefono1); // Ej: +51992234234

                        // Para WhatsApp: eliminamos el "+"
                        $telefonoWhatsApp = str_replace('+', '', $telefonoLimpio); // Ej: 51992234234
                        @endphp

                        <!-- 📞 Botón: Llamar -->
                        <button type="button" class="btn btn-dark btn-sm me-1 mb-1"
                            onclick="window.open('tel:{{ $telefonoLimpio }}')" title="Llamar al cliente">
                            <i class="bi bi-telephone-fill"></i>
                        </button>

                        <!-- 💬 Botón: WhatsApp -->
                        <button type="button" class="btn btn-success btn-sm me-1 mb-1"
                            onclick="window.open('https://wa.me/{{ $telefonoWhatsApp }}', '_blank')"
                            title="Enviar mensaje por WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </button>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="17">No hay clientes registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>



    <!-- Versión móvil (cards colapsables) -->
    <div class="d-block d-md-none">
        @forelse ($clientes as $cliente)
        <div class="card mb-3 bg-dark text-white border-secondary">
            <div class="card-header d-flex justify-content-between align-items-center py-2" data-bs-toggle="collapse"
                data-bs-target="#collapseDireccion{{$cliente->id_cliente}}" aria-expanded="false"
                style="cursor: pointer">
                <h5 class="mb-0">{{$cliente->nombre}}</h5>
                <i class="bi bi-chevron-down transition-all"></i>
            </div>

            <div class="collapse" id="collapseDireccion{{$cliente->id_cliente}}">
                <div class="card-body pt-2">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <small class="text-muted">NOMBRE</small>
                            <p class="mb-0">{{$cliente->nombre ?? 'Sin nombre' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">TELEFONO 1</small>
                            <p class="mb-0">{{ $cliente->telefono1 ?? 'Sin telefono' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">TELEFONO 2</small>
                            <p class="mb-0">{{ $cliente->telefono2 ?? 'Sin telefono' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">TIPO DE CLIENTE</small>
                            <p class="mb-0">{{ $cliente->tipo_persona ?? 'No especifica' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">ZONA</small>
                            <p class="mb-0">{{ $cliente->direccion->zona->nombre_zona ?? 'Sin zona' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">SUB ZONA</small>
                            <p class="mb-0">{{ $cliente->direccion->nombre_direccion ?? 'Sin subzona' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">IP</small>
                            <p class="mb-0">{{ $cliente->ip ?? 'Sin ip' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">IP FIJA</small>
                            <p class="mb-0">{{ $cliente->ip_fija ?? 'Sin ip fija' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">COORDENADAS</small>
                            <p class="mb-0">{{ $cliente->coordenadas ?? 'Sin coordenadas' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">PLAN</small>
                            <p class="mb-0">{{ $cliente->servicio->descripcion ?? 'Sin plan' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">VELOCIDAD BAJADA</small>
                            <p class="mb-0">{{ $cliente->servicio->velocidad_bajada ?? 'Sin velocidad bajada' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">VELOCIDAD SUBIDA</small>
                            <p class="mb-0">{{ $cliente->servicio->velocidad_subida ?? 'Sin velocidad subida' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">MODO DE PAGO</small>
                            <p class="mb-0">{{ $cliente->modo_pago ?? 'Sin modo de pago' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">EQUIPO PRESTADO</small>
                            <p class="mb-0">{{ $cliente->prestado ?? 'Sin equipo prestado' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">ESTADO</small>
                            <p class="mb-0">{{ $cliente->estado ?? 'Sin estado' }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $cliente->id_cliente }}">
                            <i class="bi bi-pencil-square"></i> Editar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#delete{{ $cliente->id_cliente }}">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>

                        <button type="button" class="btn btn-secondary btn-sm "
                            onclick="window.open('https://www.google.com/maps/search/?api=1&query={{ urlencode($cliente->coordenadas) }}', '_blank')"
                            title="Ver en Google Maps">
                            <i class="bi bi-geo-alt"></i>Ubicación
                            <!-- Ícono de mapa de Bootstrap Icons -->
                        </button>
                        @php
                        // Limpia el número: deja solo dígitos y el "+"
                        $telefonoLimpio = preg_replace('/[^0-9\+]/', '', $cliente->telefono1); // Ej: +51992234234

                        // Para WhatsApp: eliminamos el "+"
                        $telefonoWhatsApp = str_replace('+', '', $telefonoLimpio); // Ej: 51992234234
                        @endphp

                        <!-- 📞 Botón: Llamar -->
                        <button type="button" class="btn btn-dark btn-sm "
                            onclick="window.open('tel:{{ $telefonoLimpio }}')" title="Llamar al cliente">
                            <i class="bi bi-telephone-fill"></i>Llamar
                        </button>

                        <!-- 💬 Botón: WhatsApp -->
                        <button type="button" class="btn btn-success btn-sm "
                            onclick="window.open('https://wa.me/{{ $telefonoWhatsApp }}', '_blank')"
                            title="Enviar mensaje por WhatsApp">
                            <i class="bi bi-whatsapp"></i>Mensaje
                        </button>
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
    <div class="flex justify-content-between align-items-center mt-3">
        <div>
            {{ $clientes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Incluir modales -->
@include('clientes.create')

@foreach ($clientes as $cliente)
@include('clientes.edite', ['cliente' => $cliente])
@include('clientes.delete', ['cliente' => $cliente])
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