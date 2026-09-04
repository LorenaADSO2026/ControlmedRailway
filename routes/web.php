<?php

use App\Http\Controllers\AlertaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas (sin sesión)
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro'])->name('registro.submit');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren sesión iniciada)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/panel', [PanelController::class, 'index'])->name('panel');

    // Inventario / Medicamentos
    Route::get('/inventario', [MedicamentoController::class, 'index'])->name('inventario.index');
    Route::post('/inventario', [MedicamentoController::class, 'store'])->name('inventario.store');
    Route::put('/inventario/{medicamento}', [MedicamentoController::class, 'update'])->name('inventario.update');
    Route::delete('/inventario/{medicamento}', [MedicamentoController::class, 'destroy'])->name('inventario.destroy');

    // Pacientes
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::delete('/pacientes/{historial}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');

    // Alertas
    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/exportar-pdf', [ReporteController::class, 'exportarPDF'])->name('reportes.exportarPdf');
    Route::get('/reportes/exportar-excel', [ReporteController::class, 'exportarExcel'])->name('reportes.exportarExcel');

    // Configuración
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');

    // Usuarios (dentro de Configuración)
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // Roles (dentro de Configuración)
    Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{rol}', [RolController::class, 'destroy'])->name('roles.destroy');
});
