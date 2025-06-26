@extends('layouts.app')

@section('title', 'Ingresar Usuario | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Nuevo Usuario</h2>

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

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        {{-- Nombres --}}
        <div>
            <label for="nombresUsu">Nombres</label>
            <input type="text" id="nombresUsu" name="nombresUsu" required maxlength="40" value="{{ old('nombresUsu') }}">
        </div>

        {{-- Apellidos --}}
        <div>
            <label for="apellidosUsu">Apellidos</label>
            <input type="text" id="apellidosUsu" name="apellidosUsu" required maxlength="40" value="{{ old('apellidosUsu') }}">
        </div>

        {{-- Teléfono --}}
        <div>
            <label for="celularUsu">Teléfono</label>
            <input type="text" id="celularUsu" name="celularUsu" maxlength="20" value="{{ old('celularUsu') }}">
        </div>

        {{-- Tipo de documento --}}
        <div>
            <label for="idTipoDocumento">Tipo de documento</label>
            <select name="idTipoDocumento" id="idTipoDocumento" required>
                <option value="">Seleccione</option>
                @foreach($tiposDocumento as $tipo)
                    <option value="{{ $tipo->idTipoDocumento }}" {{ old('idTipoDocumento') == $tipo->idTipoDocumento ? 'selected' : '' }}>
                        {{ $tipo->nombreTipoDoc }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Identificación --}}
        <div>
            <label for="NidentificacionUsu">Identificación</label>
            <input type="text" id="NidentificacionUsu" name="NidentificacionUsu" required maxlength="20" value="{{ old('NidentificacionUsu') }}">
        </div>

        {{-- Fecha de nacimiento --}}
        <div>
            <label for="fechaNacUsu">Fecha de nacimiento</label>
            <input
                type="text"
                id="fechaNacUsu"
                name="fechaNacUsu"
                placeholder="Fecha de nacimiento"
                value="{{ old('fechaNacUsu') }}"
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
                    <option value="{{ $genero->idGenero }}" {{ old('idGenero') == $genero->idGenero ? 'selected' : '' }}>
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
                    <option value="{{ $pais->idPais }}" {{ old('idPais') == $pais->idPais ? 'selected' : '' }}>
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
            </select>
        </div>

        {{-- Ciudad --}}
        <div>
            <label for="idCiudad">Ciudad</label>
            <select name="idCiudad" id="idCiudad" required>
                <option value="">Seleccione</option>
            </select>
        </div>

        {{-- Correo electrónico --}}
        <div>
            <label for="emailUsu">Correo electrónico</label>
            <input type="email" id="emailUsu" name="emailUsu" required maxlength="60" value="{{ old('emailUsu') }}">
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="Contrasena">Contraseña</label>
            <input type="password" id="Contrasena" name="Contrasena" required minlength="6">
        </div>

        {{-- Perfil/Rol --}}
        <div>
            <label for="idPerfil">Perfil</label>
            <select id="idPerfil" name="idPerfil" required>
                <option value="">Seleccione un perfil</option>
                @foreach($perfiles as $perfil)
                    <option value="{{ $perfil->idPerfil }}" {{ old('idPerfil') == $perfil->idPerfil ? 'selected' : '' }}>
                        {{ $perfil->nombrePerfil }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Usuario</button>
            <a href="{{ route('perfil.ver') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('idPais').addEventListener('change', function() {
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

    document.getElementById('idDepartamento').addEventListener('change', function() {
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
</script>
@endpush