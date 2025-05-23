<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Direccion; // Asegúrate de importar el modelo Direccion

class Zona extends Model
{
    protected $table = 'zona';
    protected $primaryKey = 'id_zona';
    public $timestamps = false;

    protected $fillable = [
        'nombre_zona',
    ];

    public function direccion()
    {
        return $this->hasMany(Direccion::class, 'id_zona', 'id_zona');
    }
}
