<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteInventario extends Model
{
    protected $table = 'reportes_inventarios';

    protected $fillable = ['usuario_id', 'fecha_inicio', 'fecha_fin', 'formato'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
