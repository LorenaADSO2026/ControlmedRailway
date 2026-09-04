<?php

namespace App\Http\Controllers;

use App\Models\HistorialAcceso;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // GET /  -> pantalla inicio.html
    public function mostrarLogin()
    {
        if (Auth::check()) {
            return redirect()->route('panel');
        }
        return view('auth.inicio');
    }

    // POST /login
    public function login(Request $request)
    {
        $datos = $request->validate([
            'usuario' => 'required|string|max:60',
            'clave'   => 'required|string',
        ], [
            'usuario.required' => 'Por favor complete todos los campos',
            'clave.required'   => 'Por favor complete todos los campos',
        ]);

        $credenciales = [
            'usuario'  => $datos['usuario'],
            'password' => $datos['clave'],
        ];

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            HistorialAcceso::create([
                'usuario_id' => Auth::id(),
                'accion'     => 'login',
                'ip'         => $request->ip(),
                'fecha'      => now(),
            ]);

            return redirect()->route('panel');
        }

        HistorialAcceso::create([
            'usuario_id' => null,
            'accion'     => 'intento_fallido (' . $datos['usuario'] . ')',
            'ip'         => $request->ip(),
            'fecha'      => now(),
        ]);

        return back()
            ->withErrors(['login' => 'Usuario o contraseña incorrectos'])
            ->withInput($request->only('usuario'));
    }

    // GET /registro -> pantalla registro.html
    public function mostrarRegistro()
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('auth.registro', compact('roles'));
    }

    // POST /registro
    public function registro(Request $request)
    {
        $datos = $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula'   => 'required|string|max:20|unique:usuarios,cedula',
            'rol_id'   => 'required|exists:roles,id',
            'fecha'    => 'required|date',
            'usuario'  => 'required|string|max:60|unique:usuarios,usuario|alpha_dash',
            'clave'    => 'required|string|min:6',
        ], [
            'required'      => 'Por favor complete todos los campos',
            'cedula.unique' => 'Esa cédula ya está registrada',
            'usuario.unique'=> 'Ese nombre de usuario ya existe',
            'clave.min'     => 'La contraseña debe tener al menos 6 caracteres',
            'usuario.alpha_dash' => 'El usuario solo puede tener letras, números, guiones y guion bajo',
        ]);

        Usuario::create([
            'nombre'         => $datos['nombre'],
            'apellido'       => $datos['apellido'],
            'cedula'         => $datos['cedula'],
            'rol_id'         => $datos['rol_id'],
            'fecha_registro' => $datos['fecha'],
            'usuario'        => $datos['usuario'],
            'password'       => Hash::make($datos['clave']),
        ]);

        return redirect()->route('login')->with('exito', 'Registro exitoso, ahora puede iniciar sesión');
    }

    // POST /logout
    public function logout(Request $request)
    {
        if (Auth::check()) {
            HistorialAcceso::create([
                'usuario_id' => Auth::id(),
                'accion'     => 'logout',
                'ip'         => $request->ip(),
                'fecha'      => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
