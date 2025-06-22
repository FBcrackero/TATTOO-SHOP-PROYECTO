<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Ciudad;
use App\Models\Genero;
use App\Models\TipoDocumento;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar el formulario de registro con datos reales.
     */
    public function create(): View
    {
        $tiposDocumento = TipoDocumento::all();
        $generos = Genero::all();
        $paises = Pais::all();

        return view('auth.register', compact('tiposDocumento', 'generos', 'paises'));
    }

    /**
     * Guardar el usuario.
     */
    public function store(Request $request)
    {
        // Validación aquí si lo necesitas...

        $usuario = Usuario::create([
            'nombresUsu' => $request->nombresUsu,
            'apellidosUsu' => $request->apellidosUsu,
            'celularUsu' => $request->celularUsu,
            'idTipoDocumento' => $request->idTipoDocumento,
            'NidentificacionUsu' => $request->NIdentificacion,
            'fechaNacUsu' => $request->fechaNacUsu,
            'idGenero' => $request->idGenero,
            'idCiudad' => $request->idCiudad,
            'emailUsu' => $request->emailUsu,
            'Contrasena' => Hash::make($request->Contraseña),
            'idPerfil' => 2, // Por defecto usuario normal
            'idEstado' => 1  // Estado activo
        ]);

        event(new Registered($usuario));
        Auth::login($usuario);

        return redirect('/inicio');
    }

    // Métodos para selects dependientes (AJAX)
    public function getDepartamentos($pais_id)
    {
        return Departamento::where('idPais', $pais_id)->get();
    }

    public function getCiudades($departamento_id)
    {
        return Ciudad::where('idDepartamento', $departamento_id)->get();
    }
}