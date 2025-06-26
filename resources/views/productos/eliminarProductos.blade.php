@extends('layouts.app')

@section('title', 'Eliminar Producto | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
<link rel="stylesheet" href="{{ asset('css/modificar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <a href="{{ route('productos') }}" class="volver-flecha" title="Volver"></a>
    <h2>Eliminar Producto</h2>

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
    <form id="buscarProductoForm" method="GET" action="{{ route('productos.eliminar') }}">
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

    {{-- Formulario de eliminación --}}
    @if(isset($productoSeleccionado))
    <form action="{{ route('productos.destroy', $productoSeleccionado->codProducto) }}" method="POST">
        @csrf
        @method('DELETE')

        <div>
            <label>ID:</label>
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
            <label>Descripción:</label>
            <input type="text" value="{{ $productoSeleccionado->descripcionProducto }}" readonly>
        </div>
        <div>
            <label>Precio:</label>
            <input type="text" value="{{ $productoSeleccionado->precioCompra }}" readonly>
        </div>
        <div>
            <label>Stock:</label>
            <input type="text" value="{{ $productoSeleccionado->cantidadDisponible }}" readonly>
        </div>

        <div class="botones-accion">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
            <a href="{{ route('productos') }}" class="btn">Cancelar</a>
        </div>
    </form>
    @else
        <p style="margin-top:20px;">Selecciona un producto para eliminar.</p>
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