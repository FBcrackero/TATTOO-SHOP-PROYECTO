@extends('layouts.app')

@section('title', 'Cargos | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Cargos</h1>
        <p class="admin-productos-subtitulo">
            Administra los cargos del sistema
        </p>
        <div class="admin-productos-botones">
            <a href="{{ route('cargo.ingresar') }}" class="admin-btn">Ingresar Cargo</a>
            <a href="{{ route('cargo.modificar') }}" class="admin-btn">Modificar Cargo</a>
            <a href="{{ route('cargo.eliminar') }}" class="admin-btn">Eliminar Cargo</a>
            <a href="{{ route('cargo.consultar') }}" class="admin-btn">Consultar Cargo</a>
            <a href="{{ route('cargo.estado') }}" class="admin-btn">Estado Cargo</a>
        </div>
    </div>
</div>
@endsection