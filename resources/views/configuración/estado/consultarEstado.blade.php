@extends('layouts.app')

@section('title', 'Consultar Estados | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('estado') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Estados</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('estado.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="nombre" {{ request('filtro', 'nombre') == 'nombre' ? 'checked' : '' }}> Nombre</label>
            <label><input type="radio" name="filtro" value="nomenclatura" {{ request('filtro') == 'nomenclatura' ? 'checked' : '' }}> Nomenclatura</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('estado.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
        </div>
    </form>

    {{-- Tabla de estados --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Nomenclatura</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estados as $estado)
                    <tr>
                        <td>{{ $estado->idEstado }}</td>
                        <td>{{ $estado->nombreEstado }}</td>
                        <td>{{ $estado->nomenclaturaEstado }}</td>
                        <td>{{ $estado->descripcionEstado }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay estados para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection