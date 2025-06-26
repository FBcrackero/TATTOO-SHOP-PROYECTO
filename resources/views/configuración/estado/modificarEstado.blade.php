@extends('layouts.app')

@section('title', 'Modificar Estado | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('estado') }}" class="volver-flecha" title="Volver"></a>
    <h2>Modificar Estado</h2>

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

    {{-- Selección de estado --}}
    <form id="buscarEstadoForm" method="GET" action="{{ route('estado.modificar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="estado_id" id="estado_id">
                <option value="">Selecciona un estado</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ (request('estado_id') == $estado->idEstado) ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }} (ID: {{ $estado->idEstado }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de modificación --}}
    @if(isset($estadoSeleccionado))
    <form action="{{ route('estado.update', $estadoSeleccionado->idEstado) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $estadoSeleccionado->idEstado }}" readonly>
        </div>
        <div>
            <label for="nombreEstado">Nombre</label>
            <input type="text" id="nombreEstado" name="nombreEstado" required maxlength="40" value="{{ old('nombreEstado', $estadoSeleccionado->nombreEstado) }}">
        </div>
        <div>
            <label for="nomenclaturaEstado">Nomenclatura</label>
            <input type="text" id="nomenclaturaEstado" name="nomenclaturaEstado" required maxlength="10" value="{{ old('nomenclaturaEstado', $estadoSeleccionado->nomenclaturaEstado) }}">
        </div>
        <div>
            <label for="descripcionEstado">Descripción</label>
            <input type="text" id="descripcionEstado" name="descripcionEstado" required maxlength="100" value="{{ old('descripcionEstado', $estadoSeleccionado->descripcionEstado) }}">
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('estado') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un estado para modificar.</p>
    @endif
</div>
@endsection