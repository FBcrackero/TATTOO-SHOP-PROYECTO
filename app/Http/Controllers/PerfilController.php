<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use App\Models\Usuario;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Ciudad;
use App\Models\Estado;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador PerfilController
 *
 * Controla las operaciones relacionadas con el perfil del usuario autenticado,
 * incluyendo la visualización, actualización y eliminación de la cuenta.
 *
 * Métodos:
 * - ver(): Muestra la vista del perfil del usuario.
 * - actualizar(Request $request): Valida y actualiza los datos del perfil del usuario,
 *   incluyendo la verificación de la contraseña actual y la actualización opcional de la contraseña.
 * - destroy(Request $request): Elimina la cuenta del usuario autenticado tras validar la contraseña,
 *   cerrando la sesión y redirigiendo a la página principal.
 *
 * Validaciones:
 * - Se valida la contraseña actual antes de permitir la actualización o eliminación del perfil.
 * - Se validan los campos requeridos y sus formatos antes de actualizar los datos.
 *
 * Mensajes:
 * - Devuelve mensajes de éxito o error según corresponda en cada operación.
 */


class PerfilController extends Controller
{
    public function ver()
    {
        return view('perfil.perfil');
    }

    public function actualizar(Request $request)
    {
        $user = auth()->user();

        // Validar contraseña actual
        $request->validate([
            'nombresUsu' => 'required|max:40',
            'apellidosUsu' => 'required|max:40',
            'emailUsu' => 'required|email|max:60',
            'NidentificacionUsu' => 'required|max:20',
            'current_password' => 'required',
        ]);

        if (!Hash::check($request->current_password, $user->Contrasena)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->nombresUsu = $request->nombresUsu;
        $user->apellidosUsu = $request->apellidosUsu;
        $user->emailUsu = $request->emailUsu;
        $user->celularUsu = $request->celularUsu;
        $user->NidentificacionUsu = $request->NidentificacionUsu;

        if ($request->filled('Contrasena')) {
            $user->Contrasena = bcrypt($request->Contrasena);
        }
        $user->save();

        return redirect()->route('perfil.ver')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'delete_password' => 'required',
        ]);

        if (!Hash::check($request->delete_password, $user->Contrasena)) {
            return back()->withErrors(['delete_password' => 'La contraseña es incorrecta.']);
        }

        // Cierra sesión y elimina el usuario
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Cuenta eliminada correctamente.');
    }




    
    public function ingresarUsuario()
    {
        $perfiles = Perfil::all();
        $tiposDocumento = TipoDocumento::all();
        $generos = Genero::all();
        $paises = Pais::all();

        return view('perfil.ingresarUsuarios', compact('perfiles', 'tiposDocumento', 'generos', 'paises'));
    }

    public function storeUsuario(Request $request)
    {
        $request->validate([
            'nombresUsu' => 'required|max:40',
            'apellidosUsu' => 'required|max:40',
            'emailUsu' => 'required|email|max:60|unique:usuario,emailUsu',
            'celularUsu' => 'nullable|max:20',
            'NidentificacionUsu' => 'required|max:20|unique:usuario,NidentificacionUsu',
            'Contrasena' => 'required|min:6',
            'idPerfil' => 'required|exists:perfil,idPerfil',
        ]);

        $usuario = new Usuario();
        $usuario->nombresUsu = $request->nombresUsu;
        $usuario->apellidosUsu = $request->apellidosUsu;
        $usuario->emailUsu = $request->emailUsu;
        $usuario->celularUsu = $request->celularUsu;
        $usuario->NidentificacionUsu = $request->NidentificacionUsu;
        $usuario->Contrasena = bcrypt($request->Contrasena);
        $usuario->idPerfil = $request->idPerfil;
        $usuario->idEstado = 1;
        $usuario->save();

        return redirect()->route('usuarios.ingresar')->with('success', 'Usuario registrado correctamente.');
    }

    public function modificarUsuario(Request $request)
    {
        // Búsqueda y listado de usuarios
        $query = Usuario::query();
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function($q) use ($busqueda) {
                $q->where('nombresUsu', 'like', "%$busqueda%")
                ->orWhere('apellidosUsu', 'like', "%$busqueda%")
                ->orWhere('NidentificacionUsu', 'like', "%$busqueda%")
                ->orWhere('emailUsu', 'like', "%$busqueda%");
            });
        }
        $usuarios = $query->orderBy('nombresUsu')->get();

        $usuarioSeleccionado = null;
        $departamentos = [];
        $ciudades = [];

        if ($request->filled('usuario_id')) {
            $usuarioSeleccionado = Usuario::find($request->usuario_id);

            // Cargar departamentos y ciudades según el usuario seleccionado
            if ($usuarioSeleccionado) {
                $departamentos = Departamento::where('idPais', $usuarioSeleccionado->idPais)->get();
                $ciudades = Ciudad::where('idDepartamento', $usuarioSeleccionado->idDepartamento)->get();
            }
        }

        $tiposDocumento = TipoDocumento::all();
        $generos = Genero::all();
        $paises = Pais::all();
        $perfiles = Perfil::all();

        return view('perfil.modificarUsuarios', compact(
            'usuarios',
            'usuarioSeleccionado',
            'tiposDocumento',
            'generos',
            'paises',
            'departamentos',
            'ciudades',
            'perfiles'
        ));
    }

    public function updateUsuario(Request $request, $idUsuario)
    {
        $usuario = Usuario::findOrFail($idUsuario);

        $request->validate([
            'nombresUsu' => 'required|max:40',
            'apellidosUsu' => 'required|max:40',
            'emailUsu' => 'required|email|max:60|unique:usuario,emailUsu,' . $usuario->idUsuario . ',idUsuario',
            'celularUsu' => 'nullable|max:20',
            'idTipoDocumento' => 'required|exists:tipodocumento,idTipoDocumento',
            'NidentificacionUsu' => 'required|max:20|unique:usuario,NidentificacionUsu,' . $usuario->idUsuario . ',idUsuario',
            'fechaNacUsu' => 'required|date',
            'idGenero' => 'required|exists:genero,idGenero',
            'idCiudad' => 'required|exists:ciudad,idCiudad',
            'idPerfil' => 'required|exists:perfil,idPerfil',
            'idEstado' => 'required|in:1,2',
        ]);

        $usuario->nombresUsu = $request->nombresUsu;
        $usuario->apellidosUsu = $request->apellidosUsu;
        $usuario->emailUsu = $request->emailUsu;
        $usuario->celularUsu = $request->celularUsu;
        $usuario->idTipoDocumento = $request->idTipoDocumento;
        $usuario->NidentificacionUsu = $request->NidentificacionUsu;
        $usuario->fechaNacUsu = $request->fechaNacUsu;
        $usuario->idGenero = $request->idGenero;
        $usuario->idCiudad = $request->idCiudad;
        $usuario->idPerfil = $request->idPerfil;
        $usuario->idEstado = $request->idEstado;

        if ($request->filled('Contrasena')) {
            $usuario->Contrasena = bcrypt($request->Contrasena);
        }

        $usuario->save();

        return redirect()->route('usuarios.modificar', [
            'usuario_id' => $usuario->idUsuario
        ])->with('success', 'Usuario modificado correctamente.');
    }

    public function eliminarUsuario(Request $request)
    {
        // Búsqueda y listado de usuarios
        $query = Usuario::query();
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function($q) use ($busqueda) {
                $q->where('nombresUsu', 'like', "%$busqueda%")
                ->orWhere('apellidosUsu', 'like', "%$busqueda%")
                ->orWhere('NidentificacionUsu', 'like', "%$busqueda%")
                ->orWhere('emailUsu', 'like', "%$busqueda%");
            });
        }
        $usuarios = $query->orderBy('nombresUsu')->get();

        $usuarioSeleccionado = null;
        if ($request->filled('usuario_id')) {
            $usuarioSeleccionado = Usuario::find($request->usuario_id);
        }

        return view('perfil.eliminarUsuarios', compact('usuarios', 'usuarioSeleccionado'));
    }

    public function destroyUsuario($idUsuario)
    {
        $usuario = Usuario::findOrFail($idUsuario);
        $usuario->delete();

        return redirect()->route('usuarios.eliminar')->with('success', 'Usuario eliminado correctamente.');
    }

    public function consultarUsuarios(Request $request)
    {
        $query = Usuario::with('perfil');

        // Filtros (igual que en reporte)
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $filtro = $request->input('filtro', 'nombre');
            $query->where(function($q) use ($busqueda, $filtro) {
                if ($filtro == 'nombre') {
                    $q->where('nombresUsu', 'like', "%$busqueda%")
                    ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                } elseif ($filtro == 'identificacion') {
                    $q->where('NidentificacionUsu', 'like', "%$busqueda%");
                } elseif ($filtro == 'correo') {
                    $q->where('emailUsu', 'like', "%$busqueda%");
                } else { // general
                    $q->where('nombresUsu', 'like', "%$busqueda%")
                    ->orWhere('apellidosUsu', 'like', "%$busqueda%")
                    ->orWhere('NidentificacionUsu', 'like', "%$busqueda%")
                    ->orWhere('emailUsu', 'like', "%$busqueda%");
                }
            });
        }

        // Si se presiona "limpiar", quitar filtros
        if ($request->has('limpiar')) {
            return redirect()->route('usuarios.consultar');
        }

        $usuarios = $query->orderBy('nombresUsu')->get();

        return view('perfil.consultarUsuarios', compact('usuarios'));
    }

    public function reporteUsuarios(Request $request)
    {
        $query = Usuario::with('perfil');

        // Filtros (opcional, igual que en consultar)
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $filtro = $request->input('filtro', 'nombre');
            $query->where(function($q) use ($busqueda, $filtro) {
                if ($filtro == 'nombre') {
                    $q->where('nombresUsu', 'like', "%$busqueda%")
                    ->orWhere('apellidosUsu', 'like', "%$busqueda%");
                } elseif ($filtro == 'identificacion') {
                    $q->where('NidentificacionUsu', 'like', "%$busqueda%");
                } elseif ($filtro == 'correo') {
                    $q->where('emailUsu', 'like', "%$busqueda%");
                } else { // general
                    $q->where('nombresUsu', 'like', "%$busqueda%")
                    ->orWhere('apellidosUsu', 'like', "%$busqueda%")
                    ->orWhere('NidentificacionUsu', 'like', "%$busqueda%")
                    ->orWhere('emailUsu', 'like', "%$busqueda%");
                }
            });
        }

        $usuarios = $query->orderBy('nombresUsu')->get();

        return view('perfil.reporteUsuarios', compact('usuarios'));
    }

    public function estado(Request $request)
    {
        // Búsqueda y listado de usuarios
        $query = Usuario::query();
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function($q) use ($busqueda) {
                $q->where('nombresUsu', 'like', "%$busqueda%")
                ->orWhere('apellidosUsu', 'like', "%$busqueda%")
                ->orWhere('NidentificacionUsu', 'like', "%$busqueda%")
                ->orWhere('emailUsu', 'like', "%$busqueda%");
            });
        }
        $usuarios = $query->orderBy('nombresUsu')->get();

        $usuarioSeleccionado = null;
        if ($request->filled('usuario_id')) {
            $usuarioSeleccionado = Usuario::find($request->usuario_id);
        }

        $estados = Estado::all();

        return view('perfil.estadoUsuarios', compact('usuarios', 'usuarioSeleccionado', 'estados'));
    }

    public function actualizarEstado(Request $request, $idUsuario)
    {
        $request->validate([
            'idEstado' => 'required|exists:estado,idEstado',
        ]);

        $usuario = Usuario::findOrFail($idUsuario);
        $usuario->idEstado = $request->idEstado;
        $usuario->save();

        return redirect()->route('usuarios.estado', ['usuario_id' => $usuario->idUsuario])
            ->with('success', 'Estado actualizado correctamente.');
    }

}