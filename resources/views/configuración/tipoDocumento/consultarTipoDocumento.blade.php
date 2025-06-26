@extends('layouts.app')

@section('title', 'Consultar Tipos de Documento | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('tipodocumento') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Tipos de Documento</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('tipodocumento.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="nombre" {{ request('filtro', 'nombre') == 'nombre' ? 'checked' : '' }}> Nombre</label>
            <label><input type="radio" name="filtro" value="nomenclatura" {{ request('filtro') == 'nomenclatura' ? 'checked' : '' }}> Nomenclatura</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('tipodocumento.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
        </div>
    </form>

    {{-- Tabla de tipos de documento --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tiposDocumento as $tipo)
                    <tr>
                        <td>{{ $tipo->idTipoDocumento }}</td>
                        <td>{{ $tipo->nombreTipoDoc }}</td>
                        <td>{{ $tipo->descripcionTipoDoc }}</td>
                        <td>{{ $tipo->nomenclaturaTipoDoc }}</td>
                        <td>{{ $tipo->estado ? $tipo->estado->nombreEstado : 'Sin estado' }}</td>                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay tipos de documento para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection