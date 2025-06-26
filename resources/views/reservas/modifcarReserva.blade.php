@extends('layouts.app')

@section('title', 'Modificar Reserva | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('reservas') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Reserva</h2>

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
    <form id="buscarReservaForm" method="GET" action="{{ route('reservas.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por usuario, artista o fecha..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="reserva_id" id="reserva_id">
                <option value="">Selecciona una reserva</option>
                @foreach($reservas as $reserva)
                    <option value="{{ $reserva->idReserva }}" {{ (request('reserva_id') == $reserva->idReserva) ? 'selected' : '' }}>
                        {{ $reserva->fechaReserva }} - {{ $reserva->usuario->nombresUsu ?? '' }} ({{ $reserva->servicio->nombreServicio ?? '' }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($reservaSeleccionada))
    <form action="{{ route('reservas.update', $reservaSeleccionada->idReserva) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Usuario --}}
        <div>
            <label for="idUsuario">Usuario</label>
            <select id="idUsuario" name="idUsuario" required>
                <option value="">Seleccione un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->idUsuario }}" {{ old('idUsuario', $reservaSeleccionada->idUsuario) == $usuario->idUsuario ? 'selected' : '' }}>
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
                    <option value="{{ $artista->idUsuario }}" {{ old('idArtista', $reservaSeleccionada->idArtista) == $artista->idUsuario ? 'selected' : '' }}>
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
                    <option value="{{ $servicio->idServicio }}" {{ old('idServicio', $reservaSeleccionada->idServicio) == $servicio->idServicio ? 'selected' : '' }}>
                        {{ $servicio->nombreServicio }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Fecha --}}
        <div>
            <label for="fechaReserva">Fecha</label>
            <input type="date" id="fechaReserva" name="fechaReserva" required value="{{ old('fechaReserva', $reservaSeleccionada->fechaReserva) }}">
        </div>

        {{-- Hora --}}
        <div>
            <label for="horaReserva">Hora</label>
            <input type="time" id="horaReserva" name="horaReserva" required value="{{ old('horaReserva', $reservaSeleccionada->horaReserva) }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionReserva">Descripción</label>
            <input type="text" id="descripcionReserva" name="descripcionReserva" maxlength="255" value="{{ old('descripcionReserva', $reservaSeleccionada->descripcionReserva) }}">
        </div>

        {{-- Estado --}}
        <div>
            <label for="idEstado">Estado</label>
            <select id="idEstado" name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ old('idEstado', $reservaSeleccionada->idEstado) == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Cambios</button>
            <a href="{{ route('reservas') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una reserva para modificar.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('reserva_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
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