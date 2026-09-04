<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Medicamentos - CONTROLMED</title>
<style>
body { font-family: Arial, sans-serif; margin: 30px; }
h1 { text-align: center; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { border: 1px solid #333; padding: 8px; text-align: left; }
th { background: #eee; }
.no-imprimir { text-align: center; margin-top: 20px; }
@media print {
    .no-imprimir { display: none; }
}
</style>
</head>
<body>

<h1>CONTROLMED - Reporte de Medicamentos</h1>
<p>Generado el {{ now()->format('Y-m-d H:i') }}</p>

<table>
<thead>
<tr>
<th>Medicamento</th>
<th>Cantidad</th>
<th>Fecha de vencimiento</th>
</tr>
</thead>
<tbody>
@forelse ($medicamentos as $medicamento)
<tr>
<td>{{ $medicamento->nombre }}</td>
<td>{{ $medicamento->cantidad }}</td>
<td>{{ $medicamento->fecha_vencimiento->format('Y-m-d') }}</td>
</tr>
@empty
<tr><td colspan="3">No hay medicamentos registrados</td></tr>
@endforelse
</tbody>
</table>

<div class="no-imprimir">
<button onclick="window.print()">Imprimir / Guardar como PDF</button>
</div>

</body>
</html>
