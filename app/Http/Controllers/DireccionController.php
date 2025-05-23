<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;
use App\Models\Zona; // 👈 Asegúrate de importar el modelo Zona

class DireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cantidad = $request->get('cantidad', 10); // Por defecto 10 registros por página
        $buscar = $request->get('buscar'); // Texto ingresado en el buscador

        $direcciones = Direccion::when($buscar, function ($query, $buscar) { // Si hay un texto en el buscador  , direccion =   nombre de modelo
            // Filtrar por nombre de zona
            return $query->where('id_direccion', 'like', "%$buscar%");
        })->paginate($cantidad);



        // Aquí puedes agregar la lógica para obtener las zonas
        // Por ejemplo, si tienes un modelo Zona, puedes hacer algo como esto:
        // $zonas = Zona::all(); // Obtener todas las zonas
        $zonas = Zona::all(); // 👈 Añade esta línea

        return view('direcciones.index', compact('direcciones', 'zonas')); // 👈 Pásalas a la vista



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nombre_direccion' => 'required|string|max:255',
        'id_zona' => 'required|exists:zona,id_zona', // Asegúrate de que la zona existe
    ]);

    $direcciones = new Direccion();
    $direcciones->id_zona = $request->input('id_zona');  // Asocia la zona seleccionada
    $direcciones->nombre_direccion = $request->input('nombre_direccion');
    $direcciones->save();

    return redirect()->back()->with('success', 'Dirección creada satisfactoriamente');
    }   

    /**
     * Display the specified resource.
     */
    public function show(Direccion $direccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Direccion $direccion)
    {
        //s
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'nombre_direccion' => 'required|string|max:255',
        'id_zona' => 'required|exists:zona,id_zona', // Asegúrate de que la zona existe
        ]);
        
        $direccion = Direccion::find($id);
        $direccion->id_zona = $request->input('id_zona');
        $direccion->nombre_direccion = $request->input('nombre_direccion');
        $direccion->save();

        return redirect()->back()->with('success', 'Cambio satisfactorio');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $direccion = Direccion::find($id);

        if (!$direccion) {
            return redirect()->back()->with('error', 'Dirección no encontrada.');
        }

        $direccion->delete();

        return redirect()->back()->with('success', 'Dirección eliminada correctamente.');
    }
}


//ALTER TABLE `direcciones` AUTO_INCREMENT = 1;