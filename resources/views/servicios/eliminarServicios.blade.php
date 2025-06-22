@extends('layouts.app')

@section('title', 'Eliminar Servicio | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('servicios') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Servicio</h2>

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
    <form id="buscarServicioForm" method="GET" action="{{ route('servicios.eliminar') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="servicio_id" id="servicio_id">
                <option value="">Selecciona un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->idServicio }}" {{ (request('servicio_id') == $servicio->idServicio) ? 'selected' : '' }}>
                        {{ $servicio->nombreServicio }} (ID: {{ $servicio->idServicio }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de eliminación --}}
    @if(isset($servicioSeleccionado))
    <form action="{{ route('servicios.destroy', $servicioSeleccionado->idServicio) }}" method="POST">
        @csrf
        @method('DELETE')

        <div>
            <label>ID:</label>
            <input type="text" value="{{ $servicioSeleccionado->idServicio }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $servicioSeleccionado->nombreServicio }}" readonly>
        </div>
        <div>
            <label>Nomenclatura:</label>
            <input type="text" value="{{ $servicioSeleccionado->nomenclaturaServicio }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="{{ route('servicios') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un servicio para eliminar.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('servicio_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush