

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
                <form action="{{route('clientes.store')}}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="tipo_documento">Tipo de documento</label>
                        <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                            <option value="" disabled selected>Seleccione un tipo</option>
                            <option value="DNI" {{ old('tipo_documento')=='DNI' ? 'selected' : '' }}>DNI
                            </option>
                            <option value="RUC" {{ old('tipo_documento')=='RUC' ? 'selected' : '' }}>RUC
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">documento</label>
                        <input type="text" class="form-control" name="documento" id="" aria-describedby="helpId"
                            placeholder="documento" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">nombre y apellidos</label>
                        <input type="text" class="form-control" name="nombre" id="" aria-describedby="helpId" required
                            placeholder="nombre y apellidos" />
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Telefono1</label>
                        <input type="text" class="form-control" name="telefono1" id="" aria-describedby="helpId"
                            required placeholder="Telefono1" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Telefono2</label>
                        <input type="text" class="form-control" name="telefono2" id="" aria-describedby="helpId"
                            placeholder="Telefono1" />
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">email</label>
                        <input type="email" class="form-control" name="email" id="" aria-describedby="helpId"
                            placeholder="email" />
                    </div>


                    <div class="form-group">
                        <label for="sexo">Genero</label>
                        <select name="sexo" id="sexo" class="form-control" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="HOMBRE" {{ old('sexo')=='HOMBRE' ? 'selected' : '' }}>HOMBRE</option>
                            <option value="MUJER" {{ old('sexo')=='MUJER' ? 'selected' : '' }}>MUJER</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <!-- Etiqueta para el campo de selección -->
                        <label class="form-label">Nombre de Dirección (Subzona)</label>

                        <!-- Campo de selección (dropdown) para elegir una dirección -->
                        <select name="id_direccion" id="cliente_direccion_select" class="form-select" required>
                            <!-- Opción predeterminada, que está deshabilitada y seleccionada por defecto -->
                            <option value="" disabled selected>Seleccione una subzona</option>

                            <!-- Iterar sobre todas las direcciones disponibles y crear una opción por cada una -->
                            @foreach($direcciones as $direccion)
                            <!-- Cada opción tiene como valor el 'id_direccion', que es único para cada dirección -->
                            <!-- El atributo data-zona en cada opción del <select> almacena el nombre de la zona asociada a esa dirección. -->
                            <option value="{{ $direccion->id_direccion }}"
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
                        <input type="text" id="cliente_direccion_zona_input" class="form-control" disabled>
                    </div>


                    <div class="mb-3">
                        <label for="" class="form-label">ip</label>
                        <input type="text" class="form-control" name="ip" id="" aria-describedby="helpId" required
                            placeholder="ip" />
                    </div>



                    <div class="form-group">
                        <label for="tipo_persona">Tipo de Persona</label>
                        <select name="tipo_persona" id="tipo_persona" class="form-control">
                            <option value="" disabled selected>Seleccione un tipo</option>
                            <option value="NATURAL" {{ old('tipo_persona')=='NATURAL' ? 'selected' : '' }}>NATURAL
                            </option>
                            <option value="JURIDICA" {{ old('tipo_persona')=='JURIDICA' ? 'selected' : '' }}>JURIDICA
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">ip_fija</label>
                        <input type="text" class="form-control" name="ip_fija" id="ip_fija" aria-describedby="helpId"
                            placeholder="ip_fija" disabled />
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">fecha_nacimiento</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" id="" aria-describedby="helpId"
                            placeholder="fecha_nacimiento" />
                    </div>



                    <div class="mb-3">
                        <label for="" class="form-label">coordenadas</label>
                        <input type="text" class="form-control" name="coordenadas" id="" aria-describedby="helpId"
                            required placeholder="coordenadas" />
                    </div>

                    <div class="mb-3">
                        <!-- Etiqueta para el campo de selección -->
                        <label class="form-label">plan</label>

                        <select name="id_servicio" id="servicio_select" class="form-select" required>
                            <!-- Opción predeterminada, que está deshabilitada y seleccionada por defecto -->
                            <option value="" disabled selected>Seleccione una subzona</option>

                            @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id_servicio }}"
                                data-velocidadsubida="{{$servicio->velocidad_subida}}"
                                data-velocidadbajada="{{$servicio->velocidad_bajada }}">
                                {{ $servicio->descripcion }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Zona (se rellena automáticamente) -->
                    <div class="mb-3">
                        <label class="form-label">Velocidad bajada</label>
                        <input type="text" id="velocidad_bajada_input" class="form-control" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Velocidad subida</label>
                        <input type="text" id="velocidad_subida_input" class="form-control" disabled>
                    </div>




                    <div class="form-group">
                        <label for="modo_pago">modo_pago</label>
                        <select name="modo_pago" id="modo_pago" class="form-control" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="VIRTUAL" {{ old('modo_pago')=='VIRTUAL' ? 'selected' : '' }}>VIRTUAL</option>
                            <option value="PRESENCIAL" {{ old('modo_pago')=='PRESENCIAL' ? 'selected' : '' }}>PRESENCIAL
                            </option>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label class="form-label">Prestado</label>
                        <div>
                            <input type="radio" id="prestado_si" name="prestado" value="SI" required>
                            <label for="prestado_si">Sí</label>
                        </div>
                        <div>
                            <input type="radio" id="prestado_no" name="prestado" value="NO" required>
                            <label for="prestado_no">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <div>
                            <input type="radio" id="estado_activo" name="estado" value="ACTIVO" required>
                            <label for="estado_activo">Activo</label>
                        </div>
                        <div>
                            <input type="radio" id="estado_inactivo" name="estado" value="INACTIVO" required>
                            <label for="estado_inactivo">Inactivo</label>
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
</div>




<script>
    // PARA MOSTRAR SERVICIO
    document.addEventListener('DOMContentLoaded', function () {

        //tipo de persona (juridica o natural)
        const tipoPersona = document.getElementById('tipo_persona');
        const ipFija = document.getElementById('ip_fija');
        //direccion y zona
        const direccionSelect = document.getElementById('cliente_direccion_select');
        const zonaInput2 = document.getElementById('cliente_direccion_zona_input');

        //servicios
        const servicioSelect = document.getElementById('servicio_select');
        const velocidadBajadaInput = document.getElementById('velocidad_bajada_input');
        const velocidadSubidaInput = document.getElementById('velocidad_subida_input');
        
        tipoPersona.addEventListener('change', function () {
            if (this.value === 'JURIDICA') {
                ipFija.disabled = false;
            } else {
                ipFija.disabled = true;
                ipFija.value = ''; // Limpiar si no es JURIDICA
            }
        });

        direccionSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const zonaNombre2 = selectedOption.getAttribute('data-zona');
            zonaInput2.value = zonaNombre2 ?? 'Zona no disponible';
        });

        servicioSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const velocidadBajada = selectedOption.getAttribute('data-velocidadbajada');
            const velocidadSubida = selectedOption.getAttribute('data-velocidadsubida');
            velocidadBajadaInput.value = velocidadBajada ?? 'Velocidad bajada no disponible';
            velocidadSubidaInput.value = velocidadSubida ?? 'Velocidad subida no disponible';
            
        });



    

    })

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