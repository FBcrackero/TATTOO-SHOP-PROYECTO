@extends('layouts.app')

@section('title', 'Estado de la Reserva | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('reservas') }}" class="volver-flecha" title="Volver"></a>
    <h2>Cambiar Estado de la Reserva</h2>

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
    <form id="buscarReservaForm" method="GET" action="{{ route('reservas.estado') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o servicio..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="reserva_id" id="reserva_id">
                <option value="">Selecciona una reserva</option>
                @foreach($reservas as $reserva)
                    <option value="{{ $reserva->idReserva }}" {{ (request('reserva_id') == $reserva->idReserva) ? 'selected' : '' }}>
                        {{ $reserva->idReserva }} - {{ $reserva->usuario->nombresUsu ?? '' }} ({{ $reserva->servicio->nombreServicio ?? '' }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de cambio de estado --}}
    @if(isset($reservaSeleccionada))
    <form action="{{ route('reservas.estado.update', $reservaSeleccionada->idReserva) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID Reserva:</label>
            <input type="text" value="{{ $reservaSeleccionada->idReserva }}" readonly>
        </div>
        <div>
            <label>Usuario:</label>
            <input type="text" value="{{ $reservaSeleccionada->usuario->nombresUsu ?? '' }}" readonly>
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
            <label>Estado:</label>
            <select name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ $reservaSeleccionada->idEstado == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Actualizar Estado</button>
            <a href="{{ route('reservas') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona una reserva para cambiar su estado.</p>
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
    });
</script>
@endpush
