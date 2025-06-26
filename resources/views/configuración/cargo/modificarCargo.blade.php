@extends('layouts.app')

@section('title', 'Modificar Cargo | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('cargo') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Cargo</h2>

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

    {{-- Selección de cargo --}}
    <form id="buscarCargoForm" method="GET" action="{{ route('cargo.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="cargo_id" id="cargo_id">
                <option value="">Selecciona un cargo</option>
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->idCargo }}" {{ (request('cargo_id') == $cargo->idCargo) ? 'selected' : '' }}>
                        {{ $cargo->nombreCargo }} (ID: {{ $cargo->idCargo }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($cargoSeleccionado))
    <form action="{{ route('cargo.update', $cargoSeleccionado->idCargo) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $cargoSeleccionado->idCargo }}" readonly>
        </div>
        <div>
            <label for="nombreCargo">Nombre</label>
            <input type="text" id="nombreCargo" name="nombreCargo" required maxlength="100" value="{{ old('nombreCargo', $cargoSeleccionado->nombreCargo) }}">
        </div>
        <div>
            <label for="descripcionCargo">Descripción</label>
            <input type="text" id="descripcionCargo" name="descripcionCargo" required maxlength="255" value="{{ old('descripcionCargo', $cargoSeleccionado->descripcionCargo) }}">
        </div>
        <div>
            <label for="nomenclaturaCargo">Nomenclatura</label>
            <input type="text" id="nomenclaturaCargo" name="nomenclaturaCargo" required maxlength="100" value="{{ old('nomenclaturaCargo', $cargoSeleccionado->nomenclaturaCargo) }}">
        </div>
        <div>
            <label for="sueldo">Sueldo</label>
            <input type="number" id="sueldo" name="sueldo" required min="0" step="0.01" value="{{ old('sueldo', $cargoSeleccionado->sueldo) }}">
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('cargo') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un cargo para modificar.</p>
    @endif
</div>
@endsection