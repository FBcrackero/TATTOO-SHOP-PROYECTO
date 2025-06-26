@extends('layouts.app')

@section('title', 'Consultar Productos | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultar.css') }}">
@endpush

@section('content')
<div class="consultar-container">
    <a href="{{ route('productos') }}" class="volver-flecha" title="Volver"></a>
    <h2>Consultar Productos</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('productos.consultar') }}" class="filtros-form">
        <div class="filtros-opciones">
            <label><input type="radio" name="filtro" value="nombre" {{ request('filtro', 'nombre') == 'nombre' ? 'checked' : '' }}> Nombre</label>
            <label><input type="radio" name="filtro" value="codigo" {{ request('filtro') == 'codigo' ? 'checked' : '' }}> Código</label>
            <label><input type="radio" name="filtro" value="general" {{ request('filtro') == 'general' ? 'checked' : '' }}> General</label>
        </div>
        <div class="filtros-busqueda">
            <input type="text" name="busqueda" placeholder="Buscar" value="{{ request('busqueda') }}">
            <button type="submit" class="btn btn-buscar">Buscar</button>
            <button type="submit" name="limpiar" value="1" class="btn btn-limpiar">Limpiar</button>
            <a href="{{ route('productos.consultar.reporte', request()->all()) }}" class="btn btn-reporte" target="_blank">Reporte</a>
        </div>
    </form>

    {{-- Tabla de productos --}}
    <div class="tabla-servicios">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Nomenclatura</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ str_pad($producto->codProducto, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $producto->nombreProducto }}</td>
                        <td>{{ $producto->descripcionProducto }}</td>
                        <td>{{ $producto->nomenclaturaProducto }}</td>
                        <td>${{ number_format($producto->precioCompra, 0, ',', '.') }}</td>
                        <td>{{ $producto->cantidadDisponible }}</td>
                        <td>{{ $producto->estado ? $producto->estado->nombreEstado : 'Sin estado' }}</td>                @empty
                    <tr>
                        <td colspan="7">No hay productos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection