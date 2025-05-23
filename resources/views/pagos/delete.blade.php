<div class="modal fade darkmode-modal" id="delete" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pagos.destroyMes') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="mes" value="{{ $mesFiltro }}">
                    <input type="hidden" name="anio" value="{{ $anioFiltro }}">

                    <p class="fs-5">
                        ¿Estás seguro de que quieres <strong>borrar todos los pagos</strong> del mes de
                        <span class="text-primary">{{ \Carbon\Carbon::create()->month($mesFiltro)->locale('es')->translatedFormat('F') }} {{ $anioFiltro }}</span>?
                    </p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Borrar pagos</button>
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