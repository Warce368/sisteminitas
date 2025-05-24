<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zona; // Asegúrate de importar el modelo Zona
use App\Models\Antena; // Asegúrate de importar el modelo Cliente

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direcciones';
    protected $primaryKey = 'id_direccion';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre_direccion',
        'id_zona', // Relación con la tabla de zonas
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'id_zona', 'id_zona');
    }
    public function antena()
    {
        return $this->hasMany(Antena::class, 'id_direccion', 'id_direccion');
    }
    public function cliente()
    {
        return $this->hasMany(Antena::class, 'id_direccion', 'id_direccion');
    }

}
