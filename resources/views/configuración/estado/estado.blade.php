@extends('layouts.app')

@section('title', 'Estados | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Estados</h1>
        <p class="admin-productos-subtitulo">
            Administra los estados del sistema
        </p>
        <div class="admin-productos-botones">
            <a href="{{ route('estado.ingresar') }}" class="admin-btn">Ingresar Estado</a>
            <a href="{{ route('estado.modificar') }}" class="admin-btn">Modificar Estado</a>
            <a href="{{ route('estado.eliminar') }}" class="admin-btn">Eliminar Estado</a>
            <a href="{{ route('estado.consultar') }}" class="admin-btn">Consultar Estado</a>
        </div>
    </div>
</div>
@endsection