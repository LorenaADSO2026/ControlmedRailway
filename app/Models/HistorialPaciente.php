<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialPaciente extends Model
{
    protected $table = 'historial_pacientes';

    protected $fillable = ['paciente_id', 'medicamento', 'fecha'];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
