@extends('layouts.app')

@section('title', 'Modificar Usuario | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('perfil.ver') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Usuario</h2>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mensaje-exito">
            {{ session('success') }}
        </div>
    @endif

    {{-- Barra de búsqueda y select --}}
    <form id="buscarUsuarioForm" method="GET" action="{{ route('usuarios.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, identificación o correo..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="usuario_id" id="usuario_id">
                <option value="">Selecciona un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->idUsuario }}" {{ (request('usuario_id') == $usuario->idUsuario) ? 'selected' : '' }}>
                        {{ $usuario->nombresUsu }} {{ $usuario->apellidosUsu }} (ID: {{ $usuario->idUsuario }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($usuarioSeleccionado))
    <form action="{{ route('usuarios.update', $usuarioSeleccionado->idUsuario) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombres --}}
        <div>
            <label for="nombresUsu">Nombres</label>
            <input type="text" id="nombresUsu" name="nombresUsu" required maxlength="40" value="{{ old('nombresUsu', $usuarioSeleccionado->nombresUsu) }}">
        </div>

        {{-- Apellidos --}}
        <div>
            <label for="apellidosUsu">Apellidos</label>
            <input type="text" id="apellidosUsu" name="apellidosUsu" required maxlength="40" value="{{ old('apellidosUsu', $usuarioSeleccionado->apellidosUsu) }}">
        </div>

        {{-- Teléfono --}}
        <div>
            <label for="celularUsu">Teléfono</label>
            <input type="text" id="celularUsu" name="celularUsu" maxlength="20" value="{{ old('celularUsu', $usuarioSeleccionado->celularUsu) }}">
        </div>

        {{-- Tipo de documento --}}
        <div>
            <label for="idTipoDocumento">Tipo de documento</label>
            <select name="idTipoDocumento" id="idTipoDocumento" required>
                <option value="">Seleccione</option>
                @foreach($tiposDocumento as $tipo)
                    <option value="{{ $tipo->idTipoDocumento }}" {{ old('idTipoDocumento', $usuarioSeleccionado->idTipoDocumento) == $tipo->idTipoDocumento ? 'selected' : '' }}>
                        {{ $tipo->nombreTipoDoc }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Identificación --}}
        <div>
            <label for="NidentificacionUsu">Identificación</label>
            <input type="text" id="NidentificacionUsu" name="NidentificacionUsu" required maxlength="20" value="{{ old('NidentificacionUsu', $usuarioSeleccionado->NidentificacionUsu) }}">
        </div>

        {{-- Fecha de nacimiento --}}
        <div>
            <label for="fechaNacUsu">Fecha de nacimiento</label>
            <input
                type="text"
                id="fechaNacUsu"
                name="fechaNacUsu"
                placeholder="Fecha de nacimiento"
                value="{{ old('fechaNacUsu', $usuarioSeleccionado->fechaNacUsu) }}"
                required
                onfocus="(this.type='date')"
                onblur="if(this.value==''){this.type='text'}"
            />
        </div>

        {{-- Género --}}
        <div>
            <label for="idGenero">Género</label>
            <select name="idGenero" id="idGenero" required>
                <option value="">Seleccione</option>
                @foreach($generos as $genero)
                    <option value="{{ $genero->idGenero }}" {{ old('idGenero', $usuarioSeleccionado->idGenero) == $genero->idGenero ? 'selected' : '' }}>
                        {{ $genero->nombreGenero }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- País --}}
        <div>
            <label for="idPais">País</label>
            <select name="idPais" id="idPais" required>
                <option value="">Seleccione</option>
                @foreach($paises as $pais)
                    <option value="{{ $pais->idPais }}" {{ old('idPais', $usuarioSeleccionado->idPais ?? '') == $pais->idPais ? 'selected' : '' }}>
                        {{ $pais->nombrePais }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Departamento --}}
        <div>
            <label for="idDepartamento">Departamento</label>
            <select name="idDepartamento" id="idDepartamento" required>
                <option value="">Seleccione</option>
                @if(isset($departamentos))
                    @foreach($departamentos as $depto)
                        <option value="{{ $depto->idDepartamento }}" {{ old('idDepartamento', $usuarioSeleccionado->idDepartamento ?? '') == $depto->idDepartamento ? 'selected' : '' }}>
                            {{ $depto->nombreDepartamento }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Ciudad --}}
        <div>
            <label for="idCiudad">Ciudad</label>
            <select name="idCiudad" id="idCiudad" required>
                <option value="">Seleccione</option>
                @if(isset($ciudades))
                    @foreach($ciudades as $ciudad)
                        <option value="{{ $ciudad->idCiudad }}" {{ old('idCiudad', $usuarioSeleccionado->idCiudad) == $ciudad->idCiudad ? 'selected' : '' }}>
                            {{ $ciudad->nombreCiudad }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Correo electrónico --}}
        <div>
            <label for="emailUsu">Correo electrónico</label>
            <input type="email" id="emailUsu" name="emailUsu" required maxlength="60" value="{{ old('emailUsu', $usuarioSeleccionado->emailUsu) }}">
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="Contrasena">Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" id="Contrasena" name="Contrasena" minlength="6">
        </div>

        {{-- Perfil/Rol --}}
        <div>
            <label for="idPerfil">Perfil</label>
            <select id="idPerfil" name="idPerfil" required>
                <option value="">Seleccione un perfil</option>
                @foreach($perfiles as $perfil)
                    <option value="{{ $perfil->idPerfil }}" {{ old('idPerfil', $usuarioSeleccionado->idPerfil) == $perfil->idPerfil ? 'selected' : '' }}>
                        {{ $perfil->nombrePerfil }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Cambios</button>
            <a href="{{ route('perfil.ver') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un usuario para modificar.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('idPais')?.addEventListener('change', function() {
        let paisId = this.value;
        fetch('/departamentos/' + paisId)
            .then(response => response.json())
            .then(data => {
                let deptSelect = document.getElementById('idDepartamento');
                deptSelect.innerHTML = '<option value="">Seleccione</option>';
                data.forEach(function(depto) {
                    deptSelect.innerHTML += `<option value="${depto.idDepartamento}">${depto.nombreDepartamento}</option>`;
                });
                document.getElementById('idCiudad').innerHTML = '<option value="">Seleccione</option>';
            });
    });

    document.getElementById('idDepartamento')?.addEventListener('change', function() {
        let deptId = this.value;
        fetch('/ciudades/' + deptId)
            .then(response => response.json())
            .then(data => {
                let ciudadSelect = document.getElementById('idCiudad');
                ciudadSelect.innerHTML = '<option value="">Seleccione</option>';
                data.forEach(function(ciudad) {
                    ciudadSelect.innerHTML += `<option value="${ciudad.idCiudad}">${ciudad.nombreCiudad}</option>`;
                });
            });
    });

    // Cambio automático al seleccionar en el select
    const select = document.getElementById('usuario_id');
    if(select){
        select.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Desvanecer mensaje de éxito
    const mensaje = document.querySelector('.mensaje-exito');
    if(mensaje){
        setTimeout(() => {
            mensaje.style.transition = 'opacity 0.5s';
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.style.display = 'none', 500);
        }, 2000);
    }
</script>
@endpush