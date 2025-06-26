@extends('layouts.app')

@section('title', 'Ingresar Empleado | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Empleado</h2>

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

    {{-- Barra de búsqueda para usuario --}}
    <form method="GET" action="{{ route('empleado.ingresar') }}" style="margin-bottom: 20px;">
        <label for="busquedaUsuario">Buscar usuario:</label>
        <input type="text" name="busquedaUsuario" id="busquedaUsuario" placeholder="ID, identificación o nombre" value="{{ request('busquedaUsuario') }}">
        <button type="submit" class="btn">Buscar</button>
    </form>

    <form action="{{ route('empleado.store') }}" method="POST">
        @csrf

        <div>
            <label for="fechaVinculacionEmpleado">Fecha de Vinculación</label>
            <input type="date" id="fechaVinculacionEmpleado" name="fechaVinculacionEmpleado" required value="{{ old('fechaVinculacionEmpleado') }}">
        </div>

        <div>
            <label for="numeroContrato">Número de Contrato</label>
            <input type="number" id="numeroContrato" name="numeroContrato" required value="{{ old('numeroContrato') }}">
        </div>

        <div>
            <label for="idCargo">Cargo</label>
            <select id="idCargo" name="idCargo" required>
                <option value="">Selecciona un cargo</option>
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->idCargo }}" {{ old('idCargo') == $cargo->idCargo ? 'selected' : '' }}>
                        {{ $cargo->nombreCargo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="idUsuario">Usuario</label>
            <select id="idUsuario" name="idUsuario" required>
                <option value="">Selecciona un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->idUsuario }}" {{ old('idUsuario') == $usuario->idUsuario ? 'selected' : '' }}>
                        {{ $usuario->nombresUsu }} {{ $usuario->apellidosUsu }} ({{ $usuario->NidentificacionUsu }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit">Guardar Empleado</button>
            <a href="{{ route('empleado') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection