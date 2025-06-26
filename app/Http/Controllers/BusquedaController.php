<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Servicio;

/**
 * Controlador para manejar las búsquedas de productos y servicios.
 *
 * Métodos:
 * - buscar(Request $request): Realiza una búsqueda de productos y servicios activos
 *   según el término proporcionado en la solicitud ('q'). Busca coincidencias en los
 *   campos 'nombreProducto' y 'descripcionProducto' para productos, y en
 *   'nombreServicio' y 'descripcionServicio' para servicios, filtrando solo los que
 *   tienen 'idEstado' igual a 1 (activos). Retorna la vista 'busqueda.resultados'
 *   con los resultados encontrados.
 *
 */
class BusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $q = $request->input('q');
        $productos = collect();
        $servicios = collect();
        if ($q) {
            $productos = Producto::where('nombreProducto', 'like', "%$q%")
                ->orWhere('descripcionProducto', 'like', "%$q%")
                ->where('idEstado', 1)
                ->get();
            $servicios = Servicio::where('nombreServicio', 'like', "%$q%")
                ->orWhere('descripcionServicio', 'like', "%$q%")
                ->where('idEstado', 1)
                ->get();
        }
        return view('busqueda.resultados', compact('q', 'productos', 'servicios'));
    }
}
