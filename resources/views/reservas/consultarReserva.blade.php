@extends('layouts.app')

@section('title', 'Consultar Reservas | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('reservas') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Reservas</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('reservas.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="usuario" {{ request('filtro', 'usuario') == 'usuario' ? 'checked' : '' }}> Usuario</label>
            <label><input type="radio" name="filtro" value="artista" {{ request('filtro') == 'artista' ? 'checked' : '' }}> Artista</label>
            <label><input type="radio" name="filtro" value="servicio" {{ request('filtro') == 'servicio' ? 'checked' : '' }}> Servicio</label>
            <label><input type="radio" name="filtro" value="fecha" {{ request('filtro') == 'fecha' ? 'checked' : '' }}> Fecha</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('reservas.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>            {{-- Si tienes reporte PDF, agrega aquí el botón de reporte --}}
        </div>
    </form>

    {{-- Tabla de reservas --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Artista</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->idReserva }}</td>
                        <td>{{ $reserva->usuario->nombresUsu ?? '' }}</td>
                        <td>{{ $reserva->artista->nombresUsu ?? '' }}</td>
                        <td>{{ $reserva->servicio->nombreServicio ?? '' }}</td>
                        <td>{{ $reserva->fechaReserva }}</td>
                        <td>{{ $reserva->horaReserva }}</td>
                        <td>{{ $reserva->estado->nombreEstado ?? 'Sin estado' }}</td>
                        <td>{{ $reserva->descripcionReserva }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No hay reservas para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection