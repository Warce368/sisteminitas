@include('layouts.main')


ESTO ES  WELCOME
<!--ALTER TABLE mi_tabla AUTO_INCREMENT = 1;--> 
<!--
    dd($request->all()); sirve para ver los datos que se envian

<!--                    <div class="form-group">
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













$antena->id_antena  eso  me da como  opciones  lo siguiente



Cachiche Central	
Etapa 1
Cachiche Central
Ricardo Palma

pero 
yo quiero que se vea asi


El horno	 
Etapa 1	 
San Pedro Central	 
Ricardo Palma	 
Cachiche Central







esta es  mi  tablas
ID	Nombre de Zona 
1	Cachiche	 
2	Casuarinas	 
3	San Pedro	 
4	Maras


ID	Zona	Direccion/Subzona 
1	Cachiche	El horno	 
2	Casuarinas	Etapa 1	 
3	San Pedro	San Pedro Central	 
4	Cachiche	Ricardo Palma	 
5	Cachiche	Cachiche Central

ID	NOMBRE DE ZONA	NOMBRE DE SUBZONA	NOMBRE DE ANTENA	IP	
1	Cachiche	Cachiche Central	Policlinico San Jose	192.168.21.30	 
2	Casuarinas	Etapa 1	Sta Rita (Sectorial Sur)	192.168.21.33	 
3	Cachiche	Cachiche Central	Sta Rita 22 (Sectorial Sur)	192.168.21.34	 
4	Cachiche	Ricardo Palma	Tumes AP	192.168.21.35


en  mi  select  me  aprece  las  opciones

Cachiche Central
Etapa 1
Cachiche Central
Ricardo paltma

cuando  yo quiero que me aparesca 

El horno	 
Etapa 1	 
San Pedro Central	 
Ricardo Palma	 
Cachiche Central
-->







--------

                    <div class="mb-3">
                        <!-- Etiqueta para el campo de selección -->
                        <label class="form-label">plan</label>

                        <select name="id_servicio" id="servicio_select" class="form-select" required>
                            <!-- Opción predeterminada, que está deshabilitada y seleccionada por defecto -->
                            <option value="" disabled selected>Seleccione una subzona</option>

                            @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id_servicio }}" data-descripcion="{{ $servicio->descripcion}}"
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