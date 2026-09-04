<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = ['nombre', 'documento'];

    public function historial()
    {
        return $this->hasMany(HistorialPaciente::class, 'paciente_id');
    }
}
