@extends('layouts.app')

@section('title', 'Resultados de búsqueda | Tattoo Shop')

@section('content')
<div class="busqueda-section">
    <h1 class="busqueda-titulo">Resultados para: <span style="color:#bfa94a">{{ $q }}</span></h1>
    <div class="busqueda-resultados">
        <h2 class="busqueda-subtitulo">Servicios</h2>
        @if($servicios->count())
            <div class="servicios-grid">
                @foreach($servicios as $servicio)
                    <div class="servicio-card">
                        <img src="{{ asset('imagenes/imgServicios/' . ($servicio->imagenServicio ?? 'tatuaje-ejemplo.jpg')) }}" alt="Imagen servicio" class="servicio-img">
                        <div class="servicio-info">
                            <span class="servicio-nombre">{{ strtoupper($servicio->nombreServicio) }}</span>
                            <hr class="servicio-divisor">
                            <p class="servicio-desc">{{ $servicio->descripcionServicio }}</p>
                            <div class="servicio-precio-btn">
                                <a href="{{ url('/reservas') }}" class="servicio-btn">RESERVAR CITA</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No se encontraron servicios.</p>
        @endif

        <h2 class="busqueda-subtitulo">Productos</h2>
        @if($productos->count())
            <div class="productos-grid">
                @foreach($productos as $producto)
                    <div class="producto-card">
                        <img src="{{ asset('imagenes/imgProductos/' . ($producto->imagenProducto ?? 'producto-ejemplo.jpg')) }}" alt="Imagen producto" class="producto-img">
                        <div class="producto-info">
                            <span class="producto-nombre">{{ strtoupper($producto->nombreProducto) }}</span>
                            <hr class="producto-divisor">
                            <p class="producto-desc">{{ $producto->descripcionProducto }}</p>
                            <div class="producto-precio-btn">
                                <span class="producto-precio">${{ number_format($producto->precioCompra, 0, ',', '.') }}</span>
                                <a href="#" class="producto-btn">COMPRAR</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No se encontraron productos.</p>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/busqueda.css') }}">
@endpush
