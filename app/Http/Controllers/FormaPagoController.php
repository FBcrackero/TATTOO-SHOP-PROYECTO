<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormaPago;
use App\Models\Estado;

/**
 * Controlador para la gestión de Formas de Pago.
 *
 * Este controlador maneja las operaciones CRUD y otras funcionalidades relacionadas
 * con las formas de pago, incluyendo creación, modificación, eliminación, consulta,
 * generación de reportes y actualización de estado.
 *
 * Métodos:
 * - index(): Muestra la vista principal de formas de pago.
 * - create(): Muestra el formulario para ingresar una nueva forma de pago.
 * - store(Request $request): Valida y almacena una nueva forma de pago en la base de datos.
 * - modificar(Request $request): Muestra la vista para modificar una forma de pago existente.
 * - update(Request $request, $id): Valida y actualiza una forma de pago existente.
 * - eliminar(Request $request): Muestra la vista para eliminar una forma de pago.
 * - destroy($id): Elimina una forma de pago de la base de datos.
 * - consultar(Request $request): Permite consultar formas de pago según filtros y criterios de búsqueda.
 * - reporte(Request $request): Genera un reporte de formas de pago según filtros de búsqueda.
 * - estado(Request $request): Muestra la vista para actualizar el estado de una forma de pago.
 * - actualizarEstado(Request $request, $id): Actualiza el estado de una forma de pago específica.
 *
 */

class FormaPagoController extends Controller
{
    public function index()
    {
        return view('configuración.formaPago.formaPago');
    }

    public function create()
    {
        return view('configuración.formaPago.ingresarFormaPago');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreFormaPago' => 'required|string|max:40|unique:formapago,nombreFormaPago',
            'descripcionFormaPago' => 'required|string|max:60',
            'nomenclaturaFormaPago' => 'required|string|max:4',
        ]);

        \App\Models\FormaPago::create([
            'nombreFormaPago' => $request->nombreFormaPago,
            'descripcionFormaPago' => $request->descripcionFormaPago,
            'nomenclaturaFormaPago' => $request->nomenclaturaFormaPago,
        ]);

        return redirect()->route('formaPago.ingresar')->with('success', 'Forma de pago ingresada correctamente.');
    }


    public function modificar(Request $request)
    {
        $formasPago = \App\Models\FormaPago::all();
        $formaPagoSeleccionada = null;

        if ($request->filled('forma_pago_id')) {
            $formaPagoSeleccionada = \App\Models\FormaPago::find($request->forma_pago_id);
        }

        return view('configuración.formaPago.modificarFormaPago', compact('formasPago', 'formaPagoSeleccionada'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreFormaPago' => 'required|string|max:40|unique:formapago,nombreFormaPago,' . $id . ',idFormaPago',
            'descripcionFormaPago' => 'required|string|max:60',
            'nomenclaturaFormaPago' => 'required|string|max:4',
        ]);

        $formaPago = \App\Models\FormaPago::findOrFail($id);
        $formaPago->update([
            'nombreFormaPago' => $request->nombreFormaPago,
            'descripcionFormaPago' => $request->descripcionFormaPago,
            'nomenclaturaFormaPago' => $request->nomenclaturaFormaPago,
        ]);

        return redirect()->route('formaPago.modificar', ['forma_pago_id' => $id])
            ->with('success', 'Forma de pago modificada correctamente.');
    }

    public function eliminar(Request $request)
    {
        $formasPago = \App\Models\FormaPago::all();
        $formaPagoSeleccionada = null;

        if ($request->filled('forma_pago_id')) {
            $formaPagoSeleccionada = \App\Models\FormaPago::find($request->forma_pago_id);
        }

        return view('configuración.formaPago.eliminarFormaPago', compact('formasPago', 'formaPagoSeleccionada'));
    }

    public function destroy($id)
    {
        $formaPago = \App\Models\FormaPago::findOrFail($id);
        $formaPago->delete();

        return redirect()->route('formaPago.eliminar')->with('success', 'Forma de pago eliminada correctamente.');
    }

 
    public function consultar(Request $request)
    {
        $query = \App\Models\FormaPago::query();

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            switch ($request->filtro) {
                case 'nombre':
                    $query->where('nombreFormaPago', 'like', "%$busqueda%");
                    break;
                case 'nomenclatura':
                    $query->where('nomenclaturaFormaPago', 'like', "%$busqueda%");
                    break;
                case 'general':
                    $query->where(function($q) use ($busqueda) {
                        $q->where('nombreFormaPago', 'like', "%$busqueda%")
                        ->orWhere('nomenclaturaFormaPago', 'like', "%$busqueda%")
                        ->orWhere('descripcionFormaPago', 'like', "%$busqueda%");
                    });
                    break;
            }
        }

        if ($request->filled('limpiar')) {
            $formasPago = \App\Models\FormaPago::all();
        } else {
            $formasPago = $query->get();
        }

        return view('configuración.formaPago.consultarFormaPago', compact('formasPago'));
    }

    public function reporte(Request $request)
    {
        $query = \App\Models\FormaPago::query();

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            switch ($request->filtro) {
                case 'nombre':
                    $query->where('nombreFormaPago', 'like', "%$busqueda%");
                    break;
                case 'nomenclatura':
                    $query->where('nomenclaturaFormaPago', 'like', "%$busqueda%");
                    break;
                case 'general':
                    $query->where(function($q) use ($busqueda) {
                        $q->where('nombreFormaPago', 'like', "%$busqueda%")
                        ->orWhere('nomenclaturaFormaPago', 'like', "%$busqueda%")
                        ->orWhere('descripcionFormaPago', 'like', "%$busqueda%");
                    });
                    break;
            }
        }

        $formasPago = $query->get();

        return view('configuración.formaPago.reporteFormaPago', compact('formasPago'));
    }

    public function estado(Request $request)
    {
        $formasPago = \App\Models\FormaPago::all();
        $estados = \App\Models\Estado::all();
        $formaPagoSeleccionada = null;

        if ($request->filled('forma_pago_id')) {
            $formaPagoSeleccionada = \App\Models\FormaPago::find($request->forma_pago_id);
        }

        return view('configuración.formaPago.estadoFormaPago', compact('formasPago', 'estados', 'formaPagoSeleccionada'));
    }

    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        $formaPago = \App\Models\FormaPago::findOrFail($id);
        $formaPago->idEstado = $request->idEstado;
        $formaPago->save();

        return redirect()->route('formaPago.estado', ['forma_pago_id' => $id])
            ->with('success', 'Estado actualizado correctamente.');
    }
}