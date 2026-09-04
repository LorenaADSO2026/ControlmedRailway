<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Medicamento;
use App\Models\Paciente;

class PanelController extends Controller
{
    public function index()
    {
        $totalMedicamentos = Medicamento::count();
        $totalPacientes = Paciente::count();
        $totalAlertas = Alerta::where('estado', 'pendiente')->count();

        return view('panel', compact('totalMedicamentos', 'totalPacientes', 'totalAlertas'));
    }
}
