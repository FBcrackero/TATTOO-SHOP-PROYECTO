@extends('layouts.app')

@section('title', 'Ingresar Reserva | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Nueva Reserva</h2>

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

    <form action="{{ route('reservas.store.admin') }}" method="POST">
        @csrf

        {{-- Usuario --}}
        <div>
            <label for="idUsuario">Usuario</label>
            <select id="idUsuario" name="idUsuario" required>
                <option value="">Seleccione un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->idUsuario }}" {{ old('idUsuario') == $usuario->idUsuario ? 'selected' : '' }}>
                        {{ $usuario->nombresUsu }} {{ $usuario->apellidosUsu }} ({{ $usuario->emailUsu }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Artista --}}
        <div>
            <label for="idArtista">Artista</label>
            <select id="idArtista" name="idArtista" required>
                <option value="">Seleccione un artista</option>
                @foreach($artistas as $artista)
                    <option value="{{ $artista->idUsuario }}" {{ old('idArtista') == $artista->idUsuario ? 'selected' : '' }}>
                        {{ $artista->nombresUsu }} {{ $artista->apellidosUsu }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Servicio --}}
        <div>
            <label for="idServicio">Servicio</label>
            <select id="idServicio" name="idServicio" required>
                <option value="">Seleccione un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->idServicio }}" {{ old('idServicio') == $servicio->idServicio ? 'selected' : '' }}>
                        {{ $servicio->nombreServicio }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Fecha --}}
        <div>
            <label for="fechaReserva">Fecha</label>
            <input type="date" id="fechaReserva" name="fechaReserva" required value="{{ old('fechaReserva') }}">
        </div>

        {{-- Hora --}}
        <div>
            <label for="horaReserva">Hora</label>
            <input type="time" id="horaReserva" name="horaReserva" required value="{{ old('horaReserva') }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionReserva">Descripción</label>
            <input type="text" id="descripcionReserva" name="descripcionReserva" maxlength="255" value="{{ old('descripcionReserva') }}">
        </div>

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Reserva</button>
            <a href="{{ route('reservas') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection