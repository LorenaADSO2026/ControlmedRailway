<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pacientes - CONTROLMED</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos6.css') }}">
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

<h1>Historial de Pacientes Frecuentes</h1>
<p>Registro de pacientes y medicamentos asignados</p>

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

<form id="formPacientes" method="POST" action="{{ route('pacientes.store') }}">
@csrf
<input type="text" id="nombre" name="nombre" placeholder="Nombre del paciente" value="{{ old('nombre') }}" maxlength="150">
<input type="text" id="medicamento" name="medicamento" placeholder="Medicamento" value="{{ old('medicamento') }}" maxlength="150">
<input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}">

<button type="submit">Agregar</button>
</form>

</div>

<table id="tablaPacientes">

<thead>
<tr>
<th>Paciente</th>
<th>Medicamento</th>
<th>Fecha</th>
<th>Acción</th>
</tr>
</thead>

<tbody>
@forelse ($historial as $registro)
<tr>
<td>{{ $registro->paciente->nombre }}</td>
<td>{{ $registro->medicamento }}</td>
<td>{{ $registro->fecha->format('Y-m-d') }}</td>
<td>
    <form action="{{ route('pacientes.destroy', $registro) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Desea eliminar este registro?');">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="4">No hay pacientes registrados</td></tr>
@endforelse
</tbody>
</table>
</section>

<script src="{{ asset('JAVASCRIPT/pacientes.js') }}"></script>

</body>
</html>
