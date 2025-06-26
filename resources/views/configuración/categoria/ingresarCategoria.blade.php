@extends('layouts.app')

@section('title', 'Ingresar Categoría | Tattoo Shop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ingresar.css') }}">
@endpush

@section('content')
<div class="ingresar-container">
    <h2>Ingresar Categoría</h2>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mensaje-exito">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('categoria.store') }}" method="POST">
        @csrf

        {{-- Nombre de la categoría --}}
        <div>
            <label for="nombreCategoriaProducto">Nombre de la Categoría</label>
            <input type="text" id="nombreCategoriaProducto" name="nombreCategoriaProducto" required maxlength="40" value="{{ old('nombreCategoriaProducto') }}">
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcionCategoriaProducto">Descripción</label>
            <input type="text" id="descripcionCategoriaProducto" name="descripcionCategoriaProducto" required maxlength="100" value="{{ old('descripcionCategoriaProducto') }}">
        </div>

                {{-- Nomenclatura --}}
        <div>
            <label for="nomenclaturaCategoriaProducto">Nomeclatura</label>
            <input type="text" id="nomenclaturaCategoriaProducto" name="nomenclaturaCategoriaProducto" required maxlength="100" value="{{ old('nomenclaturaCategoriaProducto') }}">
        </div>

        {{-- Estado por defecto --}}
        <input type="hidden" name="idEstado" value="1">

        {{-- Botones --}}
        <div class="botones-accion">
            <button type="submit">Guardar Categoría</button>
            <a href="{{ route('categoria') }}" class="btn">Cancelar</a>
        </div>
    </form>
</div>
@endsection
