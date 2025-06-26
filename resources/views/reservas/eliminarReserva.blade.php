@extends('layouts.app')

@section('title', 'Eliminar Reserva | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('reservas') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Reserva</h2>

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
    <form id="buscarReservaForm" method="GET" action="{{ route('reservas.eliminar') }}">
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

    {{-- Formulario de eliminación --}}
    @if(isset($reservaSeleccionada))
    <form action="{{ route('reservas.destroy', $reservaSeleccionada->idReserva) }}" method="POST">
        @csrf
        @method('DELETE')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $reservaSeleccionada->idReserva }}" readonly>
        </div>
        <div>
            <label>Usuario:</label>
            <input type="text" value="{{ $reservaSeleccionada->usuario->nombresUsu ?? '' }}" readonly>
        </div>
        <div>
            <label>Artista:</label>
            <input type="text" value="{{ $reservaSeleccionada->artista->nombresUsu ?? '' }}" readonly>
        </div>
        <div>
            <label>Servicio:</label>
            <input type="text" value="{{ $reservaSeleccionada->servicio->nombreServicio ?? '' }}" readonly>
        </div>
        <div>
            <label>Fecha:</label>
            <input type="text" value="{{ $reservaSeleccionada->fechaReserva }}" readonly>
        </div>
        <div>
            <label>Hora:</label>
            <input type="text" value="{{ $reservaSeleccionada->horaReserva }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <input type="text" value="{{ $reservaSeleccionada->estado->nombreEstado ?? '' }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta reserva?')">Eliminar</button>
            <a href="{{ route('reservas') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una reserva para eliminar.</p>
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