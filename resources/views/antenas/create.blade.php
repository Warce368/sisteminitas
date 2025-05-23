<!-- Modal para crear antenas -->
<div class="modal fade darkmode-modal" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">AGREGAR ANTENAS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('antenas.store') }}" method="POST">
                    @csrf

                    <!-- Dirección (subzona) -->
                    <div class="mb-3">
                        <!-- Etiqueta para el campo de selección -->
                        <label class="form-label">Nombre de Dirección (Subzona)</label>

                        <!-- Campo de selección (dropdown) para elegir una dirección -->
                        <select name="id_direccion" id="direccion_select" class="form-select" required>
                            <!-- Opción predeterminada, que está deshabilitada y seleccionada por defecto -->
                            <option value="" disabled selected>Seleccione una subzona</option>

                            <!-- Iterar sobre todas las direcciones disponibles y crear una opción por cada una -->
                            @foreach($direcciones as $direccion)
                                <!-- Cada opción tiene como valor el 'id_direccion', que es único para cada dirección -->
                                <!-- El atributo data-zona en cada opción del <select> almacena el nombre de la zona asociada a esa dirección. -->
                                <option 
                                    value="{{ $direccion->id_direccion }}" 
                                    data-zona="{{ $direccion->zona->nombre_zona }}">
                                    
                                    <!-- Mostrar el nombre de la dirección (subzona) como texto visible para el usuario -->
                                    {{ $direccion->nombre_direccion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Zona (se rellena automáticamente) -->
                    <div class="mb-3">
                        <label class="form-label">Zona</label>
                        <input type="text" id="zona_input" class="form-control" disabled>
                    </div>

                    <!-- Nombre de antena -->
                    <div class="mb-3">
                        <label class="form-label">Nombre de Antena</label>
                        <input type="text" class="form-control" name="nombre_antena" required>
                    </div>

                    <!-- IP -->
                    <div class="mb-3">
                        <label class="form-label">IP</label>
                        <input type="text" class="form-control" name="ip" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar la selección de dirección y mostrar la zona correspondiente -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const direccionSelect = document.getElementById('direccion_select');
        const zonaInput = document.getElementById('zona_input');

        direccionSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const zonaNombre = selectedOption.getAttribute('data-zona');
            zonaInput.value = zonaNombre ?? 'Zona no disponible';
        });
    });
</script>

<style>
    /* General Dark Mode for Modals */
.darkmode-modal .modal-content {
    background-color: #1e1e2f;
    color: #ffffff;
    border: 1px solid #333;
}

.darkmode-modal .modal-header,
.darkmode-modal .modal-footer {
    border-color: #444;
}

.darkmode-modal .modal-title {
    color: #ffffff;
}

.darkmode-modal .form-control,
.darkmode-modal .form-select {
    background-color: #2a2a3d;
    color: #ffffff;
    border: 1px solid #555;
}

.darkmode-modal .form-control:disabled,
.darkmode-modal .form-select:disabled {
    background-color: #333;
    color: #bbb;
}

.darkmode-modal label {
    color: #ccc;
}

.darkmode-modal .btn-close {
    filter: invert(1);
}
</style>