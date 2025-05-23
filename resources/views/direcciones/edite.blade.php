
<!-- especificamos que id  direccion queremos editar -->
<div class="modal fade darkmode-modal" id="edit{{$direccion -> id_direccion}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">MODIFICAR DIRECCION</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- cambiamos la ruta a update -->
                <form action="{{ route('direcciones.update', $direccion->id_direccion) }}" method="POST">
                    @csrf
                    <!-- agregamos  method put -->
                    @method('PUT')

                    <div class="mb-3">
                        <label for="" class="form-label">Nombre de subzona</label>
                        <input type="text" class="form-control" name="nombre_direccion" id="" aria-describedby="helpId"
                            placeholder="Nombre de zona" value="{{ $direccion -> nombre_direccion }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombre de zona</label>
                        <select name="id_zona" class="form-select" required>
                            <option disabled selected>Seleccione una zona</option>
                            <!-- FOREACH  Recorre cada elemento del arreglo $zonas que viene desde el controlador 
                            $zona->id_zona  ____Establece el valor del <option> con el id_zona de la zona actual del bucle 
                                
                            $direccion->id_zona == $zona->id_zona ___Compara si el id_zona de la dirección coincide con el id_zona de la zona actual.
                            -->
                            @foreach($zonas as $zona)
                            <option value="{{ $zona->id_zona }}" {{ $direccion->id_zona == $zona->id_zona ? 'selected' :
                                '' }}>
                                {{ $zona->nombre_zona }}
                            </option>
                            @endforeach

                        </select>
                    </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary">GUARDAR</button>
            </div>
            </form>
        </div>
    </div>
</div>

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