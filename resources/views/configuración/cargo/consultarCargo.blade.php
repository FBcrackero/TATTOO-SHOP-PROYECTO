@extends('layouts.app')

@section('title', 'Consultar Cargos | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('cargo') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Cargos</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('cargo.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="nombre" {{ request('filtro', 'nombre') == 'nombre' ? 'checked' : '' }}> Nombre</label>
            <label><input type="radio" name="filtro" value="nomenclatura" {{ request('filtro') == 'nomenclatura' ? 'checked' : '' }}> Nomenclatura</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('cargo.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
        </div>
    </form>

    {{-- Tabla de cargos --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Sueldo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cargos as $cargo)
                    <tr>
                        <td>{{ $cargo->idCargo }}</td>
                        <td>{{ $cargo->nombreCargo }}</td>
                        <td>{{ $cargo->descripcionCargo }}</td>
                        <td>{{ $cargo->nomenclaturaCargo }}</td>
                        <td>{{ $cargo->sueldo }}</td>
                        <td>
                            @if(isset($cargo->estado) && $cargo->estado)
                                {{ $cargo->estado->nombreEstado }}
                            @else
                                Sin estado
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay cargos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection