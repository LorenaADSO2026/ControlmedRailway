<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Inventario - CONTROLMED</title>
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

<h1>Módulo de Inventario</h1>

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

<h2>Agregar medicamento</h2>

<form id="formInventario" method="POST" action="{{ route('inventario.store') }}">
@csrf
<input type="text" id="nombre" name="nombre" placeholder="Nombre del medicamento" value="{{ old('nombre') }}" maxlength="150">
<input type="number" id="codigo" name="codigo" placeholder="Código" value="{{ old('codigo') }}">
<input type="text" id="lote" name="lote" placeholder="Número de lote" value="{{ old('lote') }}" maxlength="50">
<input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}">
<input type="number" id="cantidad" name="cantidad" placeholder="Cantidad" min="0" value="{{ old('cantidad') }}">
<textarea id="observaciones" name="observaciones" placeholder="Observaciones" maxlength="500">{{ old('observaciones') }}</textarea>

<button type="submit">Agregar</button>
</form>

</div>

<table id="tablaInventario">

<thead>
<tr>
<th>Medicamento</th>
<th>Código</th>
<th>Lote</th>
<th>Fecha de vencimiento</th>
<th>Cantidad</th>
<th>Observaciones</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>
@forelse ($medicamentos as $medicamento)
<tr class="{{ $medicamento->ya_vencio || $medicamento->esta_por_vencer ? 'rojo' : ($medicamento->bajo_stock ? 'naranja' : '') }}">
<td>{{ $medicamento->nombre }}</td>
<td>{{ $medicamento->codigo }}</td>
<td>{{ $medicamento->lote }}</td>
<td>{{ $medicamento->fecha_vencimiento->format('Y-m-d') }}</td>
<td>{{ $medicamento->cantidad }}</td>
<td>{{ $medicamento->observaciones }}</td>
<td>
    <form action="{{ route('inventario.destroy', $medicamento) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Desea eliminar este medicamento?');">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar</button>
    </form>
</td>
</tr>
@empty
<tr><td colspan="7">No hay medicamentos registrados</td></tr>
@endforelse
</tbody>
</table>
</section>

<script src="{{ asset('JAVASCRIPT/inventario.js') }}"></script>

</body>
</html>
