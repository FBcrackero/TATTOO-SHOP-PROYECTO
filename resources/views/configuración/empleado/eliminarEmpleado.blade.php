@extends('layouts.app')

@section('title', 'Eliminar Empleado | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('empleado') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Empleado</h2>

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
    <form id="buscarEmpleadoForm" method="GET" action="{{ route('empleado.eliminar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, identificación o cargo..." value="{{ old('busqueda', request('busqueda')) }}">
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

    {{-- Formulario de eliminación --}}
    @if(isset($empleadoSeleccionado))
    <form action="{{ route('empleado.destroy', $empleadoSeleccionado->idEmpleado) }}" method="POST">
        @csrf
        @method('DELETE')

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
            <label>Cargo:</label>
            <input type="text" value="{{ $empleadoSeleccionado->cargo->nombreCargo ?? '' }}" readonly>
        </div>
        <div>
            <label>Fecha Vinculación:</label>
            <input type="text" value="{{ $empleadoSeleccionado->fechaVinculacionEmpleado }}" readonly>
        </div>
        <div>
            <label>Número Contrato:</label>
            <input type="text" value="{{ $empleadoSeleccionado->numeroContrato }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <input type="text" value="{{ $empleadoSeleccionado->estado->nombreEstado ?? '' }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este empleado?')">Eliminar</button>
            <a href="{{ route('empleado') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un empleado para eliminar.</p>
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
        // Desvanecer mensaje de éxito
        const mensaje = document.querySelector('.mensaje-exito');
        if(mensaje){
            setTimeout(() => {
                mensaje.style.transition = 'opacity 0.5s';
                mensaje.style.opacity = '0';
                setTimeout(() => mensaje.style.display = 'none', 500);
            }, 2000);
        }
    });
</script>
@endpush