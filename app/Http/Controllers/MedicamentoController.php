<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\InventarioMovimiento;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicamentoController extends Controller
{
    // GET /inventario
    public function index()
    {
        $medicamentos = Medicamento::orderBy('nombre')->get();
        return view('inventario', compact('medicamentos'));
    }

    // POST /inventario
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'        => 'required|string|min:2|max:150',
            'codigo'        => 'required|numeric|digits_between:1,20|unique:medicamentos,codigo',
            'lote'          => 'required|string|max:50|regex:/^[A-Za-z0-9\-]+$/',
            'fecha'         => 'required|date',
            'cantidad'      => 'required|integer|min:0|max:1000000',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'required'        => 'Por favor complete todos los campos',
            'codigo.numeric'  => 'El código solo debe contener números',
            'codigo.unique'   => 'Ya existe un medicamento con ese código',
            'lote.regex'      => 'El lote solo admite letras, números y guiones (sin caracteres especiales)',
            'cantidad.integer'=> 'La cantidad debe ser un número entero',
            'cantidad.min'    => 'La cantidad no puede ser negativa',
        ]);

        $medicamento = Medicamento::create([
            'nombre'         => $datos['nombre'],
            'codigo'         => $datos['codigo'],
            'lote'           => $datos['lote'],
            'fecha_vencimiento' => $datos['fecha'],
            'cantidad'       => $datos['cantidad'],
            'observaciones'  => $datos['observaciones'] ?? null,
        ]);

        InventarioMovimiento::create([
            'medicamento_id' => $medicamento->id,
            'usuario_id'     => Auth::id(),
            'tipo_movimiento'=> 'entrada',
            'cantidad'       => $medicamento->cantidad,
            'observaciones'  => 'Registro inicial del medicamento',
        ]);

        $this->generarAlertasSiAplica($medicamento);

        return redirect()->route('inventario.index')->with('exito', 'Medicamento agregado correctamente');
    }

    // PUT /inventario/{medicamento}
    public function update(Request $request, Medicamento $medicamento)
    {
        $datos = $request->validate([
            'nombre'        => 'required|string|min:2|max:150',
            'codigo'        => 'required|numeric|digits_between:1,20|unique:medicamentos,codigo,' . $medicamento->id,
            'lote'          => 'required|string|max:50|regex:/^[A-Za-z0-9\-]+$/',
            'fecha'         => 'required|date',
            'cantidad'      => 'required|integer|min:0|max:1000000',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'required'        => 'Por favor complete todos los campos',
            'codigo.numeric'  => 'El código solo debe contener números',
            'codigo.unique'   => 'Ya existe un medicamento con ese código',
            'lote.regex'      => 'El lote solo admite letras, números y guiones',
        ]);

        $cantidadAnterior = $medicamento->cantidad;

        $medicamento->update([
            'nombre'         => $datos['nombre'],
            'codigo'         => $datos['codigo'],
            'lote'           => $datos['lote'],
            'fecha_vencimiento' => $datos['fecha'],
            'cantidad'       => $datos['cantidad'],
            'observaciones'  => $datos['observaciones'] ?? null,
        ]);

        if ($cantidadAnterior != $medicamento->cantidad) {
            InventarioMovimiento::create([
                'medicamento_id' => $medicamento->id,
                'usuario_id'     => Auth::id(),
                'tipo_movimiento'=> 'ajuste',
                'cantidad'       => $medicamento->cantidad - $cantidadAnterior,
                'observaciones'  => 'Actualización de cantidad',
            ]);
        }

        $this->generarAlertasSiAplica($medicamento);

        return redirect()->route('inventario.index')->with('exito', 'Medicamento actualizado correctamente');
    }

    // DELETE /inventario/{medicamento}
    public function destroy(Medicamento $medicamento)
    {
        InventarioMovimiento::create([
            'medicamento_id' => $medicamento->id,
            'usuario_id'     => Auth::id(),
            'tipo_movimiento'=> 'eliminacion',
            'cantidad'       => $medicamento->cantidad,
            'observaciones'  => 'Medicamento eliminado del inventario',
        ]);

        $medicamento->delete();

        return redirect()->route('inventario.index')->with('exito', 'Medicamento eliminado');
    }

    // Genera automáticamente alertas de bajo stock / próximo a vencer
    private function generarAlertasSiAplica(Medicamento $medicamento): void
    {
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
}
