
@extends('layouts.app')

@section('title', 'Configuración | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Configuración General</h1>
        <p class="admin-productos-subtitulo">
            Administra la configuración de TATTOO SHOP
        </p>
        <div class="admin-productos-botones">
            <a href="{{ url('/configuracion/empleado') }}" class="admin-btn">Empleado</a>
            <a href="{{ url('/configuracion/cargo') }}" class="admin-btn">Cargo</a>
            <a href="{{ url('/configuracion/categoria') }}" class="admin-btn">Categoría</a>
            <a href="{{ url('/configuracion/estado') }}" class="admin-btn">Estado</a>
            <a href="{{ url('/configuracion/tipodocumento') }}" class="admin-btn">Tipo de Documento</a>
            <a href="{{ url('/configuracion/formaPago') }}" class="admin-btn">Forma de Pago</a>

        </div>
    </div>
</div>
@endsection