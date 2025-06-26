@extends('layouts.app')

@section('title', 'Formas de Pago | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Formas de Pago</h1>
        <p class="admin-productos-subtitulo">
            Administra las formas de pago del sistema
        </p>
        <div class="admin-productos-botones">
            <a href="{{ route('formaPago.ingresar') }}" class="admin-btn">Ingresar Forma de Pago</a>
            <a href="{{ route('formaPago.modificar') }}" class="admin-btn">Modificar Forma de Pago</a>
            <a href="{{ route('formaPago.eliminar') }}" class="admin-btn">Eliminar Forma de Pago</a>
            <a href="{{ route('formaPago.consultar') }}" class="admin-btn">Consultar Forma de Pago</a>
            <a href="{{ route('formaPago.estado') }}" class="admin-btn">Estado Forma de Pago</a>
        </div>
    </div>
</div>
@endsection