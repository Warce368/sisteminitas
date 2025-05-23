<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auditoria extends Model
{
    use HasFactory;
    protected $table = 'auditorias';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'accion',
        'tabla',
        'registro_id',
        'descripcion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}