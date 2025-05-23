<div class="modal fade darkmode-modal" id="edit{{ $servicio->id_servicio }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">MODIFICAR SERVICIOS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('servicios.update', $servicio->id_servicio)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="" class="form-label">nombre de servicio</label>
                        <input type="text" class="form-control" name="nombre_servicio" id="" aria-describedby="helpId"
                            placeholder="nombre de servicio" value="{{ $servicio-> nombre_servicio }}" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">descripcion</label>
                        <input type="text" class="form-control" name="descripcion" id="" aria-describedby="helpId"
                            placeholder="descripcion" value="{{ $servicio-> descripcion}}"/>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">valor de servicio</label>
                        <input type="number" class="form-control" name="valor_servicio" id="" aria-describedby="helpId"
                            placeholder="valor de servicio" step="0.01"  value="{{ $servicio-> valor_servicio}}"/>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">velocidad de subida</label>
                        <input type="number" class="form-control" name="velocidad_subida" id="" aria-describedby="helpId"
                            placeholder="velocidad de subida" step="0.01" value="{{ $servicio-> velocidad_subida}}"/>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">velocidad de bajada</label>
                        <input type="number" class="form-control" name="velocidad_bajada" id="" aria-describedby="helpId"
                            placeholder="velocidad de bajada" step="0.01" value="{{ $servicio-> velocidad_bajada}}"/>
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