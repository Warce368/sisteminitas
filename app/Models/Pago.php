<?php

namespace App\Models;
use  App\Models\Cliente; // Asegúrate de importar el modelo Cliente
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    
    protected  $primaryKey = 'id_pago';
    protected $fillable = [
        'id_cliente',
        'fecha_plazo',
        'monto_debe',
        'monto_pagado',
        'descripcion_pago',
        'fecha_cancelada',
    ];
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
}
