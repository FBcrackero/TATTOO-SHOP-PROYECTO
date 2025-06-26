
@extends('layouts.app')

@section('title', 'Consultar Empleados | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('empleado') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Empleados</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('empleado.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="nombre" {{ request('filtro', 'nombre') == 'nombre' ? 'checked' : '' }}> Nombre</label>
            <label><input type="radio" name="filtro" value="identificacion" {{ request('filtro') == 'identificacion' ? 'checked' : '' }}> Identificación</label>
            <label><input type="radio" name="filtro" value="cargo" {{ request('filtro') == 'cargo' ? 'checked' : '' }}> Cargo</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('empleado.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
        </div>
    </form>

    {{-- Tabla de empleados --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Cargo</th>
                    <th>Fecha Vinculación</th>
                    <th>Número Contrato</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->idEmpleado }}</td>
                        <td>{{ $empleado->usuario->nombresUsu ?? '' }} {{ $empleado->usuario->apellidosUsu ?? '' }}</td>
                        <td>{{ $empleado->usuario->NidentificacionUsu ?? '' }}</td>
                        <td>{{ $empleado->cargo->nombreCargo ?? '' }}</td>
                        <td>{{ $empleado->fechaVinculacionEmpleado }}</td>
                        <td>{{ $empleado->numeroContrato }}</td>
                        <td>{{ $empleado->estado->nombreEstado ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay empleados para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection