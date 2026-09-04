<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Alertas - CONTROLMED</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos5.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<header>
<div class="logo">
<img src="{{ asset('IMAGENES/CONTROLMED_LOGO.png') }}" class="logo-img">CONTROLMED
</div>

<nav>
<ul>
<li><a href="{{ route('inventario.index') }}"><i class="fa fa-box"></i> Inventario</a></li>
<li><a href="{{ route('alertas.index') }}"><i class="fa fa-bell"></i> Alertas</a></li>
<li><a href="{{ route('pacientes.index') }}"><i class="fa fa-notes-medical"></i> Pacientes</a></li>
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

<h1>Alertas del Sistema</h1>
<p>Medicamentos próximos a vencer o con bajo inventario</p>

<div class="alertas-container">

<div class="alerta">
<i class="fa fa-exclamation-triangle"></i>
<h3>Medicamentos por vencer</h3>
<p>{{ $porVencer }} medicamento(s) vencen pronto</p>
</div>

<div class="alerta">
<i class="fa fa-box-open"></i>
<h3>Inventario bajo</h3>
<p>{{ $bajoStock }} medicamento(s) con pocas unidades</p>
</div>

</div>

<h2>Medicamentos con alerta</h2>

<table>

<thead>
<tr>
<th>Medicamento</th>
<th>Mensaje</th>
<th>Fecha de vencimiento</th>
<th>Estado</th>
</tr>
</thead>

<tbody>
@forelse ($alertas as $alerta)
<tr>
<td>{{ $alerta->medicamento->nombre }}</td>
<td>{{ $alerta->mensaje }}</td>
<td>{{ $alerta->medicamento->fecha_vencimiento->format('Y-m-d') }}</td>
<td class="{{ $alerta->tipo === 'vencimiento' ? 'rojo' : 'naranja' }}">
    {{ $alerta->tipo === 'vencimiento' ? 'Por vencer' : 'Inventario bajo' }}
</td>
</tr>
@empty
<tr><td colspan="4">No hay alertas pendientes</td></tr>
@endforelse
</tbody>

</table>

</section>

<script src="{{ asset('JAVASCRIPT/alertas.js') }}"></script>

</body>
</html>
