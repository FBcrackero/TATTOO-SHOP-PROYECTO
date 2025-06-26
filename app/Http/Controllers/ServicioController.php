<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Estado;

/**
 * Controlador ServicioController
 * 
 * Gestiona las operaciones CRUD y consultas relacionadas con los servicios.
 * 
 * Métodos:
 * - index(): Muestra la lista de servicios disponibles (idEstado = 1).
 * - create(): Muestra el formulario para ingresar un nuevo servicio.
 * - modificar(Request $request): Permite buscar y seleccionar un servicio para modificarlo.
 * - update(Request $request, $id): Actualiza los datos de un servicio existente, incluyendo la imagen.
 * - eliminar(Request $request): Permite buscar y seleccionar un servicio para eliminarlo.
 * - consultar(Request $request): Consulta servicios según diferentes filtros y criterios de búsqueda.
 * - reporte(Request $request): Genera un reporte de servicios según filtros de búsqueda.
 * - estado(Request $request): Permite cambiar el estado de un servicio.
 * - estadoUpdate(Request $request, $id): Actualiza el estado de un servicio específico.
 * - destroy($id): Elimina un servicio de la base de datos.
 * - store(Request $request): Almacena un nuevo servicio en la base de datos, gestionando la carga de imagen.
 * 
 * Notas:
 * - Utiliza validaciones para los datos de entrada.
 * - Gestiona la carga y almacenamiento de imágenes asociadas a los servicios.
 * - Utiliza relaciones Eloquent para obtener información del estado del servicio.
 */

class ServicioController extends Controller
{

    public function index()
    {
        // Solo servicios con estado "Disponible" (por ejemplo, idEstado = 1)
        $servicios = Servicio::where('idEstado', 1)->get();
        return view('servicios.servicios', compact('servicios'));
    }
    public function create()
    {
        return view('servicios.ingresarServicios');
    }

    public function modificar(Request $request)
    {
        $servicios = Servicio::all();
        $servicioSeleccionado = null;

    
        if ($request->filled('servicio_id')) {
            $servicioSeleccionado = Servicio::find($request->servicio_id);
        } elseif ($request->filled('busqueda')) {
            $servicioSeleccionado = Servicio::where('nombreServicio', 'like', '%' . $request->busqueda . '%')
                ->orWhere('idServicio', $request->busqueda)
                ->orWhere('nomenclaturaServicio', 'like', '%' . $request->busqueda . '%')
                ->first();
                }

        return view('servicios.modificarServicios', compact('servicios', 'servicioSeleccionado'));
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $request->validate([
            'nombreServicio' => 'required|string|max:40',
            'descripcionServicio' => 'required|string|max:60',
            'nomenclaturaServicio' => 'required|string|max:4',
            'idEstado' => 'required|integer',
            'imagenServicio' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('imagenServicio');

        if ($request->hasFile('imagenServicio')) {
            $file = $request->file('imagenServicio');

            $nombreBase = Str::slug($request->nombreServicio);
            $extension = $file->getClientOriginalExtension();
            $filename = $nombreBase . '-' . time() . '.' . $extension;

            $file->move(public_path('imagenes/imgServicios'), $filename);
            $data['imagenServicio'] = $filename;
        } else {
            $data['imagenServicio'] = $servicio->imagenServicio; // Mantener la imagen actual si no se sube una nueva
        }

        $servicio->update($data);

        return redirect()->route('servicios')->with('success', '¡El servicio fue modificado exitosamente!');
    }

    public function eliminar(Request $request)
    {
        $servicios = Servicio::all();
        $servicioSeleccionado = null;

        if ($request->filled('servicio_id')) {
            $servicioSeleccionado = Servicio::find($request->servicio_id);
        } elseif ($request->filled('busqueda')) {
            $servicioSeleccionado = Servicio::where('nombreServicio', 'like', '%' . $request->busqueda . '%')
                ->orWhere('idServicio', $request->busqueda)
                ->orWhere('nomenclaturaServicio', 'like', '%' . $request->busqueda . '%')
                ->first();
        }

        return view('servicios.eliminarServicios', compact('servicios', 'servicioSeleccionado'));
    }

    public function consultar(Request $request)
    {
        $query = \App\Models\Servicio::with('estado'); // <-- Agrega esto

        if ($request->filled('busqueda')) {
            switch ($request->filtro) {
                case 'codigo':
                    $query->where('idServicio', $request->busqueda);
                    break;
                case 'nombre':
                    $query->where('nombreServicio', 'like', '%' . $request->busqueda . '%');
                    break;
                case 'general':
                    $query->where(function($q) use ($request) {
                        $q->where('nombreServicio', 'like', '%' . $request->busqueda . '%')
                        ->orWhere('idServicio', $request->busqueda)
                        ->orWhere('nomenclaturaServicio', 'like', '%' . $request->busqueda . '%');
                    });
                    break;
            }
        }

        if ($request->has('limpiar')) {
            return redirect()->route('servicios.consultar');
        }

        $servicios = $query->get();

        return view('servicios.consultarServicios', compact('servicios'));
    }

    public function reporte(Request $request)
    {
        $query = \App\Models\Servicio::with('estado');

        if ($request->filled('busqueda')) {
            switch ($request->filtro) {
                case 'codigo':
                    $query->where('idServicio', $request->busqueda);
                    break;
                case 'nombre':
                    $query->where('nombreServicio', 'like', '%' . $request->busqueda . '%');
                    break;
                case 'general':
                    $query->where(function($q) use ($request) {
                        $q->where('nombreServicio', 'like', '%' . $request->busqueda . '%')
                        ->orWhere('idServicio', $request->busqueda)
                        ->orWhere('nomenclaturaServicio', 'like', '%' . $request->busqueda . '%');
                    });
                    break;
            }
        }

        $servicios = $query->get();

        return view('servicios.reporteServicios', compact('servicios'));
    }

    public function estado(Request $request)
    {
        $servicios = Servicio::all();
        $estados = Estado::all();
        $servicioSeleccionado = null;

        if ($request->filled('servicio_id')) {
            $servicioSeleccionado = Servicio::find($request->servicio_id);
        } elseif ($request->filled('busqueda')) {
            $servicioSeleccionado = Servicio::where('nombreServicio', 'like', '%' . $request->busqueda . '%')
                ->orWhere('idServicio', $request->busqueda)
                ->orWhere('nomenclaturaServicio', 'like', '%' . $request->busqueda . '%')
                ->first();
        }

        return view('servicios.estadoServicios', compact('servicios', 'servicioSeleccionado', 'estados'));
    }

    public function estadoUpdate(Request $request, $id)
    {
        $request->validate([
            'idEstado' => 'required|integer|exists:estado,idEstado',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->idEstado = $request->idEstado;
        $servicio->save();

        return redirect()->route('servicios.estado')->with('success', '¡El estado del servicio fue actualizado exitosamente!');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect()->route('servicios')->with('success', '¡El servicio fue eliminado exitosamente!');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombreServicio' => 'required|string|max:40',
            'descripcionServicio' => 'required|string|max:60',
            'nomenclaturaServicio' => 'required|string|max:4',
            'idEstado' => 'required|integer',
            'imagenServicio' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('imagenServicio'); 

        if ($request->hasFile('imagenServicio')) {
            $file = $request->file('imagenServicio');

            $nombreBase = Str::slug($request->nombreServicio); 
            $extension = $file->getClientOriginalExtension();   
            $filename = $nombreBase . '-' . time() . '.' . $extension;

            $file->move(public_path('imagenes/imgServicios'), $filename);
            $data['imagenServicio'] = $filename;
        } else {
            $data['imagenServicio'] = null;
        }

        Servicio::create($data);

        return redirect()->route('servicios')->with('success', '¡El servicio fue creado exitosamente!');
    }
}