<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_servicio'; // Nombre de la clave primaria
    protected $fillable = [
        'nombre_servicio',
        'descripcion',
        'valor_servicio',
        'velocidad_subida',
        'velocidad_bajada',
        'fecha'
    ];
    public $timestamps = false; // Desactivar los timestamps automáticos

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id_servicio', 'id_servicio');
    }
}

