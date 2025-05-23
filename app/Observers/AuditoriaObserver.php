<?php  
namespace App\Observers;

use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class AuditoriaObserver
{
    public function created($model)
    {
        Auditoria::create([
            'user_id' => Auth::id(),
            'accion' => 'create',
            'tabla' => $model->getTable(),
            'registro_id' => $model->getKey(),
            'descripcion' => 'Registro creado ID ' . $model->getKey(),
        ]);
    }

    public function updated($model)
    {
        Auditoria::create([
            'user_id' => Auth::id(),
            'accion' => 'update',
            'tabla' => $model->getTable(),
            'registro_id' => $model->getKey(),
            'descripcion' => 'Registro actualizado ID ' . $model->getKey(),
        ]);
    }

    public function deleted($model)
    {
        Auditoria::create([
            'user_id' => Auth::id(),
            'accion' => 'delete',
            'tabla' => $model->getTable(),
            'registro_id' => $model->getKey(),
            'descripcion' => 'Registro eliminado ID ' . $model->getKey(),
        ]);
    }
}