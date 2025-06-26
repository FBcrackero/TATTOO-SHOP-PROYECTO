@extends('layouts.app')

@section('title', 'Modificar Empleado | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('empleado') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Empleado</h2>

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

    {{-- Selección de empleado --}}
    <form id="buscarEmpleadoForm" method="GET" action="{{ route('empleado.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o identificación..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="empleado_id" id="empleado_id">
                <option value="">Selecciona un empleado</option>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->idEmpleado }}" {{ (request('empleado_id') == $empleado->idEmpleado) ? 'selected' : '' }}>
                        {{ $empleado->usuario->nombresUsu ?? '' }} {{ $empleado->usuario->apellidosUsu ?? '' }} (ID: {{ $empleado->idEmpleado }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($empleadoSeleccionado))
    <form action="{{ route('empleado.update', $empleadoSeleccionado->idEmpleado) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $empleadoSeleccionado->idEmpleado }}" readonly>
        </div>
        <div>
            <label for="fechaVinculacionEmpleado">Fecha de Vinculación</label>
            <input type="date" id="fechaVinculacionEmpleado" name="fechaVinculacionEmpleado" required value="{{ old('fechaVinculacionEmpleado', $empleadoSeleccionado->fechaVinculacionEmpleado) }}">
        </div>
        <div>
            <label for="numeroContrato">Número de Contrato</label>
            <input type="number" id="numeroContrato" name="numeroContrato" required value="{{ old('numeroContrato', $empleadoSeleccionado->numeroContrato) }}">
        </div>
        <div>
            <label for="idCargo">Cargo</label>
            <select id="idCargo" name="idCargo" required>
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->idCargo }}" {{ old('idCargo', $empleadoSeleccionado->idCargo) == $cargo->idCargo ? 'selected' : '' }}>
                        {{ $cargo->nombreCargo }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('empleado') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un empleado para modificar.</p>
    @endif
</div>
@endsection