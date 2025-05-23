<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Servicio; // Asegúrate de importar el modelo Zona
use App\Models\Direccion; // Asegúrate de importar el modelo Direccion
use App\Models\Pago; // Asegúrate de importar el modelo Pago
class Cliente extends Model
{
    protected $table = 'clientes'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_cliente'; // Nombre de la clave primaria
    protected $fillable = [
        // LOS MISMOS CAMPOS QUE ESTAN EN EL MODELO CLIENTE  (INCLUYE FK)
        'id_servicio',
        'id_direccion',
        'nombre',
        'tipo_persona',
        'tipo_documento', // Relación con la tabla de servicios
        'documento',
        'sexo',
        'telefono1',
        'telefono2',
        'email',
        'fecha_nacimiento',
        'fecha_creacion',
        'ip',
        'ip_fija',
        'coordenadas',
        'modo_pago',
        'prestado',
        'estado',
    ];
    public $timestamps = false; // REQUIERE 2 TABLAS PARA HACER LA RELACION, COMO NO TENEMOS LO PONEMOS EN FALSE

    // RELACION CON LA TABLA SERVICIO Y DIRECCION, UN CLIENTE PUEDE TENER UNA DIRECCION Y UN SERVICIO
    //COMO TENEMOS FK DE SERVICIO Y DIRECCION PONEMOS belongsTo

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion', 'id_direccion');
    }
    
    // RELACION CON LA TABLA PAGO, UN CLIENTE PUEDE TENER MUCHOS PAGOS

    public function pago()
    {
        return $this->hasMany(Pago::class, 'id_cliente', 'id_cliente');
    }
}

