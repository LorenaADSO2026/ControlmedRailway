<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Medicamento;

class AlertaController extends Controller
{
    // GET /alertas
    public function index()
    {
        // Recalcula alertas vigentes contra el inventario actual
        $medicamentos = Medicamento::all();

        foreach ($medicamentos as $medicamento) {
            if ($medicamento->bajo_stock) {
                Alerta::firstOrCreate(
                    ['medicamento_id' => $medicamento->id, 'tipo' => 'bajo_stock', 'estado' => 'pendiente'],
                    ['mensaje' => "Inventario bajo: {$medicamento->nombre} ({$medicamento->cantidad} unidades)"]
                );
            }
            if ($medicamento->esta_por_vencer || $medicamento->ya_vencio) {
                Alerta::firstOrCreate(
                    ['medicamento_id' => $medicamento->id, 'tipo' => 'vencimiento', 'estado' => 'pendiente'],
                    ['mensaje' => "{$medicamento->nombre} vence el " . $medicamento->fecha_vencimiento->format('Y-m-d')]
                );
            }
        }

        $alertas = Alerta::with('medicamento')
            ->where('estado', 'pendiente')
            ->latest('fecha_generada')
            ->get();

        $porVencer = $alertas->where('tipo', 'vencimiento')->count();
        $bajoStock = $alertas->where('tipo', 'bajo_stock')->count();

        return view('alertas', compact('alertas', 'porVencer', 'bajoStock'));
    }
}
