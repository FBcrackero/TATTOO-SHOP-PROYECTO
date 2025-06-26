@extends('layouts.app')

@section('title', 'Estado del Cargo | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('cargo') }}" class="volver-flecha" title="Volver"></a>
    <h2>Cambiar Estado del Cargo</h2>

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

    {{-- Barra de búsqueda y select --}}
    <form id="buscarCargoForm" method="GET" action="{{ route('cargo.estado') }}">
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

    {{-- Formulario de cambio de estado --}}
    @if(isset($cargoSeleccionado))
    <form action="{{ route('cargo.estado.update', $cargoSeleccionado->idCargo) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $cargoSeleccionado->idCargo }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $cargoSeleccionado->nombreCargo }}" readonly>
        </div>
        <div>
            <label>Nomenclatura:</label>
            <input type="text" value="{{ $cargoSeleccionado->nomenclaturaCargo }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <select name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ $cargoSeleccionado->idEstado == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Actualizar Estado</button>
            <a href="{{ route('cargo') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un cargo para cambiar su estado.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('cargo_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush