@extends('layouts.app')

@section('title', 'Categorías | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Categorías</h1>
        <p class="admin-productos-subtitulo">
            Administra las categorías del sistema
        </p>
        <div class="admin-productos-botones">
            <a href="{{ route('categoria.ingresar') }}" class="admin-btn">Ingresar Categoria</a>
            <a href="{{ route('categoria.modificar') }}" class="admin-btn">Modificar Categoria</a>
            <a href="{{ route('categoria.eliminar') }}" class="admin-btn">Eliminar Categoria</a>
            <a href="{{ route('categoria.consultar') }}" class="admin-btn">Consultar Categoria</a>
            <a href="{{ route('categoria.estado') }}" class="admin-btn">Estado Categoria</a>
        </div>
    </div>
</div>
@endsection
