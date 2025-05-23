




<div class="modal fade darkmode-modal" id="edit{{ $cliente->id_cliente }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">EDITAR DIRECCION</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('clientes.update', $cliente->id_cliente )}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tipo_documento">Tipo de documento</label>
                        <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                            <option value="" disabled {{ old('tipo_documento', $cliente->tipo_documento ?? '' )=='' ? 'selected' : '' }}>Seleccione un tipo</option>
                            <option value="DNI" {{ old('tipo_documento', $cliente->tipo_documento ?? '' )=='DNI' ? 'selected' : '' }}>DNI
                            </option>
                            <option value="RUC" {{ old('tipo_documento', $cliente->tipo_documento ?? '')=='RUC' ? 'selected' : '' }}>RUC
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">documento</label>
                        <input type="text" class="form-control" name="documento" id="" aria-describedby="helpId" value="{{ $cliente->documento }}"
                            placeholder="documento" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">nombre y apellidos</label>
                        <input type="text" class="form-control" name="nombre" id="" aria-describedby="helpId" required value="{{ $cliente->nombre }}"
                            placeholder="nombre y apellidos" />
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Telefono1</label>
                        <input type="text" class="form-control" name="telefono1" id="" aria-describedby="helpId" value="{{ $cliente->telefono1 }}"
                            required placeholder="Telefono1" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Telefono2</label>
                        <input type="text" class="form-control" name="telefono2" id="" aria-describedby="helpId" value="{{ $cliente->telefono2 }}"
                            placeholder="Telefono1" />
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">email</label>
                        <input type="email" class="form-control" name="email" id="" aria-describedby="helpId" value="{{ $cliente->email }}"
                            placeholder="email" />
                    </div>


                    <div class="form-group">
                        <label for="sexo">Genero</label>
                        <select name="sexo" id="sexo" class="form-control" required>
                            <option value="" disabled {{ old('sexo', $cliente -> sexo  ??  '')=='' ? 'selected' : '' }}>Seleccione</option>
                            <option value="HOMBRE" {{ old('sexo', $cliente -> sexo  ??  '')=='HOMBRE' ? 'selected' : '' }}>HOMBRE</option>
                            <option value="MUJER" {{ old('sexo', $cliente -> sexo  ??  '')=='MUJER' ? 'selected' : '' }}>MUJER</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Nombre de Dirección (Subzona)</label>
                        <select name="id_direccion" id="cliente_direccion_select_update{{ $cliente->id_cliente }}" class="form-select" required>
                            <option value="{{ $cliente->id_cliente }}" disabled selected>Seleccione una subzona</option>
                            @foreach($direcciones as $direccion)
                            <option value="{{ $direccion->id_direccion }}" {{ $cliente->id_direccion == $direccion->id_direccion ? 'selected' : '' }}
                                data-zona="{{ $direccion->zona->nombre_zona }}">
                                {{ $direccion->nombre_direccion }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Zona</label>
                        <input type="text" id="cliente_direccion_zona_input_update{{ $cliente->id_cliente }}" class="form-control" disabled value="{{ $cliente->direccion->zona->nombre_zona ?? 'Sin zona' }}">
                    </div>


                    <div class="mb-3">
                        <label for="" class="form-label">ip</label>
                        <input type="text" class="form-control" name="ip" id="" aria-describedby="helpId" required value="{{ $cliente->ip }}"
                            placeholder="ip" />
                    </div>



                    <div class="form-group">
                        <label for="tipo_persona">Tipo de Persona</label>
                        <select name="tipo_persona" id="tipo_persona_update" class="form-control">
                            <option value="" disabled {{ old('tipo_persona', $cliente->tipo_persona ?? '') == '' ? 'selected' : '' }}>Seleccione un tipo</option>
                            <option value="NATURAL" {{ old('tipo_persona', $cliente->tipo_persona ?? '') == 'NATURAL' ? 'selected' : '' }}>NATURAL</option>
                            <option value="JURIDICA" {{ old('tipo_persona', $cliente->tipo_persona ?? '') == 'JURIDICA' ? 'selected' : '' }}>JURIDICA</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">ip_fija</label>
                        <input type="text" class="form-control" name="ip_fija" id="ip_fija_update" aria-describedby="helpId" value="{{ $cliente->ip_fija }}"
                            placeholder="ip_fija" disabled />
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">fecha_nacimiento</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" id="" aria-describedby="helpId" value="{{ $cliente->fecha_nacimiento }}"
                            placeholder="fecha_nacimiento" />
                    </div>



                    <div class="mb-3">
                        <label for="" class="form-label">coordenadas</label>
                        <input type="text" class="form-control" name="coordenadas" id="" aria-describedby="helpId" value="{{ $cliente->coordenadas }}"
                            required placeholder="coordenadas" />
                    </div>

                    <div class="mb-3">

                        <label class="form-label">plan</label>

                        <select name="id_servicio" id="servicio_select_update{{ $cliente->id_cliente }}" class="form-select" required>
                            <option value="" disabled selected>Seleccione un plan</option>

                            @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id_servicio }}" {{ $cliente->id_servicio == $servicio->id_servicio ? 'selected' : '' }}
                                data-velocidadsubida="{{$servicio->velocidad_subida}}"
                                data-velocidadbajada="{{$servicio->velocidad_bajada }}">
                                {{ $servicio->descripcion }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Velocidad bajada</label>
                        <input type="text" id="velocidad_bajada_input_update{{ $cliente->id_cliente }}" class="form-control" disabled  value="{{ $cliente->servicio->velocidad_bajada ?? 'Sin velocidad' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Velocidad subida</label>
                        <input type="text" id="velocidad_subida_input_update{{ $cliente->id_cliente }}" class="form-control" disabled value="{{ $cliente->servicio->velocidad_subida ?? 'Sin velocidad' }}">
                    </div>




                    <div class="form-group">
                        <label for="modo_pago">modo_pago</label>
                        <select name="modo_pago" id="modo_pago" class="form-control" required>
                            <option value="" disabled {{ old('modo_pago',  $cliente->modo_pago ?? '')=='' ? 'selected' : '' }}selected>Seleccione</option>
                            <option value="VIRTUAL" {{ old('modo_pago',  $cliente->modo_pago ?? '')=='VIRTUAL' ? 'selected' : '' }}>VIRTUAL</option>
                            <option value="PRESENCIAL" {{ old('modo_pago',  $cliente->modo_pago ?? '')=='PRESENCIAL' ? 'selected' : '' }}>PRESENCIAL
                            </option>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label class="form-label">Prestado</label>
                        <div>
                            <input type="radio" id="prestado_si" name="prestado" value="SI" 
                                {{ $cliente->prestado == 'SI' ? 'checked' : '' }} required>
                            <label for="prestado_si">Sí</label>
                        </div>
                        <div>
                            <input type="radio" id="prestado_no" name="prestado" value="NO" 
                                {{ $cliente->prestado == 'NO' ? 'checked' : '' }} required>
                            <label for="prestado_no">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <div>
                            <input type="radio" id="estado_activo" name="estado" value="ACTIVO" 
                                {{ $cliente->estado == 'ACTIVO' ? 'checked' : '' }} required>
                            <label for="estado_activo">Activo</label>
                        </div>
                        <div>
                            <input type="radio" id="estado_inactivo" name="estado" value="INACTIVO" 
                                {{ $cliente->estado == 'INACTIVO' ? 'checked' : '' }} required>
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
        const tipoPersona = document.getElementById('tipo_persona_update');
        const ipFija = document.getElementById('ip_fija_update');
        //direccion y zona
        const direccionSelect = document.getElementById('cliente_direccion_select_update{{ $cliente->id_cliente }}');
        const zonaInput2 = document.getElementById('cliente_direccion_zona_input_update{{ $cliente->id_cliente }}');

        //servicios
        const servicioSelect = document.getElementById('servicio_select_update{{ $cliente->id_cliente }}');
        const velocidadBajadaInput = document.getElementById('velocidad_bajada_input_update{{ $cliente->id_cliente }}'); 
        const velocidadSubidaInput = document.getElementById('velocidad_subida_input_update{{ $cliente->id_cliente }}'); 
        
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


<!-- LABEL SE UNE CON INPUT MEDIANTE
    FOR(LABEL) Y ID(INPUT)

-->

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