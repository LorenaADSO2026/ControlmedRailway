<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Roles - CONTROLMED</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos8.css') }}">
<link rel="stylesheet" href="{{ asset('CSS/estilos4.css') }}">
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

<h1>Gestión de Roles</h1>
<p><a href="{{ route('configuracion.index') }}">&larr; Volver a Configuración</a></p>

@if (session('exito'))
    <p style="color: green;">{{ session('exito') }}</p>
@endif

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div class="formulario">
<h2>Agregar rol</h2>
<form method="POST" action="{{ route('roles.store') }}">
@csrf
<input type="text" name="nombre" placeholder="Nombre del rol" maxlength="100" value="{{ old('nombre') }}">
<input type="text" name="descripcion" placeholder="Descripción" maxlength="255" value="{{ old('descripcion') }}">
<button type="submit">Agregar</button>
</form>
</div>

<table>
<thead>
<tr>
<th>Rol</th>
<th>Descripción</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
@forelse ($roles as $rol)
<tr>
<td>{{ $rol->nombre }}</td>
<td>{{ $rol->descripcion }}</td>
<td>
    <form action="{{ route('roles.destroy', $rol) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Desea eliminar este rol?');">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="3">No hay roles registrados</td></tr>
@endforelse
</tbody>
</table>

</section>

</body>
</html>
