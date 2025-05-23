<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cantidad = $request->get('cantidad', 10); // Por defecto 10 registros por página
        $buscar = $request->get('buscar'); // Texto ingresado en el buscador

        $servicios = Servicio::when($buscar, function ($query, $buscar) { // Si hay un texto en el buscador  , direccion =   nombre de modelo
            // Filtrar por nombre de zona
            return $query->where('id_servicio', 'like', "%$buscar%");
        })->paginate($cantidad);



        // Aquí puedes agregar la lógica para obtener las zonas
        // Por ejemplo, si tienes un modelo Zona, puedes hacer algo como esto:
        // $zonas = Zona::all(); // Obtener todas las zonas


        return view('servicios.index', compact('servicios')); // 👈 Pásalas a la vista



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    
    
    $servicios = new Servicio(); // Asocia la zona seleccionada
    $servicios->nombre_servicio = $request->input('nombre_servicio');
    $servicios->descripcion = $request->input('descripcion');
    $servicios->valor_servicio = $request->input('valor_servicio');
    $servicios->velocidad_subida = $request->input('velocidad_subida');
    $servicios->velocidad_bajada = $request->input('velocidad_bajada');
    $servicios->fecha = now();
    $servicios->save();

    return redirect()->back()->with('success', 'Servicio creada satisfactoriamente');
    }   

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $servicios = Servicio::find($id);// Asocia la zona seleccionada
    $servicios->nombre_servicio = $request->input('nombre_servicio');
    $servicios->descripcion = $request->input('descripcion');
    $servicios->valor_servicio = $request->input('valor_servicio');
    $servicios->velocidad_subida = $request->input('velocidad_subida');
    $servicios->velocidad_bajada = $request->input('velocidad_bajada');
    $servicios->fecha = now();
    $servicios->update();

    return redirect()->back()->with('success', 'Servicio creada satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $servicios = Servicio::find($id);// Asocia la zona seleccionada
    $servicios->delete();
    return redirect()->back()->with('success', 'Servicio creada satisfactoriamente');

    }
}
