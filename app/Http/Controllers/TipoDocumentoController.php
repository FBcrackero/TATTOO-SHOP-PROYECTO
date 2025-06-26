<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDocumento; 

/**
 * Controlador para la gestión de Tipos de Documento.
 *
 * Métodos:
 * - index(): Muestra la lista de todos los tipos de documento.
 * - create(): Muestra el formulario para crear un nuevo tipo de documento.
 * - store(Request $request): Valida y almacena un nuevo tipo de documento en la base de datos.
 * - modificar(Request $request): Muestra la vista para modificar un tipo de documento, permitiendo búsqueda y selección.
 * - update(Request $request, $id): Valida y actualiza un tipo de documento existente.
 * - eliminar(Request $request): Muestra la vista para eliminar un tipo de documento, permitiendo búsqueda y selección.
 * - destroy($id): Elimina un tipo de documento de la base de datos.
 * - consultar(Request $request): Permite consultar tipos de documento con filtros y búsqueda avanzada.
 * - reporte(Request $request): Genera un reporte de tipos de documento con filtros y búsqueda.
 * - estado(Request $request): Muestra la vista para cambiar el estado de un tipo de documento.
 * - estadoUpdate(Request $request, $id): Actualiza el estado de un tipo de documento.
 *
 * Notas:
 * - Utiliza el modelo TipoDocumento y Estado.
 * - Incluye validaciones para los campos requeridos y unicidad.
 * - Las vistas están ubicadas en 'configuración.tipoDocumento'.
 */

class TipoDocumentoController extends Controller
{   public function index()
    {
        $tiposDocumento = TipoDocumento::all();
            return view('configuración.tipoDocumento.tipoDocumento', compact('tiposDocumento'));    }

    public function create()
    {
        return view('configuración.tipoDocumento.ingresarTipoDocumento');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombreTipoDoc' => 'required|string|max:40|unique:tipoDocumento,nombreTipoDoc',
            'descripcionTipoDoc' => 'required|string|max:100',
            'nomenclaturaTipoDoc' => 'required|string|max:5|unique:tipoDocumento,nomenclaturaTipoDoc',
            'idEstado' => 'required|integer',
        ]);

        $tipoDocumento = new \App\Models\TipoDocumento();
        $tipoDocumento->nombreTipoDoc = $request->nombreTipoDoc;
        $tipoDocumento->descripcionTipoDoc = $request->descripcionTipoDoc;
        $tipoDocumento->nomenclaturaTipoDoc = $request->nomenclaturaTipoDoc;
        $tipoDocumento->idEstado = $request->idEstado;
        $tipoDocumento->save();

        return redirect()->route('tipodocumento.ingresar')->with('success', 'Tipo de Documento ingresado correctamente.');
    }

    public function modificar(Request $request)
    {
        $tiposDocumento = \App\Models\TipoDocumento::all();
        $tipoSeleccionado = null;

        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $tipoSeleccionado = \App\Models\TipoDocumento::where('nombreTipoDoc', 'like', "%$busqueda%")
                ->orWhere('nomenclaturaTipoDoc', 'like', "%$busqueda%")
                ->orWhere('idTipoDocumento', $busqueda)
                ->first();
        } elseif ($request->filled('tipo_documento_id')) {
            $tipoSeleccionado = \App\Models\TipoDocumento::find($request->tipo_documento_id);
        }

        return view('configuración.tipoDocumento.modificarTIpoDocumento', compact('tiposDocumento', 'tipoSeleccionado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreTipoDoc' => 'required|string|max:40|unique:tipoDocumento,nombreTipoDoc,' . $id . ',idTipoDocumento',
            'descripcionTipoDoc' => 'required|string|max:100',
            'nomenclaturaTipoDoc' => 'required|string|max:5|unique:tipoDocumento,nomenclaturaTipoDoc,' . $id . ',idTipoDocumento',
        ]);

        $tipoDocumento = \App\Models\TipoDocumento::findOrFail($id);
        $tipoDocumento->nombreTipoDoc = $request->nombreTipoDoc;
        $tipoDocumento->descripcionTipoDoc = $request->descripcionTipoDoc;
        $tipoDocumento->nomenclaturaTipoDoc = $request->nomenclaturaTipoDoc;
        $tipoDocumento->idEstado = $request->idEstado;
        $tipoDocumento->save();

        return redirect()->route('tipodocumento.modificar', ['tipo_documento_id' => $id])
            ->with('success', 'Tipo de Documento modificado correctamente.');
    }

    public function eliminar(Request $request)
    {
        $tiposDocumento = \App\Models\TipoDocumento::all();
        $tipoSeleccionado = null;

        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $tipoSeleccionado = \App\Models\TipoDocumento::where('nombreTipoDoc', 'like', "%$busqueda%")
                ->orWhere('nomenclaturaTipoDoc', 'like', "%$busqueda%")
                ->orWhere('idTipoDocumento', $busqueda)
                ->first();
        } elseif ($request->filled('tipo_documento_id')) {
            $tipoSeleccionado = \App\Models\TipoDocumento::find($request->tipo_documento_id);
        }

        return view('configuración.tipoDocumento.eliminarTipoDocumento', compact('tiposDocumento', 'tipoSeleccionado'));
    }

    public function destroy($id)
    {
        $tipoDocumento = \App\Models\TipoDocumento::findOrFail($id);
        $tipoDocumento->delete();

        return redirect()->route('tipodocumento.eliminar')->with('success', 'Tipo de Documento eliminado correctamente.');
    }

        public function consultar(Request $request)
        {
            $query = \App\Models\TipoDocumento::query();

            if ($request->filled('limpiar')) {
                return redirect()->route('tipodocumento.consultar');
            }

            if ($request->filled('busqueda')) {
                $busqueda = $request->input('busqueda');
                $filtro = $request->input('filtro', 'nombre');

                if ($filtro === 'nombre') {
                    $query->where('nombreTipoDoc', 'like', "%$busqueda%");
                } elseif ($filtro === 'nomenclatura') {
                    $query->where('nomenclaturaTipoDoc', 'like', "%$busqueda%");
                } elseif ($filtro === 'general') {
                    $query->where(function($q) use ($busqueda) {
                        $q->where('nombreTipoDoc', 'like', "%$busqueda%")
                        ->orWhere('nomenclaturaTipoDoc', 'like', "%$busqueda%")
                        ->orWhere('descripcionTipoDoc', 'like', "%$busqueda%")
                        ->orWhere('idTipoDocumento', $busqueda);
                    });
                }
            }

            $tiposDocumento = $query->with('estado')->orderBy('idTipoDocumento')->get();
            return view('configuración.tipoDocumento.consultarTipoDocumento', compact('tiposDocumento'));
        }

    public function reporte(Request $request)
    {
        $query = \App\Models\TipoDocumento::query();

        $filtro = $request->input('filtro', 'nombre');
        $busqueda = $request->input('busqueda');

        if ($busqueda) {
            if ($filtro === 'nombre') {
                $query->where('nombreTipoDoc', 'like', "%$busqueda%");
            } elseif ($filtro === 'nomenclatura') {
                $query->where('nomenclaturaTipoDoc', 'like', "%$busqueda%");
            } elseif ($filtro === 'general') {
                $query->where(function($q) use ($busqueda) {
                    $q->where('nombreTipoDoc', 'like', "%$busqueda%")
                    ->orWhere('nomenclaturaTipoDoc', 'like', "%$busqueda%")
                    ->orWhere('descripcionTipoDoc', 'like', "%$busqueda%")
                    ->orWhere('idTipoDocumento', $busqueda);
                });
            }
        }

        $tiposDocumento = $query->with('estado')->orderBy('idTipoDocumento')->get();
        return view('configuración.tipoDocumento.reporteTipoDocumento', compact('tiposDocumento'));
    }


public function estado(Request $request)
{
    $tiposDocumento = \App\Models\TipoDocumento::all();
    $estados = \App\Models\Estado::all();
    $tipoSeleccionado = null;

    if ($request->filled('busqueda')) {
        $busqueda = $request->input('busqueda');
        $tipoSeleccionado = \App\Models\TipoDocumento::where('nombreTipoDoc', 'like', "%$busqueda%")
            ->orWhere('nomenclaturaTipoDoc', 'like', "%$busqueda%")
            ->orWhere('idTipoDocumento', $busqueda)
            ->first();
    } elseif ($request->filled('tipo_documento_id')) {
        $tipoSeleccionado = \App\Models\TipoDocumento::find($request->tipo_documento_id);
    }

    return view('configuración.tipoDocumento.estadoTipoDocumento', compact('tiposDocumento', 'estados', 'tipoSeleccionado'));
}

    public function estadoUpdate(Request $request, $id)
    {
        $request->validate([
            'idEstado' => 'required|integer|exists:estado,idEstado',
        ]);

        $tipoDocumento = \App\Models\TipoDocumento::findOrFail($id);
        $tipoDocumento->idEstado = $request->idEstado;
        $tipoDocumento->save();

        return redirect()->route('tipodocumento.estado')->with('success', '¡El estado del tipo de documento fue actualizado exitosamente!');
    }

}