<!-- Modal para crear antenas -->
<div class="modal fade darkmode-modal" id="edit{{ $antena->id_antena }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">AGREGAR ANTENAS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('antenas.update',$antena->id_antena) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Dirección (subzona) -->
                    <div class="mb-3">
                        <label class="form-label">Nombre de Dirección (Subzona)</label>

                        <!--AQUI SE PONE $antena->id_antena PORQUE hay lógica JS asociada directamente a ese select. --->
                        <select name="id_direccion" id="direccion_select_update{{ $antena->id_antena }}" class="form-select" required>
                            <option value="" disabled>Seleccione una subzona</option>
                            @foreach($direcciones as $direccion)
                                <option 
                                    value="{{ $direccion->id_direccion }}" 
                                    {{ $antena->id_direccion == $direccion->id_direccion ? 'selected' : '' }}
                                    data-zona="{{ $direccion->zona->nombre_zona }}">
                                    {{ $direccion->nombre_direccion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Zona (se rellena automáticamente) -->
                    <div class="mb-3">
                        <label class="form-label">Zona</label>
                        <input type="text" id="zona_input_update{{ $antena->id_antena }}" class="form-control" disabled value="{{ $antena->direccion->zona->nombre_zona ?? 'Sin zona' }}">

                    </div>

                    <!-- Nombre de antena -->
                    <div class="mb-3">
                        <label class="form-label">Nombre de Antena</label>
                        <input type="text" class="form-control" name="nombre_antena" required value="{{ $antena->nombre_antena }}">
                    </div>

                    <!-- IP -->
                    <div class="mb-3">
                        <label class="form-label">IP</label>
                        <input type="text" class="form-control" name="ip" required value="{{ $antena->ip }}">
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



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const direccionSelect = document.getElementById('direccion_select_update{{ $antena->id_antena }}');
        const zonaInput = document.getElementById('zona_input_update{{ $antena->id_antena }}');

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