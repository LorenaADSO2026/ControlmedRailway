<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>CONTROLMED - Registro</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos2.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="contenedor">

<h1>CONTROLMED</h1>
<p class="subtitulo">Control inteligente de medicamentos</p>

<div class="card">

<img src="{{ asset('IMAGENES/CONTROLMED_LOGO.png') }}" class="logo">

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form id="registroForm" method="POST" action="{{ route('registro.submit') }}">
@csrf

<div class="input-group">
<i class="fa fa-user"></i>
<input type="text" id="nombre" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" required maxlength="100">
</div>

<div class="input-group">
<i class="fa fa-user"></i>
<input type="text" id="apellido" name="apellido" placeholder="Apellido" value="{{ old('apellido') }}" required maxlength="100">
</div>

<div class="input-group">
<i class="fa fa-id-card"></i>
<input type="text" id="cedula" name="cedula" placeholder="Cédula" value="{{ old('cedula') }}" required maxlength="20" pattern="[0-9]+" title="Solo números">
</div>

<div class="input-group">
<i class="fa fa-user-tag"></i>
<select id="rol_id" name="rol_id" required>
<option value="">Seleccione un rol</option>
@foreach ($roles as $rol)
<option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
@endforeach
</select>
</div>

<div class="input-group">
<i class="fa fa-calendar"></i>
<input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
</div>

<div class="input-group">
<i class="fa fa-user-circle"></i>
<input type="text" id="usuario" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}" required maxlength="60">
</div>

<div class="input-group">
<i class="fa fa-lock"></i>
<input type="password" id="clave" name="clave" placeholder="Contraseña" required minlength="6">
</div>

<button type="submit" class="btn">Registrarse</button>

</form>
</div>
</div>

<script src="{{ asset('JAVASCRIPT/registro.js') }}"></script>
</body>
</html>
