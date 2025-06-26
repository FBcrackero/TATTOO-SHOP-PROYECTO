@extends('layouts.app')

@section('title', 'Perfil de Usuario | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endpush

@section('content')
<div class="perfil-section perfil-flex">
    @if(Auth::user()->idPerfil == 1)
        <div class="admin-perfil">
            <h1 class="admin-productos-titulo">Administrar Usuarios</h1>
            <p class="admin-productos-subtitulo">
                Gestiona los usuarios y roles del sistema.
            </p>
            <div class="admin-productos-botones">
            <a href="{{ route('usuarios.ingresar') }}" class="admin-btn">Ingresar usuario</a>
            <a href="{{ route('usuarios.modificar') }}" class="admin-btn">Modificar usuario</a>
            <a href="{{ route('usuarios.eliminar') }}" class="admin-btn">Eliminar usuario</a>
            <a href="{{ route('usuarios.consultar') }}" class="admin-btn">Consultar usuario</a>
            <a href="{{ route('usuarios.estado') }}" class="admin-btn">Estado usuario</a>
            <a href="{{ route('facturas.consultar') }}" class="admin-btn">Consultar facturas</a>
        </div>
        </div>
    @else
        <div class="perfil-container perfil-form-card">
            <h2>Mi Perfil</h2>
            @if(session('success'))
                <div class="mensaje-exito">{{ session('success') }}</div>
            @endif
            <form action="{{ route('perfil.actualizar') }}" method="POST" class="perfil-form">
                @csrf
                @method('PUT')
                <div class="perfil-form-group">
                    <label for="nombresUsu">Nombre:</label>
                    <input type="text" name="nombresUsu" id="nombresUsu" value="{{ Auth::user()->nombresUsu }}" required>
                </div>
                <div class="perfil-form-group">
                    <label for="apellidosUsu">Apellido:</label>
                    <input type="text" name="apellidosUsu" id="apellidosUsu" value="{{ Auth::user()->apellidosUsu }}" required>
                </div>
                <div class="perfil-form-group">
                    <label for="emailUsu">Correo electrónico:</label>
                    <input type="email" name="emailUsu" id="emailUsu" value="{{ Auth::user()->emailUsu }}" required>
                </div>
                <div class="perfil-form-group">
                    <label for="celularUsu">Teléfono:</label>
                    <input type="text" name="celularUsu" id="celularUsu" value="{{ Auth::user()->celularUsu }}">
                </div>
                <div class="perfil-form-group">
                    <label for="idTipoDocumento">Tipo de documento:</label>
                    <input type="text" value="{{ Auth::user()->tipoDocumento->nombreTipoDoc ?? '-' }}" readonly>
                </div>
                <div class="perfil-form-group">
                    <label for="NidentificacionUsu">Identificación:</label>
                    <input type="text" name="NidentificacionUsu" id="NidentificacionUsu" value="{{ Auth::user()->NidentificacionUsu }}" required>
                </div>
                <div class="perfil-form-group">
                    <label for="fechaNacUsu">Fecha de nacimiento:</label>
                    <input type="text" value="{{ Auth::user()->fechaNacUsu }}" readonly>
                </div>
                <div class="perfil-form-group">
                    <label for="idGenero">Género:</label>
                    <input type="text" value="{{ Auth::user()->genero->nombreGenero ?? '-' }}" readonly>
                </div>
                <div class="perfil-form-group">
                    <label for="idCiudad">Ciudad:</label>
                    <input type="text" value="{{ Auth::user()->ciudad->nombreCiudad ?? '-' }}" readonly>
                </div>
                <div class="perfil-form-group">
                    <label for="idPerfil">Perfil:</label>
                    <input type="text" value="{{ Auth::user()->perfil->nombrePerfil ?? '-' }}" readonly>
                </div>
                <div class="perfil-form-group">
                    <label for="idEstado">Estado:</label>
                    <input type="text" value="{{ Auth::user()->idEstado == 1 ? 'Activo' : 'Inactivo' }}" readonly>
                </div>
                <hr>
                <div class="perfil-form-group">
                    <label for="current_password">Contraseña actual:</label>
                    <input type="password" name="current_password" id="current_password" required placeholder="Ingresa tu contraseña actual">
                </div>
                <div class="perfil-form-group">
                    <label for="Contrasena">Nueva contraseña (dejar en blanco para no cambiar):</label>
                    <input type="password" name="Contrasena" id="Contrasena" minlength="6">
                </div>
                <button type="submit" class="perfil-btn">Actualizar datos</button>
            </form>
            <a href="{{ route('factura.historial') }}" class="perfil-btn perfil-btn-secundario" style="margin-top:18px;">Historial de compras</a>
            <form action="{{ route('profile.destroy') }}" method="POST" style="margin-top:24px;">
                @csrf
                @method('DELETE')
                <div class="perfil-form-group">
                    <label for="delete_password">Contraseña para eliminar cuenta:</label>
                    <input type="password" name="delete_password" id="delete_password" required placeholder="Ingresa tu contraseña">
                </div>
                <button type="submit" class="perfil-btn" style="background:#c0392b;color:#fff;border-color:#c0392b;">Eliminar cuenta</button>
            </form>
        </div>
    @endif
</div>
@endsection