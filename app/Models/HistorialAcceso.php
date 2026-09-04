<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialAcceso extends Model
{
    protected $table = 'historial_acceso';

    protected $fillable = ['usuario_id', 'accion', 'ip', 'fecha'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
