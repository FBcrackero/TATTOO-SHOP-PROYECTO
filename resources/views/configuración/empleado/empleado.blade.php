@extends('layouts.app')

@section('title', 'Empleados | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<div class="productos-section">
    <div class="admin-productos">
        <h1 class="admin-productos-titulo">Empleados</h1>
        <p class="admin-productos-subtitulo">
            Administra los empleados del sistema
        </p>
        <div class="admin-productos-botones">
            <a href="{{ route('empleado.ingresar') }}" class="admin-btn">Ingresar Empleado</a>
            <a href="{{ route('empleado.modificar') }}" class="admin-btn">Modificar Empleado</a>
            <a href="{{ route('empleado.eliminar') }}" class="admin-btn">Eliminar Empleado</a>
            <a href="{{ route('empleado.consultar') }}" class="admin-btn">Consultar Empleado</a>
            <a href="{{ route('empleado.estado') }}" class="admin-btn">Estado de Empleado</a>
        </div>
    </div>
</div>
@endsection