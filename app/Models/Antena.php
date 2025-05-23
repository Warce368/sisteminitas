<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Direccion; // 
use App\Models\Cliente; // 

class Antena extends Model
{
    protected $table = 'antenas'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_antena'; // Clave primaria de la tabla
     // Si no usas timestamps, ponlo en false
    protected $fillable = [
        'nombre_antena',
        'id_direccion', // Relación con la tabla de direcciones
        'ip',

    ];
    public $timestamps = false;
    
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion', 'id_direccion');
    }


}
