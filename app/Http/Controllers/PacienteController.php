<?php

namespace App\Http\Controllers;

use App\Models\HistorialPaciente;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // GET /pacientes
    public function index()
    {
        $historial = HistorialPaciente::with('paciente')->latest('fecha')->get();
        return view('pacientes', compact('historial'));
    }

    // POST /pacientes
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'      => 'required|string|min:2|max:150|regex:/^[\pL\s\.]+$/u',
            'medicamento' => 'required|string|min:2|max:150',
            'fecha'       => 'required|date',
        ], [
            'required'     => 'Por favor complete todos los campos',
            'nombre.regex' => 'El nombre solo debe contener letras y espacios',
        ]);

        // Se busca el paciente por nombre, si no existe se crea (evita duplicar pacientes)
        $paciente = Paciente::firstOrCreate(['nombre' => $datos['nombre']]);

        HistorialPaciente::create([
            'paciente_id' => $paciente->id,
            'medicamento' => $datos['medicamento'],
            'fecha'       => $datos['fecha'],
        ]);

        return redirect()->route('pacientes.index')->with('exito', 'Paciente agregado correctamente');
    }

    // DELETE /pacientes/{historial}
    public function destroy(HistorialPaciente $historial)
    {
        $historial->delete();
        return redirect()->route('pacientes.index')->with('exito', 'Registro eliminado');
    }
}
