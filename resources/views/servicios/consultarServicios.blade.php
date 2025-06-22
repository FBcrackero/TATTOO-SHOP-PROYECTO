@extends('layouts.app')

@section('title', 'Consultar Servicios | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('servicios') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Servicios</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('servicios.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="nombre" {{ request('filtro', 'nombre') == 'nombre' ? 'checked' : '' }}> Nombre</label>
            <label><input type="radio" name="filtro" value="codigo" {{ request('filtro') == 'codigo' ? 'checked' : '' }}> Código</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Search" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('servicios.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
        </div>
    </form>

    {{-- Tabla de servicios --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Servicio</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($servicios as $servicio)
                    <tr>
                        <td>{{ str_pad($servicio->idServicio, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $servicio->nombreServicio }}</td>
                        <td>{{ $servicio->descripcionServicio }}</td>
                        <td>{{ $servicio->nomenclaturaServicio }}</td>
                        <td>{{ $servicio->estado->nombreEstado ?? 'Sin estado' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay servicios para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection