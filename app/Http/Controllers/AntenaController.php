<?php

namespace App\Http\Controllers;

use App\Models\Antena;
use Illuminate\Http\Request;
use App\Models\Zona; // 👈 Asegúrate de importar el modelo Zona
use App\Models\Direccion; // 👈 Asegúrate de importar el modelo Direccion
class AntenaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cantidad = $request->get('cantidad', 10); // Por defecto 10 registros por página
        $buscar = $request->get('buscar'); // Texto ingresado en el buscador



        // Obtener todas las antenas junto con sus direcciones y zonas asociadas
        $antenas = Antena::with('direccion.zona')  // 👈 Cargar relaciones anidadas: 'direccion' y, dentro de ella, 'zona'
            ->when($buscar, function ($query, $buscar) {
                // Si hay un término de búsqueda, aplicar filtro por ID de la antena
                return $query->where('id_antena', 'like', "%$buscar%");
            })
            ->paginate($cantidad); 
            
        // Obtener todas las direcciones con su zona asociada
        $direcciones = Direccion::with('zona')->get(); // 👈 Cargar la relación 'zona' para cada dirección, útil para el formulario

        // Retornar la vista 'antenas.index' con las variables $antenas y $direcciones disponibles
        return view('antenas.index', compact('antenas', 'direcciones')); // 👈 Pasar los datos a la vista



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
        $request->validate([
            'id_direccion' => 'required|exists:direcciones,id_direccion',
            'nombre_antena' => 'required|string|max:255',
            'ip' => 'required|ip',
        ]);

        $antena = new Antena();
        //id direccion es un campo de antena, lo nesesitamos para traer el nombre de la direccion
        $antena->id_direccion = $request->input('id_direccion');
        $antena->nombre_antena = $request->input('nombre_antena');
        $antena->ip = $request->input('ip');
        $antena->save();

        return redirect()->back()->with('success', 'Antena creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Antena $antena)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Antena $antena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'id_direccion' => 'required|exists:direcciones,id_direccion',
            'nombre_antena' => 'required|string|max:255',
            'ip' => 'required|ip',
        ]);

        $antena = Antena::find($id);

        //id direccion es un campo de antena, lo nesesitamos para traer el nombre de la direccion
        $antena->id_direccion = $request->input('id_direccion');
        $antena->nombre_antena = $request->input('nombre_antena');
        $antena->ip = $request->input('ip');
        $antena->update();

        return redirect()->back()->with('success', 'Antena actualizada satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $antena = Antena::find($id);

        if (!$antena) {
            return redirect()->back()->with('error', 'Antena no encontrada');
        }
        $antena->delete();

        return redirect()->back()->with('success', 'Antena eliminada satisfactoriamente');
    }
}
