@extends('layouts.app')

@section('title', 'Eliminar Usuario | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('perfil.ver') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Usuario</h2>

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
    <form id="buscarUsuarioForm" method="GET" action="{{ route('usuarios.eliminar') }}">
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

    {{-- Formulario de eliminación --}}
    @if(isset($usuarioSeleccionado))
    <form action="{{ route('usuarios.destroy', $usuarioSeleccionado->idUsuario) }}" method="POST">
        @csrf
        @method('DELETE')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $usuarioSeleccionado->idUsuario }}" readonly>
        </div>
        <div>
            <label>Nombres:</label>
            <input type="text" value="{{ $usuarioSeleccionado->nombresUsu }}" readonly>
        </div>
        <div>
            <label>Apellidos:</label>
            <input type="text" value="{{ $usuarioSeleccionado->apellidosUsu }}" readonly>
        </div>
        <div>
            <label>Correo:</label>
            <input type="text" value="{{ $usuarioSeleccionado->emailUsu }}" readonly>
        </div>
        <div>
            <label>Identificación:</label>
            <input type="text" value="{{ $usuarioSeleccionado->NidentificacionUsu }}" readonly>
        </div>
        <div>
            <label>Perfil:</label>
            <input type="text" value="{{ $usuarioSeleccionado->perfil->nombrePerfil ?? '' }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <input type="text" value="{{ $usuarioSeleccionado->idEstado == 1 ? 'Activo' : 'Inactivo' }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
            <a href="{{ route('perfil.ver') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un usuario para eliminar.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
    });
</script>
@endpush