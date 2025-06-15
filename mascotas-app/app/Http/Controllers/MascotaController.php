<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Http\Controllers\Controller; 
  

class MascotaController extends Controller
{
    // Mostrar formulario para elegir tipo
    public function mostrarPorTipoForm()
    {
        $conteoPorTipo = Mascota::selectRaw('tipo, COUNT(*) as total')
                            ->groupBy('tipo')
                            ->pluck('total', 'tipo')
                            ->toArray();

        return view('mascotas.filtro_tipo', compact('conteoPorTipo'));
    }


    // Consulta 1: Mascotas por tipo
    public function mascotasPorTipo(Request $request)
    {
        $tipo = $request->input('tipo');

        $mascotas = Mascota::when($tipo, function ($query, $tipo) {
            return $query->where('tipo', $tipo);
        })->get();

        $conteoPorTipo = Mascota::selectRaw('tipo, COUNT(*) as total')
                            ->groupBy('tipo')
                            ->pluck('total', 'tipo')
                            ->toArray();

        $tiposDisponibles = Mascota::select('tipo')->distinct()->pluck('tipo')->toArray();

        return view('mascotas.filtro_tipo', [
            'mascotas' => $mascotas,
            'tipo' => $tipo,
            'conteoPorTipo' => $conteoPorTipo,
            'tiposDisponibles' => $tiposDisponibles
        ]);
    }



    // Consulta 2: Ordenar por edad
    public function ordenarPorEdad(Request $request)
    {
        $orden = $request->input('orden', 'asc');
        $mascotas = Mascota::orderBy('edad', $orden)->get();

        return view('mascotas.resultado_orden', compact('mascotas', 'orden'));
    }

    // Consulta 3: Filtrar por tipo y raza, mostrar cantidad específica
    public function filtrar(Request $request)
    {
        $tipo = $request->input('tipo');

        $query = Mascota::query();

        if (!empty($tipo)) {
            $query->where('tipo', $tipo);
        }

        $mascotas = $query->get();

        // Obtener todos los tipos únicos disponibles
        $tiposDisponibles = Mascota::select('tipo')->distinct()->pluck('tipo');

        return view('mascotas.form_filtro', compact('mascotas', 'tiposDisponibles', 'tipo'));
    }

  

    public function mostrarFormularioFiltro()
    {
        $tiposDisponibles = Mascota::select('tipo')->distinct()->pluck('tipo')->toArray();
        $tipo = null; // Por si acaso la vista espera esto también
        $mascotas = [];

        return view('mascotas.form_filtro', compact('tiposDisponibles', 'tipo'));
    }

}
