@extends('layouts.app')

@section('title', 'Tipo de Documento | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    <div class="admin-productos">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mensaje-exito">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="admin-productos-titulo">Tipo de Documento</h1>
        <p class="admin-productos-subtitulo">
            Administra los Tipos de Documento del sistema
        </p>
        <div class="admin-productos-botones">
            {{-- Botones de acción --}}
            <a href="{{ route('tipodocumento.ingresar') }}" class="admin-btn">Ingresar T. Documento</a>
            <a href="{{ route('tipodocumento.modificar') }}" class="admin-btn">Modificar T. Documento</a>
            <a href="{{ route('tipodocumento.eliminar') }}" class="admin-btn">Eliminar T. Documento</a>
            <a href="{{ route('tipodocumento.consultar') }}" class="admin-btn">Consultar T. Documento</a>
            <a href="{{ route('tipodocumento.estado') }}" class="admin-btn">Estado de T. Documento</a>
        </div>
    </div>
</div>
@endsection
