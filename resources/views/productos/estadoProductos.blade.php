@extends('layouts.app')

@section('title', 'Estado del Producto | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('productos') }}" class="volver-flecha" title="Volver"></a>
    <h2>Cambiar Estado del Producto</h2>

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
    <form id="buscarProductoForm" method="GET" action="{{ route('productos.estado') }}">
        <div class="busqueda-servicio">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por nombre, ID o nomenclatura..." value="{{ old('busqueda', request('busqueda')) }}">
            <select name="producto_id" id="producto_id">
                <option value="">Selecciona un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->codProducto }}" {{ (request('producto_id') == $producto->codProducto) ? 'selected' : '' }}>
                        {{ $producto->nombreProducto }} (ID: {{ $producto->codProducto }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn">Buscar</button>
            <hr class="divisor-modificar">
        </div>
    </form>

    {{-- Formulario de cambio de estado --}}
    @if(isset($productoSeleccionado))
    <form action="{{ route('productos.estado.update', $productoSeleccionado->codProducto) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Código:</label>
            <input type="text" value="{{ $productoSeleccionado->codProducto }}" readonly>
        </div>
        <div>
            <label>Nombre:</label>
            <input type="text" value="{{ $productoSeleccionado->nombreProducto }}" readonly>
        </div>
        <div>
            <label>Nomenclatura:</label>
            <input type="text" value="{{ $productoSeleccionado->nomenclaturaProducto }}" readonly>
        </div>
        <div>
            <label>Estado:</label>
            <select name="idEstado" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ $productoSeleccionado->idEstado == $estado->idEstado ? 'selected' : '' }}>
                        {{ $estado->nombreEstado }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="botones-accion">
            <button type="submit" class="btn btn-success">Actualizar Estado</button>
            <a href="{{ route('productos') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un producto para cambiar su estado.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('producto_id');
        if(select){
            select.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endpush