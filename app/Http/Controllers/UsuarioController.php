<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // GET /usuarios
    public function index()
    {
        $usuarios = Usuario::with('rol')->orderBy('nombre')->get();
        $roles = Rol::orderBy('nombre')->get();
        return view('usuarios', compact('usuarios', 'roles'));
    }

    // PUT /usuarios/{usuario}
    public function update(Request $request, Usuario $usuario)
    {
        $datos = $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'rol_id'   => 'required|exists:roles,id',
        ], [
            'required' => 'Por favor complete todos los campos',
        ]);

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario actualizado');
    }

    // DELETE /usuarios/{usuario}
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('exito', 'Usuario eliminado');
    }
}
