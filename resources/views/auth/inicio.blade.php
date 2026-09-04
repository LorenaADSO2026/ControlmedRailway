<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>CONTROLMED - Inicio de sesión</title>
<link rel="stylesheet" href="{{ asset('CSS/estilos.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="contenedor">

<h1>CONTROLMED</h1>
<p class="subtitulo">Control inteligente de medicamentos</p>

<div class="card">

<img src="{{ asset('IMAGENES/CONTROLMED_LOGO.png') }}" class="logo">

@if (session('exito'))
    <p style="color: green; text-align: center;">{{ session('exito') }}</p>
@endif

@if ($errors->any())
    <p style="color: red; text-align: center;">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </p>
@endif

<form id="loginForm" method="POST" action="{{ route('login.submit') }}">
@csrf

<div class="input-group">
<i class="fa fa-user"></i>
<input type="text" id="usuario" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}">
</div>

<div class="input-group">
<i class="fa fa-lock"></i>
<input type="password" id="clave" name="clave" placeholder="Contraseña">
<i class="fa fa-eye"></i>
</div>

<button type="submit" class="btn" id="btnLogin">Iniciar sesión</button>

<p class="link">¿Olvidaste tu contraseña?</p>

<button type="button" class="btn" onclick="window.location.href='{{ route('registro') }}'">Registrarse</button>

<p class="link">¿Aún no te registras?</p>

</form>

</div>
</div>

<script src="{{ asset('JAVASCRIPT/inicio.js') }}"></script>

</body>
</html>
