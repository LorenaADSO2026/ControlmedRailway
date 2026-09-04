<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reportes - CONTROLMED</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos7.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<header>
<div class="logo">
<img src="{{ asset('IMAGENES/CONTROLMED_LOGO.png') }}" class="logo-img"> CONTROLMED
</div>

<nav>
<ul>
<li><a href="{{ route('inventario.index') }}"><i class="fa fa-box"></i> Inventario</a></li>
<li><a href="{{ route('alertas.index') }}"><i class="fa fa-bell"></i> Alertas</a></li>
<li><a href="{{ route('pacientes.index') }}"><i class="fa fa-user"></i> Pacientes</a></li>
<li><a href="{{ route('reportes.index') }}"><i class="fa fa-chart-bar"></i> Reportes</a></li>
<li><a href="{{ route('configuracion.index') }}"><i class="fa fa-cog"></i> Configuración</a></li>
<li>
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
@csrf
<button type="submit" class="salir" style="background:none;border:none;color:inherit;cursor:pointer;font:inherit;">
<i class="fa fa-sign-out"></i> Salir
</button>
</form>
</li>
</ul>
</nav>
</header>

<section class="principal">

<h1>Módulo de Reportes</h1>
<p>Información del sistema y control de acceso</p>

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<!-- Formulario normal (GET), sin AJAX. Filtra por rango de fechas de vencimiento / acceso -->
<form class="filtros" id="formFiltros" method="GET" action="{{ route('reportes.index') }}">

<label>Fecha inicio</label>
<input type="date" id="fechaInicio" name="fecha_inicio" value="{{ $fechaInicio }}">

<label>Fecha fin</label>
<input type="date" id="fechaFin" name="fecha_fin" value="{{ $fechaFin }}">

<button type="submit">Filtrar</button>

<button type="button" onclick="exportarPDF()">Exportar PDF</button>
<button type="button" onclick="exportarExcel()">Exportar Excel</button>

</form>

<div class="tarjetas">
<div class="tarjeta">
<i class="fa fa-pills"></i>
<h3>Reporte de medicamentos</h3>
<p>Inventario registrado</p>
</div>

<div class="tarjeta">
<i class="fa fa-user-shield"></i>
<h3>Acceso por roles</h3>
<p>Control de usuarios</p>
</div>
</div>

<h2>Reporte de Medicamentos</h2>

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
<tr><td colspan="3">No hay medicamentos para el rango seleccionado</td></tr>
@endforelse
</tbody>
</table>

<h2>Reporte de Acceso por Roles</h2>

<table>
<thead>
<tr>
<th>Usuario</th>
<th>Rol</th>
<th>Último acceso</th>
</tr>
</thead>

<tbody>
@forelse ($accesos as $acceso)
<tr>
<td>{{ $acceso->usuario ? $acceso->usuario->nombre . ' ' . $acceso->usuario->apellido : 'Desconocido' }}</td>
<td>{{ $acceso->usuario && $acceso->usuario->rol ? $acceso->usuario->rol->nombre : '-' }}</td>
<td>{{ $acceso->fecha }}</td>
</tr>
@empty
<tr><td colspan="3">No hay accesos registrados</td></tr>
@endforelse
</tbody>
</table>

</section>

<script>
    // Se pasan las rutas base de Laravel al archivo JS externo
    const RUTA_EXPORTAR_PDF = "{{ route('reportes.exportarPdf') }}";
    const RUTA_EXPORTAR_EXCEL = "{{ route('reportes.exportarExcel') }}";
</script>
<script src="{{ asset('JAVASCRIPT/reportes.js') }}"></script>

</body>
</html>
