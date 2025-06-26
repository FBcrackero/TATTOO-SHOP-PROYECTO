<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\Estado;
use App\Models\Usuario;

/**
 * Class EmpleadoController
 *
 * Controlador para la gestión de empleados en la aplicación.
 * Proporciona funcionalidades para listar, crear, modificar, eliminar, consultar,
 * generar reportes y actualizar el estado de los empleados.
 *
 * Métodos:
 * - index(): Muestra la vista principal de empleados.
 * - create(Request $request): Muestra el formulario para ingresar un nuevo empleado, con filtros de búsqueda de usuario.
 * - store(Request $request): Valida y almacena un nuevo empleado en la base de datos.
 * - modificar(Request $request): Muestra la vista para modificar empleados, permitiendo seleccionar uno para editar.
 * - update(Request $request, $id): Actualiza los datos de un empleado existente.
 * - eliminar(Request $request): Muestra la vista para eliminar empleados, permitiendo seleccionar uno para eliminar.
 * - destroy($id): Elimina un empleado de la base de datos.
 * - consultar(Request $request): Permite consultar empleados aplicando diferentes filtros de búsqueda.
 * - reporte(Request $request): Genera un reporte de empleados aplicando filtros de búsqueda.
 * - estado(Request $request): Muestra la vista para actualizar el estado de un empleado.
 * - actualizarEstado(Request $request, $id): Actualiza el estado de un empleado específico.
 *
 */

class EmpleadoController extends Controller
{
    public function index()
    {
        return view('configuración.empleado.empleado');
    }

    public function create(Request $request)
    {
        $cargos = Cargo::all();
        $estados = Estado::all();

        $usuarios = Usuario::query();

        if ($request->filled('busquedaUsuario')) {
            $busqueda = $request->busquedaUsuario;
            $usuarios->where(function($q) use ($busqueda) {
                $q->where('idUsuario', $busqueda)
                  ->orWhere('NidentificacionUsu', 'like', "%$busqueda%")
                  ->orWhere('nombresUsu', 'like', "%$busqueda%")
                  ->orWhere('apellidosUsu', 'like', "%$busqueda%");
            });
        }

        $usuarios = $usuarios->get();

        return view('configuración.empleado.ingresarEmpleado', compact('cargos', 'estados', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fechaVinculacionEmpleado' => 'required|date',
            'numeroContrato' => 'required|numeric',
            'idCargo' => 'required|exists:cargo,idCargo',
            'idUsuario' => 'required|exists:usuario,idUsuario',
            // 'idEstado' => 'required|exists:estado,idEstado', // Quita la validación si no lo envías desde el form
        ]);

        $idEstado = $request->idEstado ?? 1; 

        Empleado::create([
            'fechaVinculacionEmpleado' => $request->fechaVinculacionEmpleado,
            'numeroContrato' => $request->numeroContrato,
            'idCargo' => $request->idCargo,
            'idUsuario' => $request->idUsuario,
            'idEstado' => $idEstado,
        ]);

        return redirect()->route('empleado.ingresar')->with('success', 'Empleado ingresado correctamente.');
    }

    public function modificar(Request $request)
    {
        $empleados = \App\Models\Empleado::with('usuario')->get();
        $cargos = \App\Models\Cargo::all();
        $usuarios = \App\Models\Usuario::all();
        $estados = \App\Models\Estado::all();
        $empleadoSeleccionado = null;

        if ($request->filled('empleado_id')) {
            $empleadoSeleccionado = \App\Models\Empleado::find($request->empleado_id);
        }

        return view('configuración.empleado.modificarEmpleado', compact('empleados', 'cargos', 'usuarios', 'estados', 'empleadoSeleccionado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fechaVinculacionEmpleado' => 'required|date',
            'numeroContrato' => 'required|numeric',
            'idCargo' => 'required|exists:cargo,idCargo',
        ]);

        $empleado = \App\Models\Empleado::findOrFail($id);
        $empleado->update([
            'fechaVinculacionEmpleado' => $request->fechaVinculacionEmpleado,
            'numeroContrato' => $request->numeroContrato,
            'idCargo' => $request->idCargo,
        ]);

        return redirect()->route('empleado.modificar', ['empleado_id' => $id])->with('success', 'Empleado modificado correctamente.');
    }

public function eliminar(Request $request)
{
    $empleados = \App\Models\Empleado::with(['usuario', 'cargo', 'estado'])->get();
    $empleadoSeleccionado = null;

    if ($request->filled('empleado_id')) {
        $empleadoSeleccionado = \App\Models\Empleado::with(['usuario', 'cargo', 'estado'])->find($request->empleado_id);
    }

    return view('configuración.empleado.eliminarEmpleado', compact('empleados', 'empleadoSeleccionado'));
}

public function destroy($id)
{
    $empleado = \App\Models\Empleado::findOrFail($id);
    $empleado->delete();

    return redirect()->route('empleado.eliminar')->with('success', 'Empleado eliminado correctamente.');
}

    public function consultar(Request $request)
    {
        $query = \App\Models\Empleado::with(['usuario', 'cargo', 'estado']);

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            switch ($request->filtro) {
                case 'nombre':
                    $query->whereHas('usuario', function($q) use ($busqueda) {
                        $q->where('nombresUsu', 'like', "%$busqueda%")
                        ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                    });
                    break;
                case 'identificacion':
                    $query->whereHas('usuario', function($q) use ($busqueda) {
                        $q->where('NidentificacionUsu', 'like', "%$busqueda%");
                    });
                    break;
                case 'cargo':
                    $query->whereHas('cargo', function($q) use ($busqueda) {
                        $q->where('nombreCargo', 'like', "%$busqueda%");
                    });
                    break;
                case 'general':
                    $query->where(function($q) use ($busqueda) {
                        $q->whereHas('usuario', function($qu) use ($busqueda) {
                            $qu->where('nombresUsu', 'like', "%$busqueda%")
                            ->orWhere('apellidosUsu', 'like', "%$busqueda%")
                            ->orWhere('NidentificacionUsu', 'like', "%$busqueda%");
                        })
                        ->orWhereHas('cargo', function($qc) use ($busqueda) {
                            $qc->where('nombreCargo', 'like', "%$busqueda%");
                        });
                    });
                    break;
            }
        }

        if ($request->filled('limpiar')) {
            $empleados = $query->get();
        } else {
            $empleados = $query->get();
        }

        return view('configuración.empleado.consultarEmpleado', compact('empleados'));
    }

    public function reporte(Request $request)
    {
        $query = \App\Models\Empleado::with(['usuario', 'cargo', 'estado']);

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            switch ($request->filtro) {
                case 'nombre':
                    $query->whereHas('usuario', function($q) use ($busqueda) {
                        $q->where('nombresUsu', 'like', "%$busqueda%")
                        ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                    });
                    break;
                case 'identificacion':
                    $query->whereHas('usuario', function($q) use ($busqueda) {
                        $q->where('NidentificacionUsu', 'like', "%$busqueda%");
                    });
                    break;
                case 'cargo':
                    $query->whereHas('cargo', function($q) use ($busqueda) {
                        $q->where('nombreCargo', 'like', "%$busqueda%");
                    });
                    break;
                case 'general':
                    $query->where(function($q) use ($busqueda) {
                        $q->whereHas('usuario', function($qu) use ($busqueda) {
                            $qu->where('nombresUsu', 'like', "%$busqueda%")
                            ->orWhere('apellidosUsu', 'like', "%$busqueda%")
                            ->orWhere('NidentificacionUsu', 'like', "%$busqueda%");
                        })
                        ->orWhereHas('cargo', function($qc) use ($busqueda) {
                            $qc->where('nombreCargo', 'like', "%$busqueda%");
                        });
                    });
                    break;
            }
        }

        $empleados = $query->get();

        return view('configuración.empleado.reporteEmpleado', compact('empleados'));
    }
        
    public function estado(Request $request)
    {
        $empleados = \App\Models\Empleado::with('usuario')->get();
        $estados = \App\Models\Estado::all();
        $empleadoSeleccionado = null;

        if ($request->filled('empleado_id')) {
            $empleadoSeleccionado = \App\Models\Empleado::with('usuario')->find($request->empleado_id);
        }

        return view('configuración.empleado.estadoEmpleado', compact('empleados', 'estados', 'empleadoSeleccionado'));
    }

    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        $empleado = \App\Models\Empleado::findOrFail($id);
        $empleado->idEstado = $request->idEstado;
        $empleado->save();

        return redirect()->route('empleado.estado', ['empleado_id' => $id])->with('success', 'Estado actualizado correctamente.');
    }

}