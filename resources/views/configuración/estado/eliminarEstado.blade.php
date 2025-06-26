@extends('layouts.app')

@section('title', 'Eliminar Estado | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('estado') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Estado</h2>

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
    <form id="buscarEstadoForm" method="GET" action="{{ route('estado.eliminar') }}">
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

    {{-- Formulario de eliminación --}}
    @if(isset($estadoSeleccionado))
    <form action="{{ route('estado.destroy', $estadoSeleccionado->idEstado) }}" method="POST">
        @csrf
        @method('DELETE')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $estadoSeleccionado->idEstado }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $estadoSeleccionado->nombreEstado }}" readonly>
        </div>
        <div>
            <label>Nomenclatura:</label>
            <input type="text" value="{{ $estadoSeleccionado->nomenclaturaEstado }}" readonly>
        </div>
        <div>
            <label>Descripción:</label>
            <input type="text" value="{{ $estadoSeleccionado->descripcionEstado }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este estado?')">Eliminar</button>
            <a href="{{ route('estado') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un estado para eliminar.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('estado_id');
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