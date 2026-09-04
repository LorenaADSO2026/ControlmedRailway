<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios - CONTROLMED</title>
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

<h1>Gestión de Usuarios</h1>
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

<table>
<thead>
<tr>
<th>Nombre</th>
<th>Apellido</th>
<th>Cédula</th>
<th>Usuario</th>
<th>Rol</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
@forelse ($usuarios as $usuario)
{{-- Formularios declarados fuera de la fila y referenciados con el atributo "form" (HTML5),
     así se evita anidar/dividir <form> dentro de <tr>/<td> --}}
<form id="editar-usuario-{{ $usuario->id }}" action="{{ route('usuarios.update', $usuario) }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PUT">
</form>
<form id="eliminar-usuario-{{ $usuario->id }}" action="{{ route('usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Desea eliminar este usuario?');">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="DELETE">
</form>

<tr>
<td>
    <input type="text" name="nombre" form="editar-usuario-{{ $usuario->id }}" value="{{ $usuario->nombre }}" maxlength="100" required>
</td>
<td>
    <input type="text" name="apellido" form="editar-usuario-{{ $usuario->id }}" value="{{ $usuario->apellido }}" maxlength="100" required>
</td>
<td>{{ $usuario->cedula }}</td>
<td>{{ $usuario->usuario }}</td>
<td>
    <select name="rol_id" form="editar-usuario-{{ $usuario->id }}" required>
        @foreach ($roles as $rol)
        <option value="{{ $rol->id }}" {{ $usuario->rol_id == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
        @endforeach
    </select>
</td>
<td>
    <button type="submit" form="editar-usuario-{{ $usuario->id }}">Guardar</button>
    <button type="submit" form="eliminar-usuario-{{ $usuario->id }}">Eliminar</button>
</td>
</tr>
@empty
<tr><td colspan="6">No hay usuarios registrados</td></tr>
@endforelse
</tbody>
</table>

</section>

</body>
</html>
