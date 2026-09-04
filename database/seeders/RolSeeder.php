<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador', 'descripcion' => 'Acceso total al sistema'],
            ['nombre' => 'Supervisor del punto de entrega', 'descripcion' => 'Supervisa la entrega de medicamentos'],
            ['nombre' => 'Auxiliar de farmacia', 'descripcion' => 'Gestiona el inventario de medicamentos'],
            ['nombre' => 'Secretario de salud', 'descripcion' => 'Consulta reportes del sistema'],
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate(['nombre' => $rol['nombre']], $rol);
        }
    }
}
