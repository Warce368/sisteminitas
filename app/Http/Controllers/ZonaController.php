<?php

namespace App\Http\Controllers;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;
use App\Models\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $cantidad = $request->get('cantidad', 10); // Por defecto 10 registros por página
    $buscar = $request->get('buscar'); // Texto ingresado en el buscador

    $zonas = Zona::when($buscar, function ($query, $buscar) { // Si hay un texto en el buscador
        // Filtrar por nombre de zona
        return $query->where('id_zona', 'like', "%$buscar%");
    })->paginate($cantidad);

    return view('zonas.index', compact('zonas'));
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
        $zonas = new Zona();
        $zonas->nombre_zona = $request->input('nombre_zona');
        $zonas->save();
        return redirect()->back()->with('success', 'Zona creada satisfactoriamente');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Zona $zona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zona $zona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zona $zona)
    {
        $zonas = Zona::find($zona->id_zona);
        $zonas->nombre_zona = $request->input('nombre_zona');
        $zonas->update();
        return redirect()->back()->with('success', 'Cambio satisfactorio');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zona $zona)
    {
        $zonas = Zona::find($zona->id_zona);
        $zonas->delete();
        return redirect()->back()->with('success', 'Eliminado satisfactoriamente');
    }


    
}
