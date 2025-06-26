@extends('layouts.app')

@section('title', 'Consultar Usuarios | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('perfil.ver') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Usuarios</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('usuarios.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="nombre" {{ request('filtro', 'nombre') == 'nombre' ? 'checked' : '' }}> Nombre</label>
            <label><input type="radio" name="filtro" value="identificacion" {{ request('filtro') == 'identificacion' ? 'checked' : '' }}> Identificación</label>
            <label><input type="radio" name="filtro" value="correo" {{ request('filtro') == 'correo' ? 'checked' : '' }}> Correo</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('usuarios.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
        </div>
    </form>

    {{-- Tabla de usuarios --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Identificación</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->idUsuario }}</td>
                        <td>{{ $usuario->nombresUsu }}</td>
                        <td>{{ $usuario->apellidosUsu }}</td>
                        <td>{{ $usuario->emailUsu }}</td>
                        <td>{{ $usuario->NidentificacionUsu }}</td>
                        <td>{{ $usuario->perfil->nombrePerfil ?? 'Sin perfil' }}</td>
                        <td>{{ $usuario->idEstado == 1 ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay usuarios para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection