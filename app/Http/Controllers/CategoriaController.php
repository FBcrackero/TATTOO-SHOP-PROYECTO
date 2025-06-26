<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaProducto;
use App\Models\Estado;

/**
 * Controlador para la gestión de categorías de productos.
 *
 * Métodos disponibles:
 * - index(): Muestra la lista de categorías con su estado.
 * - create(): Muestra el formulario para crear una nueva categoría.
 * - store(Request $request): Almacena una nueva categoría en la base de datos.
 * - modificar(Request $request): Muestra el formulario para modificar una categoría existente.
 * - update(Request $request, $id): Actualiza los datos de una categoría existente.
 * - eliminar(Request $request): Muestra el formulario para eliminar una categoría.
 * - destroy($id): Elimina una categoría de la base de datos.
 * - consultar(Request $request): Permite consultar y filtrar categorías según criterios de búsqueda.
 * - reporte(Request $request): Genera un reporte de categorías según filtros de búsqueda.
 * - estado(Request $request): Muestra el formulario para cambiar el estado de una categoría.
 * - estadoUpdate(Request $request, $id): Actualiza el estado de una categoría.
 *
 * Validaciones:
 * - Los campos nombre, descripción y nomenclatura de la categoría son requeridos y deben ser únicos según corresponda.
 * - El estado debe existir en la tabla de estados.
 *
 * Vistas relacionadas:
 * - configuración.categoria.categoria
 * - configuración.categoria.ingresarCategoria
 * - configuración.categoria.modificarCategoria
 * - configuración.categoria.eliminarCategoria
 * - configuración.categoria.consultarCategoria
 * - configuración.categoria.reporteCategoria
 * - configuración.categoria.estadoCategoria
 *
 * Modelos utilizados:
 * - \App\Models\CategoriaProducto
 * - \App\Models\Estado
 */

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = CategoriaProducto::with('estado')->get();
        return view('configuración.categoria.categoria', compact('categorias'));
    }

    public function create()
    {
        return view('configuración.categoria.ingresarCategoria');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreCategoriaProducto' => 'required|string|max:40|unique:categoriaProductos,nombreCategoriaProducto',
            'descripcionCategoriaProducto' => 'required|string|max:100',
            'nomenclaturaCategoriaProducto' => 'required|string|max:4|unique:categoriaProductos,nomenclaturaCategoriaProducto',
            'idEstado' => 'required|integer|exists:estado,idEstado',
        ]);

        \App\Models\CategoriaProducto::create([
            'nombreCategoriaProducto' => $request->nombreCategoriaProducto,
            'descripcionCategoriaProducto' => $request->descripcionCategoriaProducto,
            'nomenclaturaCategoriaProducto' => $request->nomenclaturaCategoriaProducto,
            'idEstado' => $request->idEstado,
        ]);

        return redirect()->route('categoria.ingresar')->with('success', 'Categoría ingresada correctamente.');
    }

    public function modificar(Request $request)
    {
        $categorias = \App\Models\CategoriaProducto::all();
        $estados = \App\Models\Estado::all();
        $categoriaSeleccionada = null;

        if ($request->filled('categoria_id')) {
            $categoriaSeleccionada = \App\Models\CategoriaProducto::find($request->categoria_id);
        }

        return view('configuración.categoria.modificarCategoria', compact('categorias', 'estados', 'categoriaSeleccionada'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreCategoriaProducto' => 'required|string|max:40|unique:categoriaProductos,nombreCategoriaProducto,' . $id . ',idCategoriaProducto',
            'descripcionCategoriaProducto' => 'required|string|max:100',
            'nomenclaturaCategoriaProducto' => 'required|string|max:4|unique:categoriaProductos,nomenclaturaCategoriaProducto,' . $id . ',idCategoriaProducto',

        ]);

        $categoria = \App\Models\CategoriaProducto::findOrFail($id);
        $categoria->update([
            'nombreCategoriaProducto' => $request->nombreCategoriaProducto,
            'descripcionCategoriaProducto' => $request->descripcionCategoriaProducto,
            'nomenclaturaCategoriaProducto' => $request->nomenclaturaCategoriaProducto,

        ]);

        return redirect()->route('categoria.modificar', ['categoria_id' => $id])->with('success', 'Categoría modificada correctamente.');
    }

    public function eliminar(Request $request)
    {
        $categorias = \App\Models\CategoriaProducto::all();
        $categoriaSeleccionada = null;

        if ($request->filled('categoria_id')) {
            $categoriaSeleccionada = \App\Models\CategoriaProducto::find($request->categoria_id);
        }

        return view('configuración.categoria.eliminarCategoria', compact('categorias', 'categoriaSeleccionada'));
    }

    public function destroy($id)
    {
        $categoria = \App\Models\CategoriaProducto::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categoria.eliminar')->with('success', 'Categoría eliminada correctamente.');
    }

    public function consultar(Request $request)
    {
        $query = \App\Models\CategoriaProducto::with('estado');

        if ($request->filled('limpiar')) {
            return redirect()->route('categoria.consultar');
        }

        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $filtro = $request->input('filtro', 'nombre');

            if ($filtro === 'nombre') {
                $query->where('nombreCategoriaProducto', 'like', "%$busqueda%");
            } elseif ($filtro === 'nomenclatura') {
                $query->where('nomenclaturaCategoriaProducto', 'like', "%$busqueda%");
            } elseif ($filtro === 'general') {
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombreCategoriaProducto', 'like', "%$busqueda%")
                    ->orWhere('descripcionCategoriaProducto', 'like', "%$busqueda%")
                    ->orWhere('nomenclaturaCategoriaProducto', 'like', "%$busqueda%")
                    ->orWhere('idCategoriaProducto', $busqueda);
                });
            }
        }

        $categorias = $query->orderBy('idCategoriaProducto')->get();

        return view('configuración.categoria.consultarCategoria', compact('categorias'));
    }

    public function reporte(Request $request)
    {
        $query = \App\Models\CategoriaProducto::with('estado');

        $filtro = $request->input('filtro', 'nombre');
        $busqueda = $request->input('busqueda');

        if ($busqueda) {
            if ($filtro === 'nombre') {
                $query->where('nombreCategoriaProducto', 'like', "%$busqueda%");
            } elseif ($filtro === 'nomenclatura') {
                $query->where('nomenclaturaCategoriaProducto', 'like', "%$busqueda%");
            } elseif ($filtro === 'general') {
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombreCategoriaProducto', 'like', "%$busqueda%")
                    ->orWhere('descripcionCategoriaProducto', 'like', "%$busqueda%")
                    ->orWhere('nomenclaturaCategoriaProducto', 'like', "%$busqueda%")
                    ->orWhere('idCategoriaProducto', $busqueda);
                });
            }
        }

        $categorias = $query->orderBy('idCategoriaProducto')->get();

        return view('configuración.categoria.reporteCategoria', compact('categorias'));
    }

    public function estado(Request $request)
    {
        $categorias = \App\Models\CategoriaProducto::all();
        $estados = \App\Models\Estado::all();
        $categoriaSeleccionada = null;

        if ($request->filled('categoria_id')) {
            $categoriaSeleccionada = \App\Models\CategoriaProducto::find($request->categoria_id);
        }

        return view('configuración.categoria.estadoCategoria', compact('categorias', 'estados', 'categoriaSeleccionada'));
    }

    public function estadoUpdate(Request $request, $id)
    {
        $request->validate([
            'idEstado' => 'required|integer|exists:estado,idEstado',
        ]);

        $categoria = \App\Models\CategoriaProducto::findOrFail($id);
        $categoria->idEstado = $request->idEstado;
        $categoria->save();

        return redirect()->route('categoria.estado', ['categoria_id' => $id])->with('success', '¡El estado de la categoría fue actualizado exitosamente!');
    }

}
