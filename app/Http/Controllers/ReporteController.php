<?php

namespace App\Http\Controllers;

use App\Models\HistorialAcceso;
use App\Models\Medicamento;
use App\Models\ReporteAcceso;
use App\Models\ReporteInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{
    // GET /reportes  (con filtro opcional por rango de fechas mediante formulario normal)
    public function index(Request $request)
    {
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');

        $consultaMedicamentos = Medicamento::query();
        $consultaAccesos = HistorialAcceso::with('usuario.rol');

        if ($fechaInicio && $fechaFin) {
            $consultaMedicamentos->whereBetween('fecha_vencimiento', [$fechaInicio, $fechaFin]);
            $consultaAccesos->whereBetween('fecha', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);
        }

        $medicamentos = $consultaMedicamentos->orderBy('fecha_vencimiento')->get();
        $accesos = $consultaAccesos->latest('fecha')->take(50)->get();

        return view('reportes.index', compact('medicamentos', 'accesos', 'fechaInicio', 'fechaFin'));
    }

    // GET /reportes/exportar-pdf -> vista imprimible (el usuario usa "Guardar como PDF" del navegador)
    public function exportarPDF(Request $request)
    {
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');

        $consulta = Medicamento::query();
        if ($fechaInicio && $fechaFin) {
            $consulta->whereBetween('fecha_vencimiento', [$fechaInicio, $fechaFin]);
        }
        $medicamentos = $consulta->orderBy('fecha_vencimiento')->get();

        ReporteInventario::create([
            'usuario_id'   => Auth::id(),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin'    => $fechaFin,
            'formato'      => 'pdf',
        ]);

        return view('reportes.pdf', compact('medicamentos'));
    }

    // GET /reportes/exportar-excel -> descarga CSV (se abre directamente en Excel)
    public function exportarExcel(Request $request): StreamedResponse
    {
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');

        $consulta = Medicamento::query();
        if ($fechaInicio && $fechaFin) {
            $consulta->whereBetween('fecha_vencimiento', [$fechaInicio, $fechaFin]);
        }
        $medicamentos = $consulta->orderBy('fecha_vencimiento')->get();

        ReporteInventario::create([
            'usuario_id'   => Auth::id(),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin'    => $fechaFin,
            'formato'      => 'excel',
        ]);

        $nombreArchivo = 'reporte_medicamentos_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($medicamentos) {
            $salida = fopen('php://output', 'w');
            fprintf($salida, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($salida, ['Medicamento', 'Cantidad', 'Fecha de vencimiento']);
            foreach ($medicamentos as $m) {
                fputcsv($salida, [$m->nombre, $m->cantidad, $m->fecha_vencimiento->format('Y-m-d')]);
            }
            fclose($salida);
        }, $nombreArchivo, ['Content-Type' => 'text/csv']);
    }
}
