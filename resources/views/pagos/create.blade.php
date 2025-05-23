

<!-- PONEMOS COMO ID LA RUTA DEL BOTON -->
<div class="modal fade darkmode-modal" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">AGREGAR DIRECCION</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- EXPECIFICAMOS EL METODO STORE -->
                <form action="{{route('pagos.store')}}" method="post">
                    @csrf



                    <div class="mb-3">
                        <label for="" class="form-label">FECHA</label>
                        <input type="date" class="form-control" name="fecha_plazo" id="" aria-describedby="helpId"  required
                            placeholder="fecha" />
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