<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Configuración - CONTROLMED</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos8.css') }}">
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

<h1>Configuración del sistema</h1>
<p>Administración de usuarios y ajustes</p>

<div class="tarjetas">

<div class="tarjeta">
<div class="icono">
<i class="fa fa-users"></i>
</div>
<h2>Usuarios</h2>
<p>Administrar usuarios del sistema</p>
<a href="{{ route('usuarios.index') }}"><button type="button">Gestionar</button></a>
</div>

<div class="tarjeta">
<div class="icono">
<i class="fa fa-user-shield"></i>
</div>
<h2>Roles</h2>
<p>Administrar permisos del sistema</p>
<a href="{{ route('roles.index') }}"><button type="button">Gestionar</button></a>
</div>

</div>
</section>

</body>
</html>
