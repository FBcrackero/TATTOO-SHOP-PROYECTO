<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Estado;

class CargoController extends Controller
{

    /**
     * Muestra el formulario para crear un nuevo cargo.
     *
     * @return \Illuminate\View\View
     */

    /**
     * Almacena un nuevo cargo en la base de datos.
     *
     * Valida los datos recibidos del formulario y crea un nuevo registro de cargo.
     * Redirige de vuelta al formulario con un mensaje de éxito si la operación es exitosa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function index()
    {
        return view('configuración.cargo.cargo');
    }

    public function create()
    {
        return view('configuración.cargo.ingresarCargo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreCargo' => 'required|string|max:100|unique:cargo,nombreCargo',
            'descripcionCargo' => 'required|string|max:255',
            'nomenclaturaCargo' => 'required|string|max:100',
            'sueldo' => 'required|numeric|min:0',
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        Cargo::create([
            'nombreCargo' => $request->nombreCargo,
            'descripcionCargo' => $request->descripcionCargo,
            'nomenclaturaCargo' => $request->nomenclaturaCargo,
            'sueldo' => $request->sueldo,
            'idEstado' => $request->idEstado, // Siempre será 1 por el input hidden
        ]);

        return redirect()->route('cargo.ingresar')->with('success', 'Cargo ingresado correctamente.');
    }


    /**
     * Muestra la vista para modificar un cargo, obteniendo todos los cargos y estados disponibles.
     * Si se proporciona un 'cargo_id' en la solicitud, selecciona el cargo correspondiente para su edición.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP entrante.
     * @return \Illuminate\View\View  La vista de modificación de cargo con los datos necesarios.
     */

    /**
     * Actualiza la información de un cargo específico en la base de datos.
     * Valida los datos recibidos y actualiza el registro correspondiente.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP con los datos del formulario.
     * @param  int  $id  El identificador del cargo a actualizar.
     * @return \Illuminate\Http\RedirectResponse  Redirige a la vista de modificación con un mensaje de éxito.
     */

    public function modificar(Request $request)
    {
        $cargos = Cargo::all();
        $estados = Estado::all();
        $cargoSeleccionado = null;

        if ($request->filled('cargo_id')) {
            $cargoSeleccionado = Cargo::find($request->cargo_id);
        }

        return view('configuración.cargo.modificarCargo', compact('cargos', 'estados', 'cargoSeleccionado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreCargo' => 'required|string|max:100|unique:cargo,nombreCargo,' . $id . ',idCargo',
            'descripcionCargo' => 'required|string|max:255',
            'nomenclaturaCargo' => 'required|string|max:100',
            'sueldo' => 'required|numeric|min:0',

        ]);

        $cargo = Cargo::findOrFail($id);
        $cargo->update([
            'nombreCargo' => $request->nombreCargo,
            'descripcionCargo' => $request->descripcionCargo,
            'nomenclaturaCargo' => $request->nomenclaturaCargo,
            'sueldo' => $request->sueldo,

        ]);

        return redirect()->route('cargo.modificar', ['cargo_id' => $id])->with('success', 'Cargo modificado correctamente.');
    }

    /**
     * Muestra la vista para eliminar cargos y selecciona un cargo si se proporciona un ID.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP entrante.
     * @return \Illuminate\View\View  La vista de eliminación de cargos con los datos necesarios.
     */

    /**
     * Elimina un cargo específico por su ID.
     *
     * @param  int  $id  El ID del cargo a eliminar.
     * @return \Illuminate\Http\RedirectResponse  Redirección a la vista de eliminación con un mensaje de éxito.
     */

    public function eliminar(Request $request)
    {
        $cargos = Cargo::all();
        $cargoSeleccionado = null;

        if ($request->filled('cargo_id')) {
            $cargoSeleccionado = Cargo::find($request->cargo_id);
        }

        return view('configuración.cargo.eliminarCargo', compact('cargos', 'cargoSeleccionado'));
    }

    public function destroy($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->delete();

        return redirect()->route('cargo.eliminar')->with('success', 'Cargo eliminado correctamente.');
    }


    /**
     * Muestra una lista de cargos según el criterio de búsqueda proporcionado.
     *
     * Si se proporciona un parámetro 'busqueda' en la solicitud, filtra los cargos
     * por coincidencias en los campos 'nombreCargo', 'descripcionCargo' o 'nomenclaturaCargo'.
     * Devuelve la vista 'configuración.cargo.consultarCargo' con los resultados encontrados.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP entrante.
     * @return \Illuminate\View\View  La vista con la lista de cargos.
     */

    /**
     * Genera un reporte de cargos según el criterio de búsqueda proporcionado.
     *
     * Si se proporciona un parámetro 'busqueda' en la solicitud, filtra los cargos
     * por coincidencias en los campos 'nombreCargo', 'descripcionCargo' o 'nomenclaturaCargo'.
     * Devuelve la vista 'configuración.cargo.reporteCargo' con los resultados encontrados.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP entrante.
     * @return \Illuminate\View\View  La vista con el reporte de cargos.
     */

    public function consultar(Request $request)
    {
        $query = Cargo::query();

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where('nombreCargo', 'like', "%$busqueda%")
                  ->orWhere('descripcionCargo', 'like', "%$busqueda%")
                  ->orWhere('nomenclaturaCargo', 'like', "%$busqueda%");
        }

        $cargos = $query->get();

        return view('configuración.cargo.consultarCargo', compact('cargos'));
    }

    public function reporte(Request $request)
    {
        $query = Cargo::query();

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where('nombreCargo', 'like', "%$busqueda%")
                  ->orWhere('descripcionCargo', 'like', "%$busqueda%")
                  ->orWhere('nomenclaturaCargo', 'like', "%$busqueda%");
        }

        $cargos = $query->get();

        return view('configuración.cargo.reporteCargo', compact('cargos'));
    }


    /**
     * Muestra la vista para gestionar el estado de los cargos.
     *
     * Obtiene todos los cargos y estados disponibles. Si se proporciona un 'cargo_id' en la solicitud,
     * busca el cargo seleccionado para mostrarlo en la vista.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP entrante.
     * @return \Illuminate\View\View  La vista de configuración de estado de cargo.
     */

    /**
     * Actualiza el estado de un cargo específico.
     *
     * Valida que el estado proporcionado exista, actualiza el estado del cargo identificado por $id,
     * y redirige de vuelta a la vista de estado del cargo con un mensaje de éxito.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP entrante.
     * @param  int  $id  El identificador del cargo a actualizar.
     * @return \Illuminate\Http\RedirectResponse  Redirección a la vista de estado del cargo.
     */

    public function estado(Request $request)
    {
        $cargos = Cargo::all();
        $estados = Estado::all();
        $cargoSeleccionado = null;

        if ($request->filled('cargo_id')) {
            $cargoSeleccionado = Cargo::find($request->cargo_id);
        }

        return view('configuración.cargo.estadoCargo', compact('cargos', 'estados', 'cargoSeleccionado'));
    }

    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        $cargo = Cargo::findOrFail($id);
        $cargo->idEstado = $request->idEstado;
        $cargo->save();

        return redirect()->route('cargo.estado', ['cargo_id' => $id])->with('success', 'Estado actualizado correctamente.');
    }
}