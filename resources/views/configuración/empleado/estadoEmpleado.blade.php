@extends('layouts.app')

@section('title', 'Estado del Empleado | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('empleado') }}" class="volver-flecha" title="Volver"></a>
    <h2>Cambiar Estado del Empleado</h2>

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
    <form id="buscarEmpleadoForm" method="GET" action="{{ route('empleado.estado') }}">
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

    {{-- Formulario de cambio de estado --}}
    @if(isset($empleadoSeleccionado))
    <form action="{{ route('empleado.estado.update', $empleadoSeleccionado->idEmpleado) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $empleadoSeleccionado->idEmpleado }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $empleadoSeleccionado->usuario->nombresUsu ?? '' }} {{ $empleadoSeleccionado->usuario->apellidosUsu ?? '' }}" readonly>
        </div>
        <div>
            <label>Identificación:</label>
            <input type="text" value="{{ $empleadoSeleccionado->usuario->NidentificacionUsu ?? '' }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <select name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ $empleadoSeleccionado->idEstado == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Actualizar Estado</button>
            <a href="{{ route('empleado') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un empleado para cambiar su estado.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('empleado_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush