<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MascotaController;

// Página principal (formulario de filtro simple con tipos)
Route::get('/', [MascotaController::class, 'mostrarFormularioFiltro']);

// Consulta 1: Filtrar por tipo
Route::get('/mascotas/tipo', [MascotaController::class, 'mostrarPorTipoForm'])->name('mascotas.filtroTipo');
Route::post('/mascotas/tipo', [MascotaController::class, 'mascotasPorTipo'])->name('mascotas.porTipo');

// Consulta 2: Ordenar por edad
Route::get('/mascotas/ordenar', function () {
    return view('mascotas.form_orden');
})->name('mascotas.formOrden');




Route::post('/mascotas/ordenar', [MascotaController::class, 'ordenarPorEdad'])->name('mascotas.ordenEdad');

// Consulta 3: Filtrar por tipo, raza y cantidad (formulario y acción)
Route::get('/mascotas/filtrar', [MascotaController::class, 'mostrarFormularioFiltro'])->name('mascotas.formFiltro');
Route::post('/mascotas/filtrar', [MascotaController::class, 'filtrar'])->name('mascotas.filtrar');

// Página index de mascotas (si la implementas)
Route::get('/mascotas', [MascotaController::class, 'index'])->name('mascotas.index');
