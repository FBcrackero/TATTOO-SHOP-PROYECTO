<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

/**
 * Class ReservaController
 *
 * Controlador para la gestión de reservas en el sistema de la tienda de tatuajes.
 * Permite a los usuarios, artistas y administradores realizar operaciones CRUD sobre reservas,
 * así como gestionar estados y reportes de las mismas.
 *
 * Métodos:
 * - index(): Muestra la lista de reservas según el perfil del usuario autenticado.
 * - store(Request $request): Permite a un usuario crear una nueva reserva.
 * - cancelar($id): Permite a un usuario cancelar su propia reserva si está pendiente.
 * - aceptar($id): Permite a un artista aceptar una reserva pendiente asignada a él.
 * - rechazar($id): Permite a un artista rechazar una reserva pendiente asignada a él.
 * - create(): Muestra el formulario para crear una reserva (solo para administradores).
 * - storeAdmin(Request $request): Permite al administrador crear una reserva para cualquier usuario.
 * - modificar(Request $request): Muestra y permite buscar/modificar reservas (solo para administradores).
 * - update(Request $request, $id): Actualiza los datos de una reserva (solo para administradores).
 * - eliminar(Request $request): Muestra y permite buscar/eliminar reservas (solo para administradores).
 * - destroy($id): Elimina una reserva específica (solo para administradores).
 * - consultar(Request $request): Permite consultar reservas con filtros avanzados (solo para administradores).
 * - reporte(Request $request): Genera un reporte de reservas con filtros avanzados.
 * - estado(Request $request): Muestra y permite buscar reservas para cambiar su estado (solo para administradores).
 * - actualizarEstado(Request $request, $id): Actualiza el estado de una reserva específica (solo para administradores).
 *
 * Requiere autenticación y verifica el perfil del usuario para autorizar ciertas acciones.
 *
 */


class ReservaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $servicios = Servicio::all();
        $artistas = Usuario::where('idPerfil', 3)->get();

        // Lógica de reservas según perfil
        if ($user->idPerfil == 1) { // Admin
            $reservas = Reserva::with(['servicio', 'artista', 'estado'])->get();
        } elseif ($user->idPerfil == 3) { // Artista
            $reservas = Reserva::with(['servicio', 'artista', 'estado'])
                ->where('idArtista', $user->idUsuario)
                ->get();
        } elseif ($user->idPerfil == 2) { // Usuario
            $reservas = Reserva::with(['servicio', 'artista', 'estado'])
                ->where('idUsuario', $user->idUsuario)
                ->get();
        } else {
            $reservas = collect();
        }

        return view('reservas.reservas', compact('reservas', 'servicios', 'artistas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fechaReserva' => 'required|date|after_or_equal:today',
            'horaReserva' => 'required',
            'idServicio' => 'required|exists:servicio,idServicio',
            'idArtista' => 'required|exists:usuario,idUsuario',
            'descripcionReserva' => 'nullable|string|max:255',
        ]);

        $reserva = new Reserva();
        $reserva->idUsuario = Auth::id();
        $reserva->idArtista = $request->idArtista;
        $reserva->idServicio = $request->idServicio;
        $reserva->fechaReserva = $request->fechaReserva;
        $reserva->horaReserva = $request->horaReserva;
        $reserva->descripcionReserva = $request->descripcionReserva;
        $reserva->idEstado = 3; // 1 = Pendiente (ajusta según tu tabla estado)
        $reserva->save();

        return redirect()->route('reservas')->with('success', '¡Reserva creada exitosamente!');
    }

    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);
        if (Auth::user()->idPerfil == 2 && Auth::id() == $reserva->idUsuario && $reserva->idEstado == 3) {
            $reserva->idEstado = 5; // Cancelada
            $reserva->save();
            return back()->with('success', '¡Reserva cancelada!');
        }
        return back()->with('error', 'No autorizado.');
    }

    public function aceptar($id)
    {
        $reserva = Reserva::findOrFail($id);
        if (Auth::user()->idPerfil == 3 && Auth::id() == $reserva->idArtista && $reserva->idEstado == 3) {
            $reserva->idEstado = 4; // Aceptada
            $reserva->save();
            return back()->with('success', '¡Reserva aceptada!');
        }
        return back()->with('error', 'No autorizado.');
    }

    public function rechazar($id)
    {
        $reserva = Reserva::findOrFail($id);
        if (Auth::user()->idPerfil == 3 && Auth::id() == $reserva->idArtista && $reserva->idEstado == 3) {
            $reserva->idEstado = 6; // Rechazada
            $reserva->save();
            return back()->with('success', '¡Reserva rechazada!');
        }
        return back()->with('error', 'No autorizado.');
    }

    public function create()
    {
        // Solo admin
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }
        $usuarios = \App\Models\Usuario::where('idPerfil', 2)->get();
        $artistas = \App\Models\Usuario::where('idPerfil', 3)->get();
        $servicios = \App\Models\Servicio::all();
        return view('reservas.ingresarReserva', compact('usuarios', 'artistas', 'servicios'));
    }

    public function storeAdmin(Request $request)
    {
        // Solo admin
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $request->validate([
            'idUsuario' => 'required|exists:usuario,idUsuario',
            'idArtista' => 'required|exists:usuario,idUsuario',
            'idServicio' => 'required|exists:servicio,idServicio',
            'fechaReserva' => 'required|date|after_or_equal:today',
            'horaReserva' => 'required',
            'descripcionReserva' => 'nullable|string|max:255',
        ]);

        $reserva = new \App\Models\Reserva();
        $reserva->idUsuario = $request->idUsuario;
        $reserva->idArtista = $request->idArtista;
        $reserva->idServicio = $request->idServicio;
        $reserva->fechaReserva = $request->fechaReserva;
        $reserva->horaReserva = $request->horaReserva;
        $reserva->descripcionReserva = $request->descripcionReserva;
        $reserva->idEstado = 3; // Ajusta según tu lógica de estados
        $reserva->save();

        return redirect()->route('reservas')->with('success', '¡Reserva creada exitosamente!');
    }

    public function modificar(Request $request)
    {
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $reservas = \App\Models\Reserva::with(['usuario', 'artista', 'servicio', 'estado'])
            ->when($request->busqueda, function ($query) use ($request) {
                $q = $request->busqueda;
                $query->whereHas('usuario', function($sub) use ($q) {
                    $sub->where('nombresUsu', 'like', "%$q%");
                })
                ->orWhereHas('artista', function($sub) use ($q) {
                    $sub->where('nombresUsu', 'like', "%$q%");
                })
                ->orWhere('fechaReserva', 'like', "%$q%");
            })
            ->get();

        $usuarios = \App\Models\Usuario::where('idPerfil', 2)->get();
        $artistas = \App\Models\Usuario::where('idPerfil', 3)->get();
        $servicios = \App\Models\Servicio::all();
        $estados = \App\Models\Estado::all();

        $reservaSeleccionada = null;
        if ($request->reserva_id) {
            $reservaSeleccionada = \App\Models\Reserva::find($request->reserva_id);
        }

        return view('reservas.modifcarReserva', compact('reservas', 'usuarios', 'artistas', 'servicios', 'estados', 'reservaSeleccionada'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $request->validate([
            'idUsuario' => 'required|exists:usuario,idUsuario',
            'idArtista' => 'required|exists:usuario,idUsuario',
            'idServicio' => 'required|exists:servicio,idServicio',
            'fechaReserva' => 'required|date|after_or_equal:today',
            'horaReserva' => 'required',
            'descripcionReserva' => 'nullable|string|max:255',
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        $reserva = \App\Models\Reserva::findOrFail($id);
        $reserva->idUsuario = $request->idUsuario;
        $reserva->idArtista = $request->idArtista;
        $reserva->idServicio = $request->idServicio;
        $reserva->fechaReserva = $request->fechaReserva;
        $reserva->horaReserva = $request->horaReserva;
        $reserva->descripcionReserva = $request->descripcionReserva;
        $reserva->idEstado = $request->idEstado;
        $reserva->save();

        return redirect()->route('reservas.modificar', ['reserva_id' => $reserva->idReserva])
            ->with('success', '¡Reserva modificada exitosamente!');
    }

    public function eliminar(Request $request)
    {
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $reservas = \App\Models\Reserva::with(['usuario', 'artista', 'servicio', 'estado'])
            ->when($request->busqueda, function ($query) use ($request) {
                $q = $request->busqueda;
                $query->whereHas('usuario', function($sub) use ($q) {
                    $sub->where('nombresUsu', 'like', "%$q%");
                })
                ->orWhereHas('artista', function($sub) use ($q) {
                    $sub->where('nombresUsu', 'like', "%$q%");
                })
                ->orWhere('fechaReserva', 'like', "%$q%");
            })
            ->get();

        $reservaSeleccionada = null;
        if ($request->reserva_id) {
            $reservaSeleccionada = \App\Models\Reserva::find($request->reserva_id);
        }

        return view('reservas.eliminarReserva', compact('reservas', 'reservaSeleccionada'));
    }

    public function destroy($id)
    {
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $reserva = \App\Models\Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('reservas.eliminar')->with('success', '¡Reserva eliminada exitosamente!');
    }


    public function consultar(Request $request)
    {
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $reservas = Reserva::with(['usuario', 'artista', 'servicio', 'estado'])
            ->when($request->busqueda, function ($query) use ($request) {
                $q = $request->busqueda;
                switch ($request->filtro) {
                    case 'usuario':
                        $query->whereHas('usuario', function($sub) use ($q) {
                            $sub->where('nombresUsu', 'like', "%$q%");
                        });
                        break;
                    case 'artista':
                        $query->whereHas('artista', function($sub) use ($q) {
                            $sub->where('nombresUsu', 'like', "%$q%");
                        });
                        break;
                    case 'servicio':
                        $query->whereHas('servicio', function($sub) use ($q) {
                            $sub->where('nombreServicio', 'like', "%$q%");
                        });
                        break;
                    case 'fecha':
                        $query->where('fechaReserva', 'like', "%$q%");
                        break;
                    case 'general':
                    default:
                        $query->whereHas('usuario', function($sub) use ($q) {
                            $sub->where('nombresUsu', 'like', "%$q%");
                        })
                        ->orWhereHas('artista', function($sub) use ($q) {
                            $sub->where('nombresUsu', 'like', "%$q%");
                        })
                        ->orWhereHas('servicio', function($sub) use ($q) {
                            $sub->where('nombreServicio', 'like', "%$q%");
                        })
                        ->orWhere('fechaReserva', 'like', "%$q%");
                        break;
                }
            })
            ->orderBy('fechaReserva', 'desc')
            ->get();

        return view('reservas.consultarReserva', compact('reservas'));
    }

    public function reporte(Request $request)
    {
        $query = \App\Models\Reserva::with(['usuario', 'artista', 'servicio', 'estado']);

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            switch ($request->filtro) {
                case 'usuario':
                    $query->whereHas('usuario', function($q) use ($busqueda) {
                        $q->where('nombresUsu', 'like', "%$busqueda%");
                    });
                    break;
                case 'artista':
                    $query->whereHas('artista', function($q) use ($busqueda) {
                        $q->where('nombresUsu', 'like', "%$busqueda%");
                    });
                    break;
                case 'servicio':
                    $query->whereHas('servicio', function($q) use ($busqueda) {
                        $q->where('nombreServicio', 'like', "%$busqueda%");
                    });
                    break;
                case 'fecha':
                    $query->where('fechaReserva', 'like', "%$busqueda%");
                    break;
                case 'general':
                    $query->where(function($q) use ($busqueda) {
                        $q->where('descripcionReserva', 'like', "%$busqueda%")
                        ->orWhereHas('usuario', function($q2) use ($busqueda) {
                            $q2->where('nombresUsu', 'like', "%$busqueda%");
                        })
                        ->orWhereHas('artista', function($q2) use ($busqueda) {
                            $q2->where('nombresUsu', 'like', "%$busqueda%");
                        })
                        ->orWhereHas('servicio', function($q2) use ($busqueda) {
                            $q2->where('nombreServicio', 'like', "%$busqueda%");
                        });
                    });
                    break;
            }
        }

        $reservas = $query->orderBy('fechaReserva', 'desc')->get();

        return view('reservas.reporteReserva', compact('reservas'));
    }

    // Mostrar y buscar reservas para cambiar estado
    public function estado(Request $request)
    {
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $busqueda = $request->input('busqueda');
        $reserva_id = $request->input('reserva_id');

        $reservas = Reserva::with(['usuario', 'servicio'])
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('idReserva', $busqueda)
                    ->orWhereHas('usuario', function ($q) use ($busqueda) {
                        $q->where('nombresUsu', 'like', "%$busqueda%");
                    })
                    ->orWhereHas('servicio', function ($q) use ($busqueda) {
                        $q->where('nombreServicio', 'like', "%$busqueda%");
                    });
            })
            ->orderBy('idReserva', 'desc')
            ->get();

        $estados = \App\Models\Estado::all();

        $reservaSeleccionada = null;
        if ($reserva_id) {
            $reservaSeleccionada = Reserva::with(['usuario', 'servicio', 'estado'])->find($reserva_id);
        }

        return view('reservas.estadoReservas', compact('reservas', 'estados', 'reservaSeleccionada'));
    }

    // Actualizar el estado de la reserva
    public function actualizarEstado(Request $request, $id)
    {
        if (auth()->user()->idPerfil != 1) {
            return redirect()->route('reservas');
        }

        $request->validate([
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        $reserva = Reserva::findOrFail($id);
        $reserva->idEstado = $request->input('idEstado');
        $reserva->save();

        return redirect()->route('reservas.estado', ['reserva_id' => $reserva->idReserva])
            ->with('success', 'El estado de la reserva se actualizó correctamente.');
    }
}