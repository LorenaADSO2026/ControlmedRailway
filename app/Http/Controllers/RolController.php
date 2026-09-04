<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // GET /roles
    public function index()
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('roles', compact('roles'));
    }

    // POST /roles
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'      => 'required|string|max:100|unique:roles,nombre',
            'descripcion' => 'nullable|string|max:255',
        ], [
            'required'      => 'Por favor complete todos los campos',
            'nombre.unique' => 'Ya existe un rol con ese nombre',
        ]);

        Rol::create($datos);

        return redirect()->route('roles.index')->with('exito', 'Rol creado correctamente');
    }

    // DELETE /roles/{rol}
    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('roles.index')->with('exito', 'Rol eliminado');
    }
}
