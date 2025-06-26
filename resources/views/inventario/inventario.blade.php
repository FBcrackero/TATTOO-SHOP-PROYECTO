@extends('layouts.app')

@section('title', 'Inventario | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    {{-- Panel ADMIN y EMPLEADO --}}
    @if(Auth::check() && (Auth::user()->idPerfil == 1 || Auth::user()->idPerfil == 3))
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Administrar Inventario</h1>
        <p class="admin-productos-subtitulo">
            Gestiona el inventario de productos (Kardex) de manera eficiente.
        </p>
        <div class="admin-productos-botones">
            <a href="{{ route('inventario.entrada') }}" class="admin-btn">Entrada de inventario</a>
            <a href="{{ route('inventario.kardex') }}" class="admin-btn">Consultar Kardex</a>
        </div>
    </div>
    @else
        <div class="mensaje-exito" style="margin:40px auto;text-align:center;">
            No tienes permisos para ver esta sección.
        </div>
    @endif
</div>
@endsection