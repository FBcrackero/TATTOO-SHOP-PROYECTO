<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;

/**
 * Controlador para la gestión de Estados en la aplicación.
 *
 * Métodos:
 * - index(): Muestra la vista principal de estados.
 * - create(): Muestra el formulario para ingresar un nuevo estado.
 * - store(Request $request): Valida y almacena un nuevo estado en la base de datos.
 * - modificar(Request $request): Muestra la vista para modificar un estado existente, permitiendo seleccionar uno.
 * - update(Request $request, $id): Valida y actualiza un estado existente en la base de datos.
 * - eliminar(Request $request): Muestra la vista para eliminar un estado, permitiendo seleccionar uno.
 * - destroy($id): Elimina un estado de la base de datos.
 * - consultar(Request $request): Permite consultar y filtrar estados según diferentes criterios.
 * - reporte(Request $request): Genera un reporte de estados, permitiendo aplicar filtros de búsqueda.
 *
 * Validaciones:
 * - nombreEstado: requerido, cadena, máximo 40 caracteres, único.
 * - nomenclaturaEstado: requerido, cadena, máximo 10 caracteres, único.
 * - descripcionEstado: requerido, cadena, máximo 100 caracteres.
 *
 * Notas:
 * - Utiliza el modelo Estado para interactuar con la base de datos.
 * - Las vistas se encuentran en la carpeta configuración/estado.
 */

class EstadoController extends Controller
{
    public function index()
    {
        return view('configuración.estado.estado');
    }

    public function create()
    {
        return view('configuración.estado.ingresarEstado');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreEstado' => 'required|string|max:40|unique:estado,nombreEstado',
            'nomenclaturaEstado' => 'required|string|max:10|unique:estado,nomenclaturaEstado',
            'descripcionEstado' => 'required|string|max:100',
        ]);

        Estado::create([
            'nombreEstado' => $request->nombreEstado,
            'nomenclaturaEstado' => $request->nomenclaturaEstado,
            'descripcionEstado' => $request->descripcionEstado,
        ]);

        return redirect()->route('estado.ingresar')->with('success', 'Estado ingresado correctamente.');
    }

    public function modificar(Request $request)
    {
        $estados = \App\Models\Estado::all();
        $estadoSeleccionado = null;

        if ($request->filled('estado_id')) {
            $estadoSeleccionado = \App\Models\Estado::find($request->estado_id);
        }

        return view('configuración.estado.modificarEstado', compact('estados', 'estadoSeleccionado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreEstado' => 'required|string|max:40|unique:estado,nombreEstado,' . $id . ',idEstado',
            'nomenclaturaEstado' => 'required|string|max:10|unique:estado,nomenclaturaEstado,' . $id . ',idEstado',
            'descripcionEstado' => 'required|string|max:100',
        ]);

        $estado = \App\Models\Estado::findOrFail($id);
        $estado->update([
            'nombreEstado' => $request->nombreEstado,
            'nomenclaturaEstado' => $request->nomenclaturaEstado,
            'descripcionEstado' => $request->descripcionEstado,
        ]);

        return redirect()->route('estado.modificar', ['estado_id' => $id])->with('success', 'Estado modificado correctamente.');
    }

    public function eliminar(Request $request)
    {
        $estados = \App\Models\Estado::all();
        $estadoSeleccionado = null;

        if ($request->filled('estado_id')) {
            $estadoSeleccionado = \App\Models\Estado::find($request->estado_id);
        }

        return view('configuración.estado.eliminarEstado', compact('estados', 'estadoSeleccionado'));
    }

    public function destroy($id)
    {
        $estado = \App\Models\Estado::findOrFail($id);
        $estado->delete();

        return redirect()->route('estado.eliminar')->with('success', 'Estado eliminado correctamente.');
    }

    public function consultar(Request $request)
    {
        $query = \App\Models\Estado::query();

        if ($request->filled('limpiar')) {
            return redirect()->route('estado.consultar');
        }

        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $filtro = $request->input('filtro', 'nombre');

            if ($filtro === 'nombre') {
                $query->where('nombreEstado', 'like', "%$busqueda%");
            } elseif ($filtro === 'nomenclatura') {
                $query->where('nomenclaturaEstado', 'like', "%$busqueda%");
            } elseif ($filtro === 'general') {
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombreEstado', 'like', "%$busqueda%")
                    ->orWhere('nomenclaturaEstado', 'like', "%$busqueda%")
                    ->orWhere('descripcionEstado', 'like', "%$busqueda%")
                    ->orWhere('idEstado', $busqueda);
                });
            }
        }

        $estados = $query->orderBy('idEstado')->get();

        return view('configuración.estado.consultarEstado', compact('estados'));
    }


    public function reporte(Request $request)
    {
        $query = \App\Models\Estado::query();

        $filtro = $request->input('filtro', 'nombre');
        $busqueda = $request->input('busqueda');

        if ($busqueda) {
            if ($filtro === 'nombre') {
                $query->where('nombreEstado', 'like', "%$busqueda%");
            } elseif ($filtro === 'nomenclatura') {
                $query->where('nomenclaturaEstado', 'like', "%$busqueda%");
            } elseif ($filtro === 'general') {
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombreEstado', 'like', "%$busqueda%")
                    ->orWhere('nomenclaturaEstado', 'like', "%$busqueda%")
                    ->orWhere('descripcionEstado', 'like', "%$busqueda%")
                    ->orWhere('idEstado', $busqueda);
                });
            }
        }

        $estados = $query->orderBy('idEstado')->get();

        return view('configuración.estado.reporteEstado', compact('estados'));
    }
}