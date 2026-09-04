<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>CONTROLMED</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos3.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<header>

<div class="logo">
<img src="{{ asset('IMAGENES/CONTROLMED_LOGO.png') }}" class="logo-img">CONTROLMED
</div>

<nav>
<ul class="menu">

<li>
<a href="{{ route('inventario.index') }}"><i class="fa fa-box"></i> Inventario</a>
<ul class="submenu">
<li><a href="{{ route('inventario.index') }}">Consultar medicamentos</a></li>
<li><a href="{{ route('inventario.index') }}">Actualizar medicamento</a></li>
<li><a href="{{ route('inventario.index') }}">Registrar medicamentos</a></li>
</ul>
</li>

<li>
<a href="{{ route('alertas.index') }}"><i class="fa fa-bell"></i> Alertas</a>
<ul class="submenu">
<li><a href="{{ route('alertas.index') }}">Medicamentos por vencer</a></li>
<li><a href="{{ route('alertas.index') }}">Medicamentos por agotarse</a></li>
</ul>
</li>

<li>
<a href="{{ route('pacientes.index') }}"><i class="fa fa-user"></i> Pacientes</a>
<ul class="submenu">
<li><a href="{{ route('pacientes.index') }}">Historial de pacientes</a></li>
</ul>
</li>

<li>
<a href="{{ route('reportes.index') }}"><i class="fa fa-chart-bar"></i> Reportes</a>
<ul class="submenu">
<li><a href="{{ route('reportes.index') }}">Reporte medicamentos</a></li>
<li><a href="{{ route('reportes.index') }}">Reporte accesos</a></li>
</ul>
</li>

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

<h1>Panel de Control</h1>
<h3>Gestión inteligente de medicamentos</h3>

<div class="tarjetas">

<div class="tarjeta">
<div class="icono"><i class="fa fa-pills"></i></div>
<a href="{{ route('inventario.index') }}"><h2>Inventario</h2></a>
<p>{{ $totalMedicamentos }} medicamentos registrados</p>
</div>

<div class="tarjeta">
<div class="icono"><i class="fa fa-bell"></i></div>
<a href="{{ route('alertas.index') }}"><h2>Alertas</h2></a>
<p>{{ $totalAlertas }} alertas pendientes</p>
</div>

<div class="tarjeta">
<div class="icono"><i class="fa fa-user"></i></div>
<a href="{{ route('pacientes.index') }}"><h2>Pacientes</h2></a>
<p>{{ $totalPacientes }} pacientes registrados</p>
</div>

<div class="tarjeta">
<div class="icono"><i class="fa fa-chart-line"></i></div>
<a href="{{ route('reportes.index') }}"><h2>Reportes</h2></a>
<p>Estadísticas del sistema sobre medicamentos y accesos</p>
</div>

<div class="tarjeta">
<div class="icono"><i class="fa fa-cog"></i></div>
<a href="{{ route('configuracion.index') }}"><h2>Configuración</h2></a>
<p>Ajustes del sistema</p>
</div>
</div>
</section>

<script src="{{ asset('JAVASCRIPT/panel.js') }}"></script>

</body>
</html>
