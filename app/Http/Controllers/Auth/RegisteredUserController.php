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
        $request->validate([
            'nombresUsu' => 'required|string|max:40',
            'apellidosUsu' => 'required|string|max:40',
            'celularUsu' => 'required|digits_between:7,10',
            'idTipoDocumento' => 'required|exists:tipodocumento,idTipoDocumento',
            'NIdentificacion' => 'required|string|max:20',
            'fechaNacUsu' => 'required|date',
            'idGenero' => 'required|exists:genero,idGenero',
            'idCiudad' => 'required|exists:ciudad,idCiudad',
            'emailUsu' => 'required|email|max:60|unique:usuario,emailUsu',
            'Contraseña' => 'required|string|min:8|confirmed',
        ], [
            'celularUsu.digits_between' => 'El celular debe tener entre 7 y 10 dígitos.',
            'NIdentificacion.max' => 'La identificación no debe superar 20 caracteres.',
            'Contraseña.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        $usuario = Usuario::create([
            'nombresUsu' => $request->nombresUsu,
            'apellidosUsu' => $request->apellidosUsu,
            'celularUsu' => $request->celularUsu,
            'idTipoDocumento' => $request->idTipoDocumento,
            'NIdentificacion' => $request->NIdentificacion,
            'fechaNacUsu' => $request->fechaNacUsu,
            'idGenero' => $request->idGenero,
            'idCiudad' => $request->idCiudad,
            'emailUsu' => $request->emailUsu,
            'Contrasena' => bcrypt($request->Contraseña),
            'idPerfil' => 2, 
            'idEstado' => 1,
        ]);

        event(new Registered($usuario));
        Auth::login($usuario);

        return redirect()->route('inicio')->with('success', '¡Registro exitoso!');
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