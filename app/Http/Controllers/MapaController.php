<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class MapaController extends Controller
{
    public function mostrar()
    {
        return response()->file(storage_path('app/private/topografia.png'));
    }
}
