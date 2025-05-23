<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Servicio; // 👈 Asegúrate de importar el modelo Direccion
use App\Models\Direccion; // 👈 Asegúrate de importar el modelo Direccion
use App\Models\Pago; // 👈 Asegúrate de importar el modelo Zona
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $cantidad = $request->get('cantidad', 10); // Por defecto 10 registros por página
        $buscar = $request->get('buscar'); // Texto ingresado en el buscador

        $clientes = Cliente::with('direccion.zona') // Cargar la relación 'zona' y dentro de ella 'direccion'
        ->when($buscar, function ($query, $buscar) { // Si hay un texto en el buscador  , direccion =   nombre de modelo
            // Filtrar por nombre de zona
            return $query->where('nombre', 'like', "%$buscar%");
        })->paginate($cantidad);



        // Aquí puedes agregar la lógica para obtener las zonas
        // Por ejemplo, si tienes un modelo Zona, puedes hacer algo como esto:

        $servicios = Servicio::all(); // Obtener todos CAMPOS DE LA TABLA SERVICIOS
        $direcciones = Direccion::with('zona')->get();  //JALA LA DIRECCION CON  SU RESPECTIVA ZONA

        return view('clientes.index', compact('clientes', 'direcciones' ,'servicios')); // 👈 Pásalas a la vista



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //PARA MOSTRAR EL FORMULARIO DE CREACION
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        // VALIDACION DE CAMPOS
        //NOMBRE DE CAMPO -> REQUIRED|EXISTS:NOMBRE DE TABLA , NOMBRE DE CAMPO
        'id_direccion' => 'required|exists:direcciones,id_direccion',
        'id_servicio' => 'required|exists:servicios,id_servicio',
        'tipo_documento' => 'required|in:DNI,RUC',
        'nombre' => 'required|string|max:255',
        'telefono1' => 'required|string|max:255',
        'coordenadas' => 'required|string|max:255',
        'sexo' => 'required|in:HOMBRE,MUJER',
        'tipo_persona' => 'required|in:NATURAL,JURIDICA',
        'modo_pago' => 'required|in:VIRTUAL,PRESENCIAL',
        'prestado' => 'required|in:SI,NO',
        'estado' => 'required|in:ACTIVO,INACTIVO'
        ]);
        // LOS MISMOS CAMPOS QUE ESTAN EN EL MODELO CLIENTE (INCLUYE FK) EXCEPTUANDO EL AUTO INCREMENT DE ID_CLIENTE
        $cliente = new Cliente();
        $cliente->id_direccion = $request->input('id_direccion');
        $cliente->id_servicio = $request->input('id_servicio');
        $cliente->nombre = $request->input('nombre');
        $cliente->tipo_persona = $request->input('tipo_persona');
        $cliente->tipo_documento = $request->input('tipo_documento');
        $cliente->sexo = $request->input('sexo');
        $cliente->documento = $request->input('documento');
        $cliente->telefono1 = $request->input('telefono1');
        $cliente->telefono2 = $request->input('telefono2');
        $cliente->email = $request->input('email');
        $cliente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $cliente->fecha_creacion = now();
        $cliente->ip = $request->input('ip');
        $cliente->ip_fija = $request->input('ip_fija');
        $cliente->coordenadas = $request->input('coordenadas');
        $cliente->modo_pago = $request->input('modo_pago');
        $cliente->prestado = $request->input('prestado');
        $cliente->estado = $request->input('estado');
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'id_direccion' => 'required|exists:direcciones,id_direccion',
        'id_servicio' => 'required|exists:servicios,id_servicio',
        'tipo_documento' => 'required|in:DNI,RUC',
        'nombre' => 'required|string|max:255',
        'telefono1' => 'required|string|max:255',
        'coordenadas' => 'required|string|max:255',
        'sexo' => 'required|in:HOMBRE,MUJER',
        'tipo_persona' => 'required|in:NATURAL,JURIDICA',
        'modo_pago' => 'required|in:VIRTUAL,PRESENCIAL',
        'prestado' => 'required|in:SI,NO',
        'estado' => 'required|in:ACTIVO,INACTIVO'
        
        ]);

        $cliente = Cliente::find($id);
        //id direccion es un campo de antena, lo nesesitamos para traer el nombre de la direccion
        $cliente->id_direccion = $request->input('id_direccion');
        $cliente->id_servicio = $request->input('id_servicio');
        $cliente->nombre = $request->input('nombre');
        $cliente->tipo_persona = $request->input('tipo_persona');
        $cliente->tipo_documento = $request->input('tipo_documento');
        $cliente->sexo = $request->input('sexo');
        $cliente->documento = $request->input('documento');
        $cliente->telefono1 = $request->input('telefono1');
        $cliente->telefono2 = $request->input('telefono2');
        $cliente->email = $request->input('email');
        $cliente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $cliente->fecha_creacion = $request->input('fecha_creacion');
        $cliente->ip = $request->input('ip');
        $cliente->ip_fija = $request->input('ip_fija');
        $cliente->coordenadas = $request->input('coordenadas');
        $cliente->modo_pago = $request->input('modo_pago');
        $cliente->prestado = $request->input('prestado');
        $cliente->estado = $request->input('estado');
        $cliente->update();

        return redirect()->route('clientes.index')->with('success', 'Cliente editado exitosamente.');
    }

    //PONEMOS $ID PARA BUSCAR EL CLIENTE QUE QUEREMOS ELIMINAR
    //POR DEFECTO LARAVEL TIENE COMO NOMBRE ID PARA BUSCAR TABLAS PERO COMO NUESTRO CASO, NUESTRO ID ES ID_CLIENTE POENMOS  $ID
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->with('error', 'Cliente no encontrado.');
        }

        // Verifica si tiene pagos asociados
        if ($cliente->pago()->count() > 0) {
            return redirect()->route('clientes.index')->with('error', 'No se puede eliminar el cliente porque tiene pagos registrados.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}
