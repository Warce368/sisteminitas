<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditoria;

class AuditoriaController extends Controller
{
    public function index(Request $request)
{
    $cantidad = $request->get('cantidad', 10);

    $logs = Auditoria::with('user')
        ->when($request->filled('tabla'), function ($query) use ($request) {
            $query->where('tabla', $request->tabla);
        })
        ->when($request->filled('registro_id'), function ($query) use ($request) {
            $query->where('registro_id', $request->registro_id);
        })
        ->latest()
        ->paginate($cantidad)
        ->appends($request->all()); // para que conserve los filtros en la paginación

    return view('auditoria.index', compact('logs'));
}
}
